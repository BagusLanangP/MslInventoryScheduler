<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\JenisBarangSeeder;
use App\Models\SupplierSeeder;
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
            \Database\Seeders\JenisBarangSeeder::class,
            \Database\Seeders\UserSeeder::class,
            \Database\Seeders\SupplierSeeder::class,
        ]);
        // $this->call([
            
        // ]);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
