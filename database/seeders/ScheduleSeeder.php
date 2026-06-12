<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\JenisSchedule;
use Carbon\Carbon;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $jenisSchedules = JenisSchedule::pluck('id', 'nama')->toArray(); // nama => id
        $users = \App\Models\User::pluck('id', 'email')->toArray(); // email => id
        $inventoryCheckings = \App\Models\InventoryChecking::pluck('id', 'nama')->toArray(); // nama => id

        $adminId = $users['admin@example.com'] ?? 1;

        // Loop through the last 6 months (including the current month)
        for ($i = 5; $i >= 0; $i--) {
            $monthDate = Carbon::now()->subMonths($i);
            $year = $monthDate->year;
            $month = $monthDate->month;

            $isCurrentMonth = ($i === 0);

            // 1. Restocking (Pembelian Barang / Restocking)
            $restockDate1 = Carbon::create($year, $month, 8);
            if ($restockDate1->isBefore(Carbon::now())) {
                Schedule::create([
                    'name' => 'Restocking Kopi Arabika Toraja 250g',
                    'jenis_schedule_id' => $jenisSchedules['Pembelian Barang / Restocking'] ?? 1,
                    'berulang' => false,
                    'note' => 'Restock rutin kopi toraja dari supplier Koperasi Toraja',
                    'date' => $restockDate1->toDateString(),
                    'budget' => 15000000.00,
                    'reminder_date' => $restockDate1->copy()->subDays(2)->toDateString(),
                    'status' => true,
                    'completed_at' => $restockDate1->copy()->addHours(14),
                    'created_by' => $adminId,
                    'inventory_checking_id' => $inventoryCheckings['Kopi Arabika Toraja 250g'] ?? null,
                ]);
            }

            $restockDate2 = Carbon::create($year, $month, 22);
            $isCompleted = !$isCurrentMonth || $restockDate2->isBefore(Carbon::now());
            Schedule::create([
                'name' => 'Restock Laptop & Peralatan Kerja Staff',
                'jenis_schedule_id' => $jenisSchedules['Pembelian Barang / Restocking'] ?? 1,
                'berulang' => false,
                'note' => 'Pembelian peralatan kerja divisi operasional',
                'date' => $restockDate2->toDateString(),
                'budget' => 25000000.00,
                'reminder_date' => $restockDate2->copy()->subDays(2)->toDateString(),
                'status' => $isCompleted,
                'completed_at' => $isCompleted ? $restockDate2->copy()->addHours(10) : null,
                'created_by' => $adminId,
                'inventory_checking_id' => null,
            ]);

            // 2. Maintenance (AC & Sanitasi)
            $maintenanceDate = Carbon::create($year, $month, 12);
            $isMaintCompleted = !$isCurrentMonth || $maintenanceDate->isBefore(Carbon::now());
            Schedule::create([
                'name' => 'Maintenance Air Conditioning & Sanitasi Kantor',
                'jenis_schedule_id' => $jenisSchedules['Maintenance'] ?? 3,
                'berulang' => true,
                'note' => 'Perawatan rutin AC dan sanitasi wastafel pantry',
                'date' => $maintenanceDate->toDateString(),
                'budget' => 1200000.00,
                'reminder_date' => $maintenanceDate->copy()->subDays(1)->toDateString(),
                'status' => $isMaintCompleted,
                'completed_at' => $isMaintCompleted ? $maintenanceDate->copy()->addHours(15) : null,
                'created_by' => $adminId,
                'inventory_checking_id' => null,
            ]);

            // 3. Operasional (Payroll & Meeting)
            $opsDate = Carbon::create($year, $month, 28);
            $isOpsCompleted = !$isCurrentMonth || $opsDate->isBefore(Carbon::now());
            Schedule::create([
                'name' => 'Pembayaran Gaji Pegawai & Staff Toko',
                'jenis_schedule_id' => $jenisSchedules['Operasional'] ?? 2,
                'berulang' => true,
                'note' => 'Pembayaran gaji karyawan bulanan terintegrasi',
                'date' => $opsDate->toDateString(),
                'budget' => 35000000.00,
                'reminder_date' => $opsDate->copy()->subDays(3)->toDateString(),
                'status' => $isOpsCompleted,
                'completed_at' => $isOpsCompleted ? $opsDate->copy()->addHours(9) : null,
                'created_by' => $adminId,
                'inventory_checking_id' => null,
            ]);
        }
    }
}
