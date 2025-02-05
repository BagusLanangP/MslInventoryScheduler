<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public function apiLibur(){
        return $this->hasOne(apiLibur::class);
    }

    // public function customDates(){
    //     return $this->hasMany(CustomDate::class, 'schedule_id', 'id');
    // }
    
}
