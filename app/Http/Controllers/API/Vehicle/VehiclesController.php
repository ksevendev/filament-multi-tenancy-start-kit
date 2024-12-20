<?php

namespace App\Http\Controllers\API\Vehicle;

use App\Enum\Vehicles\StatusVehicleEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\VehicleResource;
use App\Models\Vehicles;
use Illuminate\Support\Facades\Request;

class VehiclesController extends Controller
{
    public function __invoke(Request $request)
    {
        $vehicles = Vehicles::query()
            ->with('brand', 'tenant')
            ->where('status', StatusVehicleEnum::ACTIVE)
            ->paginate(6);

        return VehicleResource::collection($vehicles)->response();
    }
}
