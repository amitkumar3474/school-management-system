<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherQualification extends Model
{
    protected $fillable = [
        'teacher_id', 'qualification', 'specialization', 'university', 'passing_year', 'grade'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
