<?php
namespace App\Http\Controllers;

use DB;
use Carbon;
use App\Http\Requests;
use App\Repositories\Task\TaskRepositoryContract;
use App\Repositories\Recruit\RecruitRepositoryContract;
use App\Repositories\User\UserRepositoryContract;
use App\Repositories\Athlete\AthleteRepositoryContract;
use App\Repositories\Setting\SettingRepositoryContract;

class PagesController extends Controller
{

    protected $users;
    protected $athletes;
    protected $settings;
    protected $tasks;
    protected $recruits;

    public function __construct(
        UserRepositoryContract $users,
        AthleteRepositoryContract $athletes,
        SettingRepositoryContract $settings,
        TaskRepositoryContract $tasks,
        RecruitRepositoryContract $recruits
    ) {
        $this->users = $users;
        $this->athletes = $athletes;
        $this->settings = $settings;
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
        $companyname = $this->settings->getCompanyName();
        $users = $this->users->getAllUsers();
        $totalAthletes = $this->athletes->getAllAthletesCount();
        $totalTimeSpent = $this->tasks->totalTimeSpent();

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
     
        $allrecruits = $this->recruits->recruits();
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
            'allCompletedTasks',
            'totalPercentageTasks',
            'allrecruits',
            'allCompletedRecruits',
            'totalPercentageRecruits'
        ));
    }
}
