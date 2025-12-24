<?php

namespace Database\Factories;


use App\Models\Petugas;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; // Pastikan ini ditambahkan

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Petugas>
 */
class PetugasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_petugas' => 1, // Menggunakan UUID untuk id_petugas
            'nama_petugas' => 'Admin_Dzakiyyah', // Nama petugas tetap
            'username' => 'Admin', // Username tetap
            'password' => Hash::make('admin123'), // Password hash tetap
            'telp' => '081982735826', // Nomor telepon tetap
            'level' => 'admin', // Level tetap
        ];
    }
}
