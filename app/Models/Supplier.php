<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nomor_whatsapp',
        'email',
        'catatan',
        'dari_tanggal',
        'status_aktif',
        'jenis_barang'
    ];

    public function jenisBarangs()
    {
        return $this->belongsTo(JenisBarang::class);
    }

    public function InventoryChecking()
    {
        return $this->hasMany(InventoryChecking::class);
    }
    

    protected $casts = [
        'dari_tanggal' => 'date',
        'status_aktif' => 'boolean'
    ];

    // Scope untuk supplier aktif
    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }

    // Scope untuk jenis barang tertentu
    public function scopeJenisBarang($query, $jenis)
    {
        return $query->where('jenis_barang', $jenis);
    }
}