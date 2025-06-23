<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    protected $table = 'classes';
    protected $fillable = ['name', 'fee', 'description'];

    public function sections() {
        return $this->hasMany(Section::class, 'class_id');
    }

    public function subjects() {
        return $this->belongsToMany(Subject::class, 'class_subjects', 'class_id', 'subject_id')->withTimestamps();
    }
}
