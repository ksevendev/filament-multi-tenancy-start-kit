<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Owners::factory(10)->create();
    }
}
