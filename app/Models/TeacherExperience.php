<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherExperience extends Model
{
    protected $fillable = [
        'teacher_id', 'school_name', 'position', 'from_date', 'to_date', 'experience_years'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
