<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InventoryCheckingSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'Barang A',
                'jenis_barang_id' => 1, // Ensure this ID exists in your jenis_barangs table
                'supplier_id' => 1, // Ensure this ID exists in your suppliers table
                'tanggal' => Carbon::now()->subDays(10),
                'expired_date' => Carbon::now()->addDays(20),
                'jumlah' => 100,
                'total_harga' => 1000000.00,
                'harga_pokok' => 9000.00,
                'harga_jual' => 10000.00,
                'keterangan' => 'Sample keterangan for Barang A',
                'status' => 'belum_diproses',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Barang B',
                'jenis_barang_id' => 2,
                'supplier_id' => 2,
                'tanggal' => Carbon::now()->subDays(5),
                'expired_date' => Carbon::now()->addDays(15),
                'jumlah' => 50,
                'total_harga' => 500000.00,
                'harga_pokok' => 9500.00,
                'harga_jual' => 11000.00,
                'keterangan' => 'Sample keterangan for Barang B',
                'status' => 'aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Add more entries as needed
        ];

        DB::table('inventory_checkings')->insert($data);
    }
}
