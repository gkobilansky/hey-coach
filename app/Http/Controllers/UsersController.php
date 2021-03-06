<?php
namespace App\Http\Controllers;

use Gate;
use Carbon;
use Datatables;
use Session;
use App\Models\User;
use App\Models\Task;
use App\Http\Requests;
use App\Models\Athlete;
use App\Models\Recruit;
use Illuminate\Http\Request;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Repositories\User\UserRepositoryContract;
use App\Repositories\Role\RoleRepositoryContract;
use App\Repositories\Department\DepartmentRepositoryContract;
use App\Repositories\Setting\SettingRepositoryContract;
use App\Repositories\Task\TaskRepositoryContract;
use App\Repositories\Recruit\RecruitRepositoryContract;
use App\Repositories\College\CollegeRepositoryContract;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    protected $users;
    protected $roles;
    protected $departments;
    protected $settings;
    protected $colleges;

    public function __construct(
        UserRepositoryContract $users,
        RoleRepositoryContract $roles,
        DepartmentRepositoryContract $departments,
        SettingRepositoryContract $settings,
        TaskRepositoryContract $tasks,
        RecruitRepositoryContract $recruits, 
        CollegeRepositoryContract $colleges
    )
    {
        $this->users = $users;
        $this->roles = $roles;
        $this->departments = $departments;
        $this->settings = $settings;
        $this->tasks = $tasks;
        $this->recruits = $recruits;
        $this->colleges = $colleges;
        $this->middleware('user.create', ['only' => ['create']]);
        $this->middleware('user.show', ['only' => ['show']]);
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return view('users.index')->withUsers($this->users);
    }

    public function users()
    {
        return User::all();
    }

    public function anyData()
    {
        $canUpdateUser = auth()->user()->can('update-user');
        if(Session::get('role')->name != 'super_administrator') {
            $college_id = Session::get('college_id');        
            //$users = User::select(['id', 'name', 'email', 'work_number']);
            $users = $college_id == null || $college_id == '' ? User::select(['id', 'name', 'email', 'work_number']) : User::select(['id', 'name', 'email', 'work_number'])->where('college_id', $college_id)->get(); 
        } else {
            $users = User::select(['id', 'name', 'email', 'work_number']);
        }
        return Datatables::of($users)
            ->addColumn('namelink', function ($users) {
                return '<a href="users/' . $users->id . '" ">' . $users->name . '</a>';
            })
            ->addColumn('edit', function ($user) {
                return '<a href="' . route("users.edit", $user->id) . '" class="btn btn-success"> Edit</a>';
            })
            ->add_column('delete', function ($user) { 
                return '<button type="button" class="btn btn-danger delete_athlete" data-athlete_id="' . $user->id . '" onClick="openModal(' . $user->id. ')" id="myBtn">Delete</button>';
            })->make(true);
    }

    /**
     * Json for Data tables
     * @param $id
     * @return mixed
     */
    public function taskData($id)
    {
        $tasks = Task::select(
            ['id', 'title', 'created_at', 'deadline', 'user_assigned_id', 'athlete_id', 'status']
        )
            ->where('user_assigned_id', $id);
        return Datatables::of($tasks)
            ->addColumn('titlelink', function ($tasks) {
                return '<a href="' . route('tasks.show', $tasks->id) . '">' . $tasks->title . '</a>';
            })
            ->editColumn('created_at', function ($tasks) {
                return $tasks->created_at ? with(new Carbon($tasks->created_at))
                    ->format('d/m/Y') : '';
            })
            ->editColumn('deadline', function ($tasks) {
                return $tasks->deadline ? with(new Carbon($tasks->deadline))
                    ->format('d/m/Y') : '';
            })
            ->editColumn('status', function ($tasks) {
                return $tasks->status == 1 ? '<span class="label label-success">Open</span>' : '<span class="label label-danger">Closed</span>';
            })
            ->editColumn('athlete_id', function ($tasks) {
                return $tasks->athlete->name;
            })
            ->make(true);
    }

        /**
     * Json for Data tables
     * @param $id
     * @return mixed
     */
    public function recruitData($id)
    {
        $recruits = Recruit::select(
            ['id', 'title', 'created_at', 'contact_date', 'user_assigned_id', 'athlete_id', 'status_id']
        )
            ->where('user_assigned_id', $id);
        return Datatables::of($recruits)
            ->addColumn('titlelink', function ($recruits) {
                return '<a href="' . route('recruits.show', $recruits->id) . '">' . $recruits->title . '</a>';
            })
            ->editColumn('created_at', function ($recruits) {
                return $recruits->created_at ? with(new Carbon($recruits->created_at))
                    ->format('d/m/Y') : '';
            })
            ->editColumn('contact_date', function ($recruits) {
                return $recruits->contact_date ? with(new Carbon($recruits->contact_date))
                    ->format('d/m/Y') : '';
            })
            ->editColumn('status_id', function ($recruits) {
                return $recruits->status_id < 3 ? '<span class="label label-success">' . $recruits->status->name . '</span>' : '<span class="label label-danger">' . $recruits->status->name . '</span>';
            })
            ->editColumn('athlete_id', function ($tasks) {
                return $tasks->athlete->name;
            })
            ->make(true);
    }

    /**
     * Json for Data tables
     * @param $id
     * @return mixed
     */
    public function athleteData($id)
    {
        $athletes = Athlete::select(['id', 'name', 'company_name', 'primary_number', 'email'])->where('user_id', $id);
        return Datatables::of($athletes)
            ->addColumn('athletelink', function ($athletes) {
                return '<a href="' . route('athletes.show', $athletes->id) . '">' . $athletes->name . '</a>';
            })
            ->editColumn('created_at', function ($athletes) {
                return $athletes->created_at ? with(new Carbon($athletes->created_at))
                    ->format('d/m/Y') : '';
            })
            ->make(true);


      
    }


    /**
     * @return mixed
     */
    public function create()
    {        
        return view('users.create')
            ->withColleges($this->colleges->listAllColleges())
            ->withRoles($this->roles->listAllRoles())
            ->withDepartments($this->departments->listAllDepartments());
    }

    /**
     * @param StoreUserRequest $userRequest
     * @return mixed
     */
    public function store(StoreUserRequest $userRequest)
    {
        Log::debug("attempting to create user " . json_encode($userRequest));
        $college_id = Session::get('college_id');
        $userRequest->merge(['college_id' => $college_id]);     
        $getInsertedId = $this->users->create($userRequest);
        if($getInsertedId == null) {
            return redirect()->route('users.create');
        }
        //$getInsertedId = $this->users->create(array_merge($userRequest->all(), ['college_id' => $college_id]));
        return redirect()->route('users.index');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return view('users.show')
            ->withUser($this->users->find($id))
            ->withCompanyname($this->settings->getCompanyName())
            ->with('task_statistics', $this->tasks->totalOpenAndClosedTasks($id))
            ->with('recruit_statistics', $this->recruits->totalOpenAndClosedrecruits($id));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        return view('users.edit')
            ->withUser($this->users->find($id))
            ->withRoles($this->roles->listAllRoles())
            ->withDepartments($this->departments->listAllDepartments());
    }

    /**
     * @param $id
     * @param UpdateUserRequest $request
     * @return mixed
     */
    public function update($id, UpdateUserRequest $request)
    {
        $this->users->update($id, $request);
        Session()->flash('flash_message', 'User successfully updated');
        return redirect()->back();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy(Request $request, $id)
    {
        $this->users->destroy($request, $id);

        return redirect()->route('users.index');
    }
}
