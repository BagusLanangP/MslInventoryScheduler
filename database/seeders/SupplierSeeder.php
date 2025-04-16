<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;
use App\Models\JenisBarang;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua id jenis barang yang ada
        $jenisBarangIds = JenisBarang::pluck('id')->toArray();

        // Pastikan ada data jenis barang sebelum menambahkan supplier
        if (empty($jenisBarangIds)) {
            $this->command->warn('Tidak ada data jenis barang. Jalankan JenisBarangSeeder terlebih dahulu.');
            return;
        }

        $data = [
            [
                'nama' => 'CV Sumber Jaya',
                'nomor_whatsapp' => '081234567890',
                'email' => 'sumberjaya@example.com',
                'catatan' => 'Penyedia alat tulis dan kantor',
                'dari_tanggal' => '2024-01-15',
                'status_aktif' => true,
                'jenis_barang_id' => $jenisBarangIds[0],
            ],
            [
                'nama' => 'PT Mega Elektronik',
                'nomor_whatsapp' => '082112345678',
                'email' => 'megaelektronik@example.com',
                'catatan' => 'Spesialis barang elektronik',
                'dari_tanggal' => '2023-11-10',
                'status_aktif' => true,
                'jenis_barang_id' => $jenisBarangIds[1],
            ],
        ];

        foreach ($data as $supplier) {
            Supplier::create($supplier);
        }
    }
}
