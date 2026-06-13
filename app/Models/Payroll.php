<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payroll extends Model
{
    protected $fillable = [
        'employee_id',
        'periode',
        'gaji_pokok',
        'tunjangan',
        'potongan_kasbon',
        'total_diterima',
        'status_pembayaran',
        'tanggal_dibayar',
        'catatan',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
