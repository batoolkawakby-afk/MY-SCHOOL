<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    

    protected $fillable = [
        'teacher_id',
        'subject_id',
        'section_id',
        'class_id',
        'day',
        'period'
    ];

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function section() {
        return $this->belongsTo(Section::class);
    }
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

}
