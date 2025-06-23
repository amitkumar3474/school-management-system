<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentFeeHistory extends Model
{
    protected $fillable = ['enrollment_id', 'label', 'action', 'amount', 'note', 'payment_date'];
    
}
