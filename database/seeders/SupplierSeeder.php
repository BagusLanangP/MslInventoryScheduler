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
        // Ambil semua jenis barang yang ada dalam bentuk map nama => id
        $jenisBarangs = JenisBarang::pluck('id', 'name')->toArray();

        // Pastikan ada data jenis barang sebelum menambahkan supplier
        if (empty($jenisBarangs)) {
            $this->command->warn('Tidak ada data jenis barang. Jalankan JenisBarangSeeder terlebih dahulu.');
            return;
        }

        $data = [
            // Elektronik
            [
                'nama' => 'PT Sinar Abadi Elektronik',
                'nomor_whatsapp' => '081234567890',
                'email' => 'sinarabadi@example.com',
                'catatan' => 'Penyedia perangkat komputer, printer, dan elektronik kantor',
                'dari_tanggal' => '2024-01-15',
                'status_aktif' => true,
                'jenis_barang_id' => $jenisBarangs['Elektronik'] ?? 1,
                'alamat' => 'Jl. Gajah Mada No. 12, Jakarta Barat',
                'pic' => 'Budi Santoso'
            ],
            [
                'nama' => 'CV MicroTech Global',
                'nomor_whatsapp' => '082187654321',
                'email' => 'microtech@example.com',
                'catatan' => 'Spesialis komponen elektronik, mikrokontroler, dan aksesoris gadget',
                'dari_tanggal' => '2023-11-10',
                'status_aktif' => true,
                'jenis_barang_id' => $jenisBarangs['Elektronik'] ?? 1,
                'alamat' => 'Jl. Sudirman No. 45, Bandung',
                'pic' => 'Andi Wijaya'
            ],
            // Pakaian
            [
                'nama' => 'CV Busana Indah',
                'nomor_whatsapp' => '087812345678',
                'email' => 'busanaindah@example.com',
                'catatan' => 'Produsen seragam kerja dan pakaian olahraga',
                'dari_tanggal' => '2024-02-01',
                'status_aktif' => true,
                'jenis_barang_id' => $jenisBarangs['Pakaian'] ?? 2,
                'alamat' => 'Jl. Malioboro No. 89, Yogyakarta',
                'pic' => 'Siti Aminah'
            ],
            [
                'nama' => 'PT Textile Utama',
                'nomor_whatsapp' => '085298765432',
                'email' => 'textileutama@example.com',
                'catatan' => 'Penyedia kain gulungan dan konveksi skala besar',
                'dari_tanggal' => '2023-08-20',
                'status_aktif' => true,
                'jenis_barang_id' => $jenisBarangs['Pakaian'] ?? 2,
                'alamat' => 'Jl. Gatot Subroto No. 102, Surakarta',
                'pic' => 'Hendra Wijaya'
            ],
            // Makanan
            [
                'nama' => 'PT Pangan Makmur Lestari',
                'nomor_whatsapp' => '081345678901',
                'email' => 'panganmakmur@example.com',
                'catatan' => 'Penyedia bahan makanan pokok dan sembako',
                'dari_tanggal' => '2024-03-10',
                'status_aktif' => true,
                'jenis_barang_id' => $jenisBarangs['Makanan'] ?? 3,
                'alamat' => 'Jl. Industri Raya No. 7, Surabaya',
                'pic' => 'Rian Hidayat'
            ],
            [
                'nama' => 'UD Tani Makmur',
                'nomor_whatsapp' => '081916123456',
                'email' => 'tanimakmur@example.com',
                'catatan' => 'Pemasok sayur, buah segar, dan beras premium langsung dari petani',
                'dari_tanggal' => '2024-04-05',
                'status_aktif' => true,
                'jenis_barang_id' => $jenisBarangs['Makanan'] ?? 3,
                'alamat' => 'Jl. Raya Kuta No. 200, Badung, Bali',
                'pic' => 'Wayan Suarta'
            ],
            // Kosmetik
            [
                'nama' => 'CV Aura Cantik',
                'nomor_whatsapp' => '083812345678',
                'email' => 'auracantik@example.com',
                'catatan' => 'Distributor produk skincare dan kosmetik lokal berizin BPOM',
                'dari_tanggal' => '2024-05-12',
                'status_aktif' => true,
                'jenis_barang_id' => $jenisBarangs['Kosmetik'] ?? 4,
                'alamat' => 'Jl. Merdeka No. 15, Bogor',
                'pic' => 'Lani Marlina'
            ],
            // Obat
            [
                'nama' => 'PT Medika Pharma',
                'nomor_whatsapp' => '081112345678',
                'email' => 'medikapharma@example.com',
                'catatan' => 'Supplier obat-obatan medis, vitamin, dan alat pelindung diri',
                'dari_tanggal' => '2023-12-01',
                'status_aktif' => true,
                'jenis_barang_id' => $jenisBarangs['Obat'] ?? 5,
                'alamat' => 'Kawasan Industri Cikarang Blok B-12, Bekasi',
                'pic' => 'Dr. Anton Setiawan'
            ],
            // Perabotan
            [
                'nama' => 'UD Jati Luhur',
                'nomor_whatsapp' => '085712345678',
                'email' => 'jatiluhur@example.com',
                'catatan' => 'Pengrajin dan penyedia furniture kantor berbahan jati asli',
                'dari_tanggal' => '2024-01-20',
                'status_aktif' => true,
                'jenis_barang_id' => $jenisBarangs['Perabotan'] ?? 6,
                'alamat' => 'Jl. Raya Jepara-Kudus No. 45, Jepara',
                'pic' => 'Joko Prasetyo'
            ],
            // Alat Tulis
            [
                'nama' => 'CV Sumber Jaya',
                'nomor_whatsapp' => '081234567891',
                'email' => 'sumberjaya@example.com',
                'catatan' => 'Distributor utama alat tulis kantor (ATK) dan kertas print',
                'dari_tanggal' => '2022-05-15',
                'status_aktif' => true,
                'jenis_barang_id' => $jenisBarangs['Alat Tulis'] ?? 7,
                'alamat' => 'Jl. Diponegoro No. 88, Denpasar, Bali',
                'pic' => 'Made Sukra'
            ],
            [
                'nama' => 'PT Grama ATK',
                'nomor_whatsapp' => '081298765430',
                'email' => 'gramaatk@example.com',
                'catatan' => 'Penyedia ATK grosir, map, ordner, dan perlengkapan pengarsipan',
                'dari_tanggal' => '2023-09-01',
                'status_aktif' => false, // Nonaktifkan satu supplier untuk demo status
                'jenis_barang_id' => $jenisBarangs['Alat Tulis'] ?? 7,
                'alamat' => 'Jl. Pemuda No. 34, Semarang',
                'pic' => 'Agus Setiawan'
            ]
        ];

        foreach ($data as $supplier) {
            Supplier::create($supplier);
        }
    }
}
