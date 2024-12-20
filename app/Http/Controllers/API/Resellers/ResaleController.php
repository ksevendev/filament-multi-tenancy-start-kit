<?php

namespace App\Http\Controllers\API\Resellers;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\TenantResource;
use App\Models\Tenant;
use Illuminate\Http\Request;

class ResaleController extends Controller
{
    public function __invoke(int $id, Request $request): TenantResource
    {
        $tenant = Tenant::query()
            ->with([
                'addresses',
                'phones',
                'emails',
                'vehicles' => function ($query) {
                    $query->where('status', 'active');
                },
            ])
            ->findOrFail($id);

        return new TenantResource($tenant);
    }
}
