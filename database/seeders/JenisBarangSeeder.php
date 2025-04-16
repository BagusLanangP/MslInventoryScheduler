<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JenisBarangSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'Elektronik', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Pakaian', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Makanan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Kosmetik', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Obat', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Perabotan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Alat Tulis', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('jenis_barangs')->insert($data);
    }
}
