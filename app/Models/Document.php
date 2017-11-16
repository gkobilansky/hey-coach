<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['name', 'size', 'path', 'file_display', 'athlete_id'];

    public function athletes()
    {
        $this->belongsTo(Athlete::class, 'athlete_id');
    }
}
