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
        $jenisSchedules = JenisSchedule::pluck('id', 'nama'); // nama => id

        $data = [
            [
                'name' => 'Pembelian Barang Bulan Ini',
                'jenis_schedule_id' => $jenisSchedules['Pembelian Barang'] ?? 1,
                'berulang' => true,
                'note' => 'Pembelian rutin bahan baku',
                'date' => Carbon::now()->addDays(5),
                'budget' => 1500000.00,
                'reminder_date' => Carbon::now()->addDays(3),
                'status' => false,
            ],
            [
                'name' => 'Operasional Mingguan',
                'jenis_schedule_id' => $jenisSchedules['Operasional'] ?? 2,
                'berulang' => true,
                'note' => 'Operasional mingguan kantor',
                'date' => Carbon::now()->addDays(7),
                'budget' => 500000.00,
                'reminder_date' => Carbon::now()->addDays(6),
                'status' => false,
            ],
            [
                'name' => 'Libur Nasional',
                'jenis_schedule_id' => $jenisSchedules['Libur'] ?? 3,
                'berulang' => false,
                'note' => 'Libur Hari Kemerdekaan',
                'date' => Carbon::createFromDate(2025, 8, 17),
                'budget' => null,
                'reminder_date' => Carbon::createFromDate(2025, 8, 15),
                'status' => false,
            ],
        ];

        foreach ($data as $schedule) {
            Schedule::create($schedule);
        }
    }
}
