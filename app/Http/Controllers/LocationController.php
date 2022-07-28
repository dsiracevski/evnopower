<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Outage;

class LocationController extends Controller
{
    public function syncLocations()
    {
        $locations = Location::all()->pluck('name')->toArray();

        $outageLocations = Outage::locations()->pluck('location')->toArray();

        $outageLocations = array_diff($outageLocations, $locations);

        foreach ($outageLocations as $location) {
            Location::create(['name' => $location]);
        }
    }
}
