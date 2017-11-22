<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Athlete extends Model
{

    protected $fillable = [
        'name',
        'company_name',
        'vat',
        'email',
        'address',
        'zipcode',
        'city',
        'primary_number',
        'secondary_number',
        'industry_id',
        'company_type',
        'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

   public function tasks()
    {
        return $this->hasMany(Task::class, 'athlete_id', 'id')
            ->orderBy('status', 'asc')
            ->orderBy('created_at', 'desc');
    }

    public function recruits()
    {
        return $this->hasMany(Recruit::class, 'athlete_id', 'id')
            ->orderBy('status_id', 'asc')
            ->orderBy('created_at', 'desc');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'athlete_id', 'id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function getAssignedUserAttribute()
    {
        return User::findOrFail($this->user_id);
    }
}
