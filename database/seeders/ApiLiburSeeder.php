<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApiLiburSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('api_liburs')->insert([
            [
                'name' => 'Tahun Baru 2026 Masehi',
                'date' => '2026-01-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Isra Mikraj Nabi Muhammad SAW',
                'date' => '2026-01-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tahun Baru Imlek 2577 Kongzili',
                'date' => '2026-02-17',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hari Suci Nyepi (Tahun Baru Saka 1948)',
                'date' => '2026-03-18',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Wafat Yesus Kristus',
                'date' => '2026-04-03',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hari Raya Idul Fitri 1447 Hijriah',
                'date' => '2026-04-20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hari Raya Idul Fitri 1447 Hijriah (Hari Kedua)',
                'date' => '2026-04-21',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hari Buruh Internasional',
                'date' => '2026-05-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kenaikan Yesus Kristus',
                'date' => '2026-05-14',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hari Raya Waisak 2570 BE',
                'date' => '2026-05-31',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hari Lahir Pancasila',
                'date' => '2026-06-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hari Raya Idul Adha 1447 Hijriah',
                'date' => '2026-06-27',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tahun Baru Islam 1448 Hijriah',
                'date' => '2026-07-17',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hari Proklamasi Kemerdekaan RI',
                'date' => '2026-08-17',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Maulid Nabi Muhammad SAW',
                'date' => '2026-09-25',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hari Raya Natal',
                'date' => '2026-12-25',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
