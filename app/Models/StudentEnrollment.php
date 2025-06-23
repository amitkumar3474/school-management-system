<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentEnrollment extends Model
{
    protected $guarded = [];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function academicSession(): BelongsTo
    {
        return $this->belongsTo(AcademicSession::class, 'session_id');
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function promotedFrom(): BelongsTo
    {
        return $this->belongsTo(StudentEnrollment::class, 'promoted_from_id');
    }

    public function attendanceDays()
    {
        return $this->hasMany(AttendanceDay::class, 'enroll_id');
    }

    public function attendanceMonths()
    {
        return $this->hasMany(AttendanceMonth::class, 'enroll_id');
    }

    public function transport()
    {
        return $this->belongsTo(Transport::class, 'route_id');
    }

    public function scopeActiveSession($query)
    {
        return $query->whereHas('academicSession', function ($q) {
            $q->active();
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    public function feeHistories()
    {
        return $this->hasMany(StudentFeeHistory::class, 'enrollment_id');
    }
}
