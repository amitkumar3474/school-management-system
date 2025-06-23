<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceDay extends Model
{
    protected $guarded = [];

    public function enrollment() {
        return $this->belongsTo(StudentEnrollment::class, 'enroll_id');
    }
}
