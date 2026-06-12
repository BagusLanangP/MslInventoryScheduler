<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyBudget extends Model
{
    use HasFactory;

    protected $fillable = [
        'periode',
        'total_kas',
        'alokasi_anggaran',
        'catatan'
    ];

    public function allocations()
    {
        return $this->hasMany(BudgetAllocation::class, 'monthly_budget_id');
    }
}
