<?php
namespace App\Http\Controllers;

use DB;
use Auth;
use Carbon;
use Session;
use Datatables;
use App\Models\Recruit;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\Recruit\StoreRecruitRequest;
use App\Repositories\Recruit\RecruitRepositoryContract;
use App\Repositories\Status\StatusRepositoryContract;
use App\Repositories\User\UserRepositoryContract;
use App\Http\Requests\Recruit\UpdateRecruitFollowUpRequest;
use App\Repositories\Athlete\AthleteRepositoryContract;
use App\Repositories\Setting\SettingRepositoryContract;
use Illuminate\Support\Facades\Log;

class RecruitsController extends Controller
{
    protected $recruits;
    protected $athletes;
    protected $settings;
    protected $statuses;
    protected $users;

    public function __construct(
        RecruitRepositoryContract $recruits,
        UserRepositoryContract $users,
        AthleteRepositoryContract $athletes,
        SettingRepositoryContract $settings,
        StatusRepositoryContract $statuses
    )
    {
        $this->users = $users;
        $this->settings = $settings;
        $this->athletes = $athletes;
        $this->recruits = $recruits;
        $this->statuses = $statuses;
        $this->middleware('recruit.create', ['only' => ['create']]);
        $this->middleware('recruit.assigned', ['only' => ['updateAssign']]);
        $this->middleware('recruit.update.status', ['only' => ['updateStatus']]);
        $this->middleware('recruit.show', ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('recruits.index');
    }

      /**
     * Recruits plus Athletes
     *
     * @return mixed
     */
    public function athleteData()
    {
        $recruitRecords = $this->recruits->getAllRecruits();
        return response()->json($recruitRecords);
    }

    public function recruitDataBySchool() {
        $recruitRecords = $this->recruits->getAllRecruitsForCollege(Session::get('college_id'));
        Log::debug("recruitDataBySchool " . json_encode($recruitRecords));
        //$recruitRecords = $this->recruits->getAllRecruits();
        return response()->json($recruitRecords);        
    }

    /**
     * Data for Data tables
     * @return mixed
     */
    public function anyData()
    {
        $recruits = Recruit::all();
        return Datatables::of($recruits)
            ->editColumn('status_id', function ($recruits) {
                return $recruits->status->name;
            })
            ->addColumn('titlelink', function ($recruits) {
                return '<a href="recruits/' . $recruits->id . '" ">' . $recruits->title . '</a>';
            })
            ->editColumn('athlete_id', function ($recruits) {
                return $recruits->athlete->name;
            })
            ->editColumn('user_created_id', function ($recruits) {
                return $recruits->creator->name;
            })
            ->editColumn('contact_date', function ($recruits) {
                return $recruits->contact_date ? with(new Carbon($recruits->contact_date))
                    ->format('d/m/Y') : '';
            })
            ->editColumn('user_assigned_id', function ($recruits) {
                return $recruits->user->name;
            })->make(true);
    }

    /**
     * Data for Data tables of session's college_id
     * @return mixed
     */
    public function anyDataByCollege()
    {
        $college_id = Session::get('college_id');        
        $recruits = $college_id == null || $college_id == '' ? Recruit::all() : Recruit::where('college_id', $college_id)->get();
        return Datatables::of($recruits)
            ->editColumn('status_id', function ($recruits) {
                return $recruits->status->name;
            })
            ->addColumn('titlelink', function ($recruits) {
                return '<a href="recruits/' . $recruits->id . '" ">' . $recruits->title . '</a>';
            })
            ->editColumn('athlete_id', function ($recruits) {
                return $recruits->athlete->name;
            })
            ->editColumn('user_created_id', function ($recruits) {
                return $recruits->creator->name;
            })
            ->editColumn('contact_date', function ($recruits) {
                return $recruits->contact_date ? with(new Carbon($recruits->contact_date))
                    ->format('d/m/Y') : '';
            })
            ->editColumn('user_assigned_id', function ($recruits) {
                return $recruits->user->name;
            })->make(true);
    }    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $college_id = Session::get('college_id');
        return view('recruits.create')
            ->withUsers($this->users->getAllUsersForCollegeWithDepartments($college_id))
            ->withAthletes($this->athletes->listAllathletes())
            ->withStatuses($this->statuses->getStatusNames());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRecruitRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRecruitRequest $request)
    {
       // $getInsertedId = $this->recruits->create($request);
        $data = new Recruit();
        $data->title = $request['title'];
        $data->description = $request['description'];
        $data->status_id = 1;
        $data->user_assigned_id = $request['user_assigned_id'];
        $data->athlete_id = $request['athlete_id'];
        $data->college_id = Session::get('college_id');
        $data->user_created_id = $request['user_created_id'];
        $data->contact_date = Carbon::now();
        $data->save();
        Session()->flash('flash_message', 'Recruit is created');
        // return redirect()->route('recruits.show', $getInsertedId);
    }

    public function updateAssign($id, Request $request)
    {
        $this->recruits->updateAssign($id, $request);
        Session()->flash('flash_message', 'New user is assigned');
        return redirect()->back();
    }

    /**
     * Update the follow up date (Deadline)
     * @param UpdateRecruitFollowUpRequest $request
     * @param $id
     * @return mixed
     */
    public function updateFollowup(UpdateRecruitFollowUpRequest $request, $id)
    {
        $this->recruits->updateFollowup($id, $request);
        Session()->flash('flash_message', 'New follow up date is set');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $college_id = Session::get('college_id');
        return view('recruits.show')
            ->withrecruit($this->recruits->find($id))
            ->withUsers($this->users->getAllUsersForCollegeWithDepartments($college_id))
            ->withCompanyname($this->settings->getCompanyName());
    }

    /**
     * Complete recruit
     * @param $id
     * @param Request $request
     * @return mixed
     */
    /*
    public function updateStatus($id, Request $request)
    {
        $this->recruits->updateStatus($id, $request);
        Session()->flash('flash_message', 'Recruiting status updated');
        return redirect()->back();
    }
    */

    /**
     * Update Recruit status
     * @param $id
     * @param $status_id
     * @param Request $request
     * @return mixed
     */
    public function updateStatus( Request $request)
    {
        Log::debug("update status now - " . json_encode($request));
        $id = $request->id;
        $status_id = $request->status_id;
        $this->recruits->updateStatus($id, $status_id);
        Session()->flash('flash_message', 'Recruiting status updated');
        return response()->json(true);
    }    
}
