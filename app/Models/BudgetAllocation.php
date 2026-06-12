<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetAllocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'monthly_budget_id',
        'jenis_schedule_id',
        'nominal_limit',
        'catatan'
    ];

    public function monthlyBudget()
    {
        return $this->belongsTo(MonthlyBudget::class, 'monthly_budget_id');
    }

    public function jenisSchedule()
    {
        return $this->belongsTo(JenisSchedule::class, 'jenis_schedule_id');
    }
}
