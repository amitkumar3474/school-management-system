<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'code'];

    public function classes() {
        return $this->belongsToMany(ClassModel::class, 'class_subjects', 'subject_id', 'class_id')->withTimestamps();
    }
}
