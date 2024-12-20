<?php

declare(strict_types = 1);

namespace App\Observers;

use App\Models\Business\{Funnel, Origins};
use App\Models\{Integrations, Tenant, User};
use Illuminate\Support\Str;

class TenantObserver
{
    public function creating(Tenant $tenant): void
    {
        $tenant->slug = Str::slug($tenant->name);
    }

    public function created(Tenant $tenant): void
    {
        $tenant->users()->attach(User::find(1));

        $origins = [
            ['tenant_id' => $tenant->id, 'name' => 'Whatsapp', 'color' => '#0B9412'],
            ['tenant_id' => $tenant->id, 'name' => 'Facebook', 'color' => '#1854F2'],
            ['tenant_id' => $tenant->id, 'name' => 'Instagram', 'color' => '#A348B1'],
            ['tenant_id' => $tenant->id, 'name' => 'Site', 'color' => '#486AA8'],
            ['tenant_id' => $tenant->id, 'name' => 'Portal Zap', 'color' => '#6E0AD6'],
            ['tenant_id' => $tenant->id, 'name' => 'RD Station', 'color' => '#17A3AE'],
            ['tenant_id' => $tenant->id, 'name' => 'Chaves na mão', 'color' => '#ff0d36'],
        ];

        Origins::insert($origins);

        $funel = Funnel::query()
            ->create([
                'tenant_id' => $tenant->id,
                'name'      => 'Funil Padrão',
            ]);

        $funel->stages()->createMany([
            ['tenant_id' => $tenant->id, 'name' => 'Interesse', 'order' => 1],
            ['tenant_id' => $tenant->id, 'name' => 'Proposta', 'order' => 2],
            ['tenant_id' => $tenant->id, 'name' => 'Negociação', 'order' => 3],
            ['tenant_id' => $tenant->id, 'name' => 'Fechamento', 'order' => 4],
        ]);

        Integrations::query()
            ->create([
                'tenant_id' => $tenant->id,
                'name'      => 'Site',
                'url'       => env('APP_URL') . '/api/webhooks/site',
                'api_key'   => Str::ulid(),
                'api_token' => Str::random(60),
                'settings'  => [
                    'code'      => '001',
                    'name'      => 'Nome',
                    'email'     => 'Email',
                    'phone'     => 'Telefone',
                    'message'   => 'Mensagem',
                    'valuation' => '50000.00',
                ],
            ]);
    }
}
