<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Petugas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Petugas::create([
            'id_petugas' => '1',
            'nama_petugas' => 'Administrasi',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'telp' => '098765432123',
            'level' => 'admin'
        ]);
    }
}
