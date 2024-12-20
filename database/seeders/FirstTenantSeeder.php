<?php

namespace Database\Seeders;

use App\Models\{Tenant, User};
use Illuminate\Database\Seeder;

class FirstTenantSeeder extends Seeder
{
    public function run(): void
    {
        Tenant::create([
            'name' => 'WSoft',
            'slug' => 'w-soft',
        ])->users()->attach(User::find(1));
    }
}
