<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
     protected $guarded = ['id'];
     public function classes()
{
    return $this->belongsTo(Classes::class, 'class_id');
}
}
