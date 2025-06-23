<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [];

    public function detail()
    {
        return $this->hasOne(StudentDetail::class);
    }

    public function enrollment()
    {
        return $this->hasOne(StudentEnrollment::class);
    }
    
    public function guardianDetail()
    {
        return $this->hasOne(StudentGuardianDetail::class);
    }
}
