<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
     protected $fillable = ['name', 'class_id'];

    public function classes()
    {
        return $this->belongsTo(Classes::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
