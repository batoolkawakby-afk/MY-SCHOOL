<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
     

 protected $fillable = [
        'firstName',
        'lastName',
        'dateOfBirth',
        'personalPhoto',
        'subject_id',
        'class_id',
        'division',
        'mobile',
        'gender',
        'password',
    ];

    // 🔗 العلاقات
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function Classes()
    {
        return $this->belongsTo(Classes::class,'class_id');
    }
    

}
