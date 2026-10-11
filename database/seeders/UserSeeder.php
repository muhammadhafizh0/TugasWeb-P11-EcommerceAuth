<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Membuat 3 akun untuk testing multi-role (dipakai untuk tes incognito
 * 2 role sekaligus sesuai requirement Tugas Rutin 11 poin 8).
 *
 * admin@example.com  / password  -> role: admin
 * editor@example.com / password  -> role: editor
 * user@example.com   / password  -> role: user
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'editor@example.com'],
            ['name' => 'Editor', 'password' => Hash::make('password'), 'role' => 'editor']
        );

        User::updateOrCreate(
            ['email' => 'user@example.com'],
            ['name' => 'User Biasa', 'password' => Hash::make('password'), 'role' => 'user']
        );
    }
}
