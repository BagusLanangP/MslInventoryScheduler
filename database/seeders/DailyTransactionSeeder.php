<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DailyTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactions = [];
        
        // Loop through the last 6 months (including the current month)
        for ($i = 5; $i >= 0; $i--) {
            $monthDate = Carbon::now()->subMonths($i);
            $year = $monthDate->year;
            $month = $monthDate->month;
            
            // 1. Daily POS Retail Sales (Income)
            // Seed multiple sales transactions per month to make the trend curves smooth and realistic
            for ($day = 3; $day <= 28; $day += 3) {
                $txDate = Carbon::create($year, $month, $day, 17, 30, 0);
                
                // Don't seed future transactions
                if ($txDate->isAfter(Carbon::now())) {
                    continue;
                }
                
                $transactions[] = [
                    'tanggal' => $txDate,
                    'nama' => 'Penjualan Kasir Shift Pagi - Sore',
                    'tipe' => 'pemasukan',
                    'kategori' => 'Penjualan Retail',
                    'nominal' => rand(25000000, 40000000), // 25M - 40M per day, healthy income!
                    'sumber' => 'api',
                    'keterangan' => 'Sistem POS Otomatis Sync',
                    'created_at' => $txDate,
                    'updated_at' => $txDate,
                ];
            }

            // 2. Regular Monthly Expenses
            // Electric & Water (Operasional)
            $electricDate = Carbon::create($year, $month, 5, 10, 0, 0);
            if ($electricDate->isBefore(Carbon::now())) {
                $transactions[] = [
                    'tanggal' => $electricDate,
                    'nama' => 'Pembayaran Listrik & Air Bulanan',
                    'tipe' => 'pengeluaran',
                    'kategori' => 'Operasional',
                    'nominal' => rand(2500000, 4500000),
                    'sumber' => 'manual',
                    'keterangan' => 'Tagihan PLN & PDAM Kantor Utama',
                    'created_at' => $electricDate,
                    'updated_at' => $electricDate,
                ];
            }

            // Internet & Cloud (Operasional)
            $internetDate = Carbon::create($year, $month, 10, 11, 0, 0);
            if ($internetDate->isBefore(Carbon::now())) {
                $transactions[] = [
                    'tanggal' => $internetDate,
                    'nama' => 'Biaya Sewa Domain & Cloud Hosting',
                    'tipe' => 'pengeluaran',
                    'kategori' => 'Operasional',
                    'nominal' => 1500000.00,
                    'sumber' => 'manual',
                    'keterangan' => 'Tagihan bulanan AWS & Domain',
                    'created_at' => $internetDate,
                    'updated_at' => $internetDate,
                ];
            }

            // Office Supplies (Operasional)
            $atkDate = Carbon::create($year, $month, 15, 14, 0, 0);
            if ($atkDate->isBefore(Carbon::now())) {
                $transactions[] = [
                    'tanggal' => $atkDate,
                    'nama' => 'Pembelian Alat Tulis & Pantry',
                    'tipe' => 'pengeluaran',
                    'kategori' => 'Operasional',
                    'nominal' => rand(800000, 1500000),
                    'sumber' => 'manual',
                    'keterangan' => 'Belanja ATK dan kebutuhan pantry',
                    'created_at' => $atkDate,
                    'updated_at' => $atkDate,
                ];
            }
        }

        DB::table('daily_transactions')->insert($transactions);
    }
}
