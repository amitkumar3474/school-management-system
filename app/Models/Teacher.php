<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id', 'staff_id', 'name', 'gender', 'dob', 'phone', 'email',
        'joining_date', 'address', 'blood_group', 'religion', 'marital_status', 'photo', 'status'
    ];

    public function qualifications()
    {
        return $this->hasMany(TeacherQualification::class);
    }

    public function experiences()
    {
        return $this->hasMany(TeacherExperience::class);
    }

    public function classSubjects()
    {
        return $this->hasMany(TeacherClassSubject::class);
    }
}
