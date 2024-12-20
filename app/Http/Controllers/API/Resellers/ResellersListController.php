<?php

namespace App\Http\Controllers\API\Resellers;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\TenantResource;
use App\Models\Tenant;
use Illuminate\Http\{JsonResponse, Request};

class ResellersListController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $tenants = Tenant::query()
            ->with([
                'addresses',
                'phones',
                'emails',
                'vehicles' => function ($query) {
                    $query->where('status', 'active');
                },
            ])
            ->paginate(5);

        return TenantResource::collection($tenants)->response();
    }
}
