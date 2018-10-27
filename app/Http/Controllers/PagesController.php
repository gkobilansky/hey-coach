<?php
namespace App\Http\Controllers;

use DB;
use Carbon;
use App\Http\Requests;
use App\Repositories\Task\TaskRepositoryContract;
use App\Repositories\Recruit\RecruitRepositoryContract;
use App\Repositories\User\UserRepositoryContract;
use App\Repositories\Status\StatusRepositoryContract;
use App\Repositories\Athlete\AthleteRepositoryContract;
use App\Repositories\Setting\SettingRepositoryContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PagesController extends Controller
{

    protected $users;
    protected $athletes;
    protected $settings;
    protected $tasks;
    protected $recruits;
    protected $statuses;

    public function __construct(
        UserRepositoryContract $users,
        AthleteRepositoryContract $athletes,
        SettingRepositoryContract $settings,
        StatusRepositoryContract $statuses,
        TaskRepositoryContract $tasks,
        RecruitRepositoryContract $recruits
    ) {
        $this->users = $users;
        $this->athletes = $athletes;
        $this->settings = $settings;
        $this->statuses = $statuses;
        $this->tasks = $tasks;
        $this->recruits = $recruits;
    }

    /**
     * Dashobard view
     * @return mixed
     */
    public function dashboard()
    {

      /**
         * Other Statistics
         *
         */
        Log::debug("PagesController:: user id " . Session::get('user_id') . ' - college id ' .  Session::get('college_id'));

        $userId = Auth::id();
        $this_user = $this->users->find($userId);
        $college_id = $this_user->college_id;
        $allStatuses = $this->statuses->getAllStatuses();
        $statusNames = $this->statuses->getStatusNames();
        $companyname = $this->settings->getCompanyName();
        $role = Session::get('role');
        $users = $this->users->getAllUsersForCollege($college_id);
        $totalAthletes = $this->athletes->getAllAthletesCount();
        $totalTimeSpent = $this->tasks->totalTimeSpent();

    /**
      * Data for pipelines.
      *
      */

        //$recruitRecords = $this->recruits->getAllRecruits();
        $recruitRecords = $this->recruits->getAllRecruitsForCollege($college_id);
     /**
      * Statistics for all-time tasks.
      *
      */
        $alltasks = $this->tasks->tasks();
        $allCompletedTasks = $this->tasks->allCompletedTasks();
        $totalPercentageTasks = $this->tasks->percantageCompleted();

     /**
      * Statistics for today tasks.
      *
      */
        $completedTasksToday =  $this->tasks->completedTasksToday();
        $createdTasksToday = $this->tasks->createdTasksToday();

     /**
      * Statistics for tasks this month.
      *
      */
         $taskCompletedThisMonth = $this->tasks->completedTasksThisMonth();
    

     /**
      * Statistics for tasks each month(For Charts).
      *
      */
        $createdTasksMonthly = $this->tasks->createdTasksMothly();
        $completedTasksMonthly = $this->tasks->completedTasksMothly();

     /**
      * Statistics for all-time Recruits.
      *
      */
     
        //$allRecruits = $this->recruits->recruits();
        $allRecruits = $this->recruits->getAllRecruitsForCollege($college_id);
        $allCompletedRecruits = $this->recruits->allCompletedRecruits();
        $totalPercentageRecruits = $this->recruits->percantageCompleted();
     /**
      * Statistics for today recruits.
      *
      */
        $completedRecruitsToday = $this->recruits->completedRecruitsToday();
        $createdRecruitsToday = $this->recruits->completedRecruitsToday();

     /**
      * Statistics for recruits this month.
      *
      */
        $recruitCompletedThisMonth = $this->recruits->completedRecruitsThisMonth();

     /**
      * Statistics for recruits each month(For Charts).
      *
      */
        $completedRecruitsMonthly = $this->recruits->createdRecruitsMonthly();
        $createdRecruitsMonthly = $this->recruits->completedRecruitsMonthly();

      /**
      * if super admin, then get all as opposed to all in college for these things
      */
        if($role->name == 'super_administrator') {

          $users = $this->users->getAllUsers();
          $allRecruits = $this->recruits->getAllRecruits();
          $recruitRecords = $this->recruits->getAllRecruits();
        }      
       
        return view('pages.dashboard', compact(
            'completedTasksToday',
            'completedRecruitsToday',
            'createdTasksToday',
            'createdRecruitsToday',
            'createdTasksMonthly',
            'completedTasksMonthly',
            'completedRecruitsMonthly',
            'createdRecruitsMonthly',
            'taskCompletedThisMonth',
            'recruitCompletedThisMonth',
            'totalTimeSpent',
            'totalAthletes',
            'users',
            'companyname',
            'alltasks',
            'allStatuses',
            'statusNames',
            'allCompletedTasks',
            'totalPercentageTasks',
            'allRecruits',
            'recruitRecords',
            'allCompletedRecruits',
            'totalPercentageRecruits'
        ));
    }
}
