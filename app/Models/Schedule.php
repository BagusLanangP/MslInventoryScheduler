<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public function apiLibur(){
        return $this->hasOne(apiLibur::class);
        
    }
    public function jenisSchedule()
    {
        return $this->belongsTo(jenisSchedule::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected $fillable = [
        'name',
        'jenis_schedule_id',
        'berulang',
        'note',
        'date',
        'budget',
        'reminder_date',
        'status',
        'created_by',
        'completed_at',
        'inventory_checking_id'
    ];

    // public function customDates(){
    //     return $this->hasMany(CustomDate::class, 'schedule_id', 'id');
    // }
    
}
