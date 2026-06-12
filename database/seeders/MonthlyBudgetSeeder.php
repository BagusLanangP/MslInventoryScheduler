<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MonthlyBudget;
use App\Models\JenisSchedule;
use Carbon\Carbon;

class MonthlyBudgetSeeder extends Seeder
{
    public function run(): void
    {
        $jenisSchedules = JenisSchedule::where('status_aktif', true)->get();
        $restockCat = $jenisSchedules->where('nama', 'Pembelian Barang / Restocking')->first();
        $opsCat = $jenisSchedules->where('nama', 'Operasional')->first();
        $maintCat = $jenisSchedules->where('nama', 'Maintenance')->first();

        // Seed budgets for the last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $monthDate = Carbon::now()->subMonths($i);
            $periode = $monthDate->format('Y-m');

            // Seed MonthlyBudget
            $budget = MonthlyBudget::create([
                'periode' => $periode,
                'total_kas' => 1000000000.00, // Initial 1 billion Rp
                'alokasi_anggaran' => 100000000.00, // 100 million Rp allocation ceiling
                'catatan' => 'Rencana anggaran operasional periode ' . $monthDate->translatedFormat('F Y'),
                'created_at' => $monthDate,
                'updated_at' => $monthDate,
            ]);

            // Seed allocations
            if ($restockCat) {
                $budget->allocations()->create([
                    'jenis_schedule_id' => $restockCat->id,
                    'nominal_limit' => 50000000.00, // 50jt limit
                    'catatan' => 'Batas belanja barang restocking',
                    'created_at' => $monthDate,
                    'updated_at' => $monthDate,
                ]);
            }

            if ($opsCat) {
                $budget->allocations()->create([
                    'jenis_schedule_id' => $opsCat->id,
                    'nominal_limit' => 45000000.00, // 45jt limit
                    'catatan' => 'Batas operasional dasar & gaji',
                    'created_at' => $monthDate,
                    'updated_at' => $monthDate,
                ]);
            }

            if ($maintCat) {
                $budget->allocations()->create([
                    'jenis_schedule_id' => $maintCat->id,
                    'nominal_limit' => 5000000.00, // 5jt limit
                    'catatan' => 'Batas maintenance bulanan',
                    'created_at' => $monthDate,
                    'updated_at' => $monthDate,
                ]);
            }
        }
    }
}
