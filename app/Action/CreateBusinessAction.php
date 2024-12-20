<?php

namespace App\Action;

use App\Models\Business\{Origins, Stages};
use App\Models\Tenant;

class CreateBusinessAction
{
    public Tenant $tenant;

    public string $name;

    public string $email;

    public string $phone;

    public string $message;

    public string $origin;

    public string $valuation;

    public function __construct(
        Tenant $tenant,
        string $name,
        string $email,
        string $phone,
        string $message,
        string $valuation,
        string $origin,
    ) {
        $this->tenant    = $tenant;
        $this->name      = $name;
        $this->email     = $email;
        $this->phone     = $phone;
        $this->message   = $message;
        $this->valuation = $valuation;
        $this->origin    = $origin;

    }

    public function run(): void
    {
        $userId   = $this->tenant->users()->first()->id;
        $stageId  = Stages::query()->where('tenant_id', $this->tenant->id)->first()->id;
        $originId = Origins::query()->where('name', $this->origin)->first()->id;

        $lead = $this->tenant->leads()->create([
            'name'  => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

        $this->tenant->businesses()->create([
            'lead_id'    => $lead->id,
            'tenant_id'  => $this->tenant->id,
            'user_id'    => $userId,
            'stages_id'  => $stageId,
            'origins_id' => $originId,
            'name'       => $this->name,
            'valuation'  => $this->valuation ?? 0,
        ]);
    }
}
