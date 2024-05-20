<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;

class FirstTenantSeeder extends Seeder
{
    public function run(): void
    {
        Tenant::create([
            'name' => 'AgendaMe',
            'slug' => 'agenda-me',
        ])->users()->attach(User::find(1));
    }
}
