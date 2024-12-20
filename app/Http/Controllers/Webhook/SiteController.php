<?php

namespace App\Http\Controllers\Webhook;

use App\Action\CreateBusinessAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Webohook\SiteRequest;
use App\Models\{Integrations, Tenant};
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SiteController extends Controller
{
    public function __invoke(SiteRequest $request, string $token): JsonResponse
    {
        $authorization = str_replace('Bearer ', '', $request->header('Authorization'));

        $integration = Integrations::query()
            ->where('api_key', $token)
            ->where('api_token', $authorization)
            ->first();

        $tenant = Tenant::query()->find($integration->tenant_id);

        (new CreateBusinessAction(
            $tenant,
            $request->name,
            $request->email,
            $request->phone,
            $request->message,
            $request->valuation,
            'Site'
        ))->run();

        return response()->json(['message' => 'Lead created'], Response::HTTP_CREATED);
    }
}
