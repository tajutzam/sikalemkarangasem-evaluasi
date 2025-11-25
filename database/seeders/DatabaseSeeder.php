<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Instansi, Variabel, dan Admin
        $this->call([
            InstansiSeeder::class,
            VariableTingkatSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
