<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{

    protected $fillable = [
        'name'
    ];
     public function schedules()
    {
        return $this->hasMany(Schedule::class, 'class_id');
    }

    
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
    public function teachers(){
        return $this->hasMany(Teacher::class,'class_id');
    }
   public function sections()
{
    return $this->hasMany(Section::class,'class_id');
}
}

