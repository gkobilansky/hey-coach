<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'colleges';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $dates = ['dt_created'];

    protected $primaryKey = 'id';

    public function users()
    {
        return $this->hasMany(User::class, 'college_id', 'id');
    }
}