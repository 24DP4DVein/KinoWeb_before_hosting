<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@kinoweb.ru'],
            [
                'name'     => 'Admin',
                'password' => bcrypt('admin123'),
                'is_admin' => true,
            ]
        );
    }
}
