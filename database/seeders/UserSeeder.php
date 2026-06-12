<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin Utama',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'telepon' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bagus Lanang',
                'email' => 'bagus@example.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'telepon' => '081122334455',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Operator Utama',
                'email' => 'operator@example.com',
                'password' => Hash::make('password123'),
                'role' => 'operator',
                'telepon' => '082112345678',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Siti Rahma',
                'email' => 'siti@example.com',
                'password' => Hash::make('password123'),
                'role' => 'operator',
                'telepon' => '082211223344',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Staff Utama',
                'email' => 'user@example.com',
                'password' => Hash::make('password123'),
                'role' => 'staff',
                'telepon' => '081234567891',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'password' => Hash::make('password123'),
                'role' => 'staff',
                'telepon' => '087812345678',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@example.com',
                'password' => Hash::make('password123'),
                'role' => 'staff',
                'telepon' => '089988776655',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
