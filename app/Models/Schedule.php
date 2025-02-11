<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public function apiLibur(){
        return $this->hasOne(apiLibur::class);
    }

    protected $fillable = ['name', 'date', 'note', 'reminder_date', 'berulang'];

    // public function customDates(){
    //     return $this->hasMany(CustomDate::class, 'schedule_id', 'id');
    // }
    
}
