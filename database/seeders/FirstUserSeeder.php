<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FirstUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Felipe Arnold',
            'email'    => 'felipe@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
