<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    protected $guarded = [];

    public function subRoutes()
    {
        return $this->hasMany(Transport::class, 'parent_route_id');
    }
}
