<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Business\Lead;
use App\Models\{MaintenanceType, Tenant, User};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name'     => 'Felipe Arnold',
            'email'    => 'felipe@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->call(FirstTenantSeeder::class);
        $this->call(PersonSeeder::class);
        $this->call(VehiclesBrandSeeder::class);
        $this->call(OwnerSeeder::class);
        $this->call(VehiclesSeeder::class);

        $maintenanceType = [
            [
                'name'  => 'Troca de óleo',
                'color' => 'bg-green-500',
            ],
            [
                'name'  => 'Troca de pneu',
                'color' => 'bg-blue-500',
            ],
            [
                'name'  => 'Troca de bateria',
                'color' => 'bg-yellow-500',
            ],
            [
                'name'  => 'Troca de freio',
                'color' => 'bg-red-500',
            ],
            [
                'name'  => 'Troca de filtro',
                'color' => 'bg-purple-500',
            ],
            [
                'name'  => 'Troca de correia',
                'color' => 'bg-indigo-500',
            ],
            [
                'name'  => 'Troca de amortecedor',
                'color' => 'bg-pink-500',
            ],
            [
                'name'  => 'Troca de embreagem',
                'color' => 'bg-gray-500',
            ],
            [
                'name'  => 'Troca de vela',
                'color' => 'bg-teal-500',
            ],
            [
                'name'  => 'Troca de filtro de ar',
                'color' => 'bg-cyan-500',
            ],
            [
                'name'  => 'Troca de filtro de óleo',
                'color' => 'bg-lime-500',
            ],
            [
                'name'  => 'Troca de filtro de combustível',
                'color' => 'bg-amber-500',
            ],
            [
                'name'  => 'Troca de filtro de ar condicionado',
                'color' => 'bg-orange-500',
            ],
            [
                'name'  => 'Troca de fluido de freio',
                'color' => 'bg-emerald-500',
            ],
            [
                'name'  => 'Troca de fluido de direção hidráulica',
                'color' => 'bg-lightBlue-500',
            ],
            [
                'name'  => 'Troca de fluido de transmissão',
                'color' => 'bg-rose-500',
            ],
            [
                'name'  => 'Troca de fluido de arrefecimento',
                'color' => 'bg-violet-500',
            ],
        ];

        MaintenanceType::insert($maintenanceType);

        Lead::factory(10)->create();

        Tenant::factory(10)->create();
    }
}
