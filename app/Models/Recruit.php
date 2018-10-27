<?php
namespace App\Models;

use App\Models\Status;
use Illuminate\Database\Eloquent\Model;
use Carbon;

class Recruit extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status_id',
        'user_assigned_id',
        'user_created_id',
        'athlete_id',
        'contact_date',

    ];
    protected $dates = ['contact_date'];

    protected $hidden = ['remember_token'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_assigned_id');
    }

    public function college() {
        return $this->belongsTo(College::class, 'college_id', 'id');
    }    

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_created_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function athlete()
    {
        return $this->belongsTo(Athlete::class, 'athlete_id');
    }
    
    public function comments()
    {
        return $this->morphMany(Comment::class, 'source');
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'source');
    }

    public function getDaysUntilContactAttribute()
    {
        return Carbon\Carbon::now()->startOfDay()->diffInDays($this->contact_date, false);
    }

    /**
     * Add a reply to the thread.
     *
     * @param  array $reply
     * @return Model
     */
    public function addComment($reply)
    {
        $reply = $this->comments()->create($reply);
        return $reply;
    }
}
