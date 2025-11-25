<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $username = explode('@', $user->email)[0];

            $user->update([
                'username' => $username
            ]);

            echo "✔ Semua username berhasil diperbarui!\n";

        }
    }
}
