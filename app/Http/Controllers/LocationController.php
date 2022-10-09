<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Services\OutageService;

class LocationController extends Controller
{
    public function __construct(private OutageService $outageService)
    {
    }

    public function syncLocations(): void
    {
        $locations = Location::all()->pluck('name')->toArray();

        $outageLocations = $this->outageService->getLocationNames()->pluck('location')->toArray();

        $outageLocations = array_diff($outageLocations, $locations);

        foreach ($outageLocations as $location) {
            Location::create(['name' => $location]);
        }
    }
}
