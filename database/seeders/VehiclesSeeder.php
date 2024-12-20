<?php

namespace Database\Seeders;

use App\Models\{Owners, Vehicles, VehiclesBrand};
use Illuminate\Database\Seeder;

class VehiclesSeeder extends Seeder
{
    public function run(): void
    {
        Vehicles::create([
            'user_id'      => 1,
            'tenant_id'    => 1,
            'owner_id'     => Owners::factory()->create()->id,
            'name'         => 'Gol Felipe',
            'plate_number' => 'IPA-1760',
            'color'        => 'Prata',
            'type'         => 'car',
            'brand_id'     => VehiclesBrand::factory()->create([
                'type' => 'cars',
                'name' => 'Volkswagen',
            ])->id,
            'model'          => 'Gol G5',
            'year'           => '2009',
            'purchase_value' => 200000.00,
            'purchase_date'  => '2021-01-01',
            'status'         => 'active',
        ]);

        Vehicles::create([
            'user_id'      => 1,
            'tenant_id'    => 1,
            'name'         => 'Onix Nelci',
            'plate_number' => 'IVY3F02',
            'color'        => 'Branco',
            'type'         => 'car',
            'brand_id'     => VehiclesBrand::factory()->create([
                'type' => 'cars',
                'name' => 'Chevrolet',
            ])->id,
            'model'         => 'Onix',
            'year'          => '2015',
            'purchase_date' => '2021-01-01',
            'status'        => 'active',
        ]);

        Vehicles::factory(10)->create();
    }
}
