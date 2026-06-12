<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'nama',
        'tipe',
        'kategori',
        'nominal',
        'sumber',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date'
    ];
}
