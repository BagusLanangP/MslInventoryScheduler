<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\JenisBarangSeeder;
use App\Models\SupplierSeeder;
use App\Models\JenisScheduleSeeder;
use App\Models\InventoryCheckingSeeder;
use App\Models\ScheduleSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            \Database\Seeders\JenisScheduleSeeder::class,
            \Database\Seeders\JenisBarangSeeder::class,
            \Database\Seeders\UserSeeder::class,
            \Database\Seeders\SupplierSeeder::class,
            \Database\Seeders\ScheduleSeeder::class,
            \Database\Seeders\InventoryCheckingSeeder::class,
        ]);
        // $this->call([
            
        // ]);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
