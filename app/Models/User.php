<?php
namespace App\Models;

use Fenos\Notifynder\Notifable;
use Illuminate\Notifications\Notifiable;
use Cache;
use DB;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class User extends Authenticatable
{
    use Notifiable, EntrustUserTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'address', 'personal_number', 'work_number', 'image_path', 'college_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $dates = ['trial_ends_at', 'subscription_ends_at'];
    protected $hidden = ['password', 'password_confirmation', 'remember_token'];


    protected $primaryKey = 'id';

    public function tasks()
    {
        return $this->hasMany(Task::class, 'user_assigned_id', 'id');
    }

    public function recruits()
    {
        return $this->hasMany(Recruit::class, 'user_id', 'id');
    }
    
    public function departments()
    {

        return $this->belongsToMany(Department::class, 'department_user', 'user_id', 'department_id');        
        /*
        $user_id = $this->id;//Session::get('user_id');
        $results = DB::select( DB::raw("SELECT departments.* FROM department_user LEFT JOIN departments ON department_user.`department_id` = departments.id WHERE user_id = :user_id"), array('user_id' => $user_id));
        */
        /*
        Log::debug("department():: raw db select results" . json_encode($results));   
        Log::debug("this->id " . $this->id);
          
        Log::debug("this->belongsToMany(Department::class, 'department_user') " . json_encode($this->belongsToMany(Department::class, 'department_user')));
        Log::debug("this->belongsToMany(Department::class, 'department_user', 'department_id', 'user_id')) " . json_encode($this->belongsToMany(Department::class, 'department_user', 'department_id', 'user_id')));
        Log::debug("this->belongsToMany(Department::class, 'department_user', 'user_id', 'department_id')) " . json_encode($this->belongsToMany(Department::class, 'department_user', 'user_id', 'department_id')));
        */
        //return $results;    

        //return $this->belongsToMany(Department::class, 'department_user')->withPivot('department_id');
    }

    public function userRole()
    {
        return $this->hasOne(RoleUser::class, 'user_id', 'id');
    }

    public function college() {
        return $this->belongsTo(College::class, 'college_id');
    }

    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }

    public function getNameAndDepartmentAttribute()
    {
        Log::debug("getNameAndDepartmentAttribute - " . json_encode($this));
        Log::debug("this->departments()->first() " . json_encode($this->departments()->first()));
        $department_result = $this->departments()->first();
        $department_text = $department_result != null ? ' (' . $department_result->name . ')' : ''; 
        return $this->name . $department_text;
        /*
        $department_result = $this->departments();
        $department_for_user = $department_result != null && count($department_result) > 0 ? ' (' . $department_result[0]->name . ')' : '';
        return $this->name . $department_for_user;
        */
    }
    
    public function moveTasks($user_id)
    {
        $tasks = $this->tasks()->get();
        foreach ($tasks as $task) {
            $task->user_assigned_id = $user_id;
            $task->save();
        }
    }

    public function moveRecruits($user_id)
    {
        $recruits = $this->recruits()->get();
        foreach ($recruits as $recruit) {
            $recruit->user_assigned_id = $user_id;
            $recruit->save();
        }
    }

    public function moveAthletes($user_id)
    {
        $athletes = $this->athletes()->get();
        foreach ($athletes as $athlete) {
            $athlete->user_id = $user_id;
            $athlete->save();
        }
    }

    public function getAvatarattribute()
    {
        $setting = Setting::first();
        return $this->image_path ? 'images/' . $setting->company . '/' . $this->image_path : 'images/profile_120x120.svg';
    }

    /**
     * @param $recruit_id
     * @return static
     */
    public function hasRecruitAccess($recruit_id) {
        $recruit = Recruit::where('id', $recruit_id)->first();
        return $recruit != null && $recruit->college_id == Session::get('college_id');
    }
}
