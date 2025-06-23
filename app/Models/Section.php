<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['class_id', 'name', 'description'];

    public function class() {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}
