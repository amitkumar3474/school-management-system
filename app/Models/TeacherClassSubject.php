<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherClassSubject extends Model
{
    protected $fillable = ['teacher_id', 'class_id', 'section_id', 'subject_id'];

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }

    public function class() {
        return $this->belongsTo(ClassModel::class); // Use your actual Class model name
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function section() {
        return $this->belongsTo(Section::class);
    }
}
