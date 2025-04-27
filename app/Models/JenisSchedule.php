<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSchedule extends Model
{
    public function Schedule()
    {
        return $this->hasMany(Schedule::class);
    }
}
