<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Pastikan model User di-import

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@apartemen.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // 2. Buat Akun Penghuni
        User::create([
            'name' => 'Budi Penghuni',
            'email' => 'budi@apartemen.com',
            'password' => bcrypt('password123'),
            'role' => 'penghuni',
            'status' => 'active',
        ]);

        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@apartin.com',
            'password' => bcrypt('admin123'),
            'role'     => 'admin',
            'status'   => 'active',
        ]);
    }
}