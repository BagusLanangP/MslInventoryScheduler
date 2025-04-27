<?php

// app/Models/InventoryChecking.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryChecking extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jenis_barang_id',
        'supplier_id',
        'tanggal',
        'expired_date',
        'jumlah',
        'harga_pokok',
        'total_harga',
        'harga_jual',
        'keterangan',
        'status',
    ];

    // Relasi ke jenis barang
    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarang::class);
    }

    // Relasi ke supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}

