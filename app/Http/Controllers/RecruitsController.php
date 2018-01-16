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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('recruits.create')
            ->withUsers($this->users->getAllUsersWithDepartments())
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
        $getInsertedId = $this->recruits->create($request);
        Session()->flash('flash_message', 'Recruit is created');
        return redirect()->route('recruits.show', $getInsertedId);
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
        return view('recruits.show')
            ->withrecruit($this->recruits->find($id))
            ->withUsers($this->users->getAllUsersWithDepartments())
            ->withCompanyname($this->settings->getCompanyName());
    }

    /**
     * Complete recruit
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function updateStatus($id, Request $request)
    {
        $this->recruits->updateStatus($id, $request);
        Session()->flash('flash_message', 'Recruiting status updated');
        return redirect()->back();
    }
}
