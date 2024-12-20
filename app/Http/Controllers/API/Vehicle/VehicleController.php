<?php

namespace App\Http\Controllers\API\Vehicle;

use App\Enum\Vehicles\StatusVehicleEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\VehicleResource;
use App\Models\Vehicles;
use Illuminate\Support\Facades\Request;

class VehicleController extends Controller
{
    public function __invoke(int $id, Request $request)
    {
        $vehicles = Vehicles::query()
            ->with('tenant')
            ->where('status', StatusVehicleEnum::ACTIVE)
            ->findOrFail($id);

        return new VehicleResource($vehicles);
    }
}
