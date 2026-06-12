<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InventoryCheckingSeeder extends Seeder
{
    public function run()
    {
        // Ambil jenis barang dan supplier dalam bentuk map nama/nama supplier => id
        $jenisBarangs = \App\Models\JenisBarang::pluck('id', 'name')->toArray();
        $suppliers = \App\Models\Supplier::pluck('id', 'nama')->toArray();

        // Pastikan data dependency sudah ada
        if (empty($jenisBarangs) || empty($suppliers)) {
            $this->command->warn('Pastikan JenisBarangSeeder dan SupplierSeeder sudah dijalankan.');
            return;
        }

        $data = [
            [
                'nama' => 'Laptop Asus Vivobook',
                'jenis_barang_id' => $jenisBarangs['Elektronik'] ?? 1,
                'supplier_id' => $suppliers['PT Sinar Abadi Elektronik'] ?? 1,
                'tanggal' => Carbon::now()->subMonths(5)->addDays(10), // 5 bulan lalu
                'expired_date' => null,
                'jumlah' => 15,
                'total_harga' => 112500000.00,
                'harga_pokok' => 7500000.00,
                'harga_jual' => 8500000.00,
                'keterangan' => 'Stok baru masuk untuk pengadaan laptop divisi operasional',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subMonths(5),
                'updated_at' => Carbon::now()->subMonths(5),
            ],
            [
                'nama' => 'Mouse Wireless Logitech',
                'jenis_barang_id' => $jenisBarangs['Elektronik'] ?? 1,
                'supplier_id' => $suppliers['CV MicroTech Global'] ?? 2,
                'tanggal' => Carbon::now()->subMonths(4)->addDays(5), // 4 bulan lalu
                'expired_date' => null,
                'jumlah' => 50,
                'total_harga' => 6000000.00,
                'harga_pokok' => 120000.00,
                'harga_jual' => 150000.00,
                'keterangan' => 'Mouse wireless standar kantor, stok aman',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subMonths(4),
                'updated_at' => Carbon::now()->subMonths(4),
            ],
            [
                'nama' => 'Kaos Polos Cotton Combed',
                'jenis_barang_id' => $jenisBarangs['Pakaian'] ?? 2,
                'supplier_id' => $suppliers['CV Busana Indah'] ?? 3,
                'tanggal' => Carbon::now()->subMonths(3)->addDays(8), // 3 bulan lalu
                'expired_date' => null,
                'jumlah' => 100,
                'total_harga' => 3500000.00,
                'harga_pokok' => 35000.00,
                'harga_jual' => 50000.00,
                'keterangan' => 'Kaos merchandise acara ulang tahun perusahaan, ukuran L & XL',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subMonths(3),
                'updated_at' => Carbon::now()->subMonths(3),
            ],
            [
                'nama' => 'Kemeja Flanel',
                'jenis_barang_id' => $jenisBarangs['Pakaian'] ?? 2,
                'supplier_id' => $suppliers['PT Textile Utama'] ?? 4,
                'tanggal' => Carbon::now()->subMonths(2)->addDays(2), // 2 bulan lalu
                'expired_date' => null,
                'jumlah' => 40,
                'total_harga' => 3400000.00,
                'harga_pokok' => 85000.00,
                'harga_jual' => 120000.00,
                'keterangan' => 'Kemeja flanel staff lapangan, menunggu konfirmasi kualitas jahitan',
                'status' => 'belum_diproses',
                'created_at' => Carbon::now()->subMonths(2),
                'updated_at' => Carbon::now()->subMonths(2),
            ],
            [
                'nama' => 'Kopi Arabika Toraja 250g',
                'jenis_barang_id' => $jenisBarangs['Makanan'] ?? 3,
                'supplier_id' => $suppliers['PT Pangan Makmur Lestari'] ?? 5,
                'tanggal' => Carbon::now()->subMonths(1)->addDays(20), // 1 bulan lalu
                'expired_date' => Carbon::now()->addMonths(12),
                'jumlah' => 80,
                'total_harga' => 3600000.00,
                'harga_pokok' => 45000.00,
                'harga_jual' => 60000.00,
                'keterangan' => 'Biji kopi arabika panggang untuk persediaan pantry kantor',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subMonths(1),
                'updated_at' => Carbon::now()->subMonths(1),
            ],
            [
                'nama' => 'Beras Premium 5kg',
                'jenis_barang_id' => $jenisBarangs['Makanan'] ?? 3,
                'supplier_id' => $suppliers['UD Tani Makmur'] ?? 6,
                'tanggal' => Carbon::now()->subDays(6), // bulan ini
                'expired_date' => Carbon::now()->addMonths(6),
                'jumlah' => 200,
                'total_harga' => 12000000.00,
                'harga_pokok' => 60000.00,
                'harga_jual' => 72000.00,
                'keterangan' => 'Beras cianjur premium untuk paket sembako karyawan',
                'status' => 'aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Serum Vitamin C',
                'jenis_barang_id' => $jenisBarangs['Kosmetik'] ?? 4,
                'supplier_id' => $suppliers['CV Aura Cantik'] ?? 7,
                'tanggal' => Carbon::now()->subMonths(5)->addDays(15), // 5 bulan lalu
                'expired_date' => Carbon::now()->addMonths(18),
                'jumlah' => 60,
                'total_harga' => 4800000.00,
                'harga_pokok' => 80000.00,
                'harga_jual' => 100000.00,
                'keterangan' => 'Serum skincare botol kaca 30ml untuk inventaris kosmetik',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subMonths(5),
                'updated_at' => Carbon::now()->subMonths(5),
            ],
            [
                'nama' => 'Paracetamol 500mg',
                'jenis_barang_id' => $jenisBarangs['Obat'] ?? 5,
                'supplier_id' => $suppliers['PT Medika Pharma'] ?? 8,
                'tanggal' => Carbon::now()->subMonths(4)->addDays(15), // 4 bulan lalu
                'expired_date' => Carbon::now()->addMonths(24),
                'jumlah' => 500,
                'total_harga' => 250000.00,
                'harga_pokok' => 500.00,
                'harga_jual' => 1000.00,
                'keterangan' => 'Persediaan P3K kantor, box isi 100 tablet',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subMonths(4),
                'updated_at' => Carbon::now()->subMonths(4),
            ],
            [
                'nama' => 'Meja Kerja Kayu Jati',
                'jenis_barang_id' => $jenisBarangs['Perabotan'] ?? 6,
                'supplier_id' => $suppliers['UD Jati Luhur'] ?? 9,
                'tanggal' => Carbon::now()->subMonths(2)->addDays(20), // 2 bulan lalu
                'expired_date' => null,
                'jumlah' => 10,
                'total_harga' => 12000000.00,
                'harga_pokok' => 1200000.00,
                'harga_jual' => 1500000.00,
                'keterangan' => 'Meja kerja jati custom untuk ruang rapat utama, menunggu instalasi',
                'status' => 'belum_diproses',
                'created_at' => Carbon::now()->subMonths(2),
                'updated_at' => Carbon::now()->subMonths(2),
            ],
            [
                'nama' => 'Kertas A4 Sinar Dunia 80g',
                'jenis_barang_id' => $jenisBarangs['Alat Tulis'] ?? 7,
                'supplier_id' => $suppliers['CV Sumber Jaya'] ?? 10,
                'tanggal' => Carbon::now()->subMonths(3)->addDays(25), // 3 bulan lalu
                'expired_date' => null,
                'jumlah' => 150,
                'total_harga' => 6300000.00,
                'harga_pokok' => 42000.00,
                'harga_jual' => 48000.00,
                'keterangan' => 'Kertas print A4, dus isi 5 rim untuk operasional harian',
                'status' => 'aktif',
                'created_at' => Carbon::now()->subMonths(3),
                'updated_at' => Carbon::now()->subMonths(3),
            ],
            [
                'nama' => 'Pulpen Gel Hitam',
                'jenis_barang_id' => $jenisBarangs['Alat Tulis'] ?? 7,
                'supplier_id' => $suppliers['PT Grama ATK'] ?? 11,
                'tanggal' => Carbon::now()->subMonths(1)->addDays(15), // 1 bulan lalu
                'expired_date' => null,
                'jumlah' => 300,
                'total_harga' => 750000.00,
                'harga_pokok' => 2500.00,
                'harga_jual' => 3500.00,
                'keterangan' => 'Pulpen gel hitam, retur karena tinta kering sebagian besar',
                'status' => 'ditarik',
                'created_at' => Carbon::now()->subMonths(1),
                'updated_at' => Carbon::now()->subMonths(1),
            ]
        ];

        DB::table('inventory_checkings')->insert($data);
    }
}
