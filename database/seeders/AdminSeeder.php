<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@sikalem.go.id',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'instansi_id' => null, // Admin tidak di-mapping ke instansi
        ]);
    }
}
