<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Outage;

class LocationController extends Controller
{
    public function syncLocations()
    {
        $locations = Outage::locations()->pluck('location');

        foreach ($locations as $location) {
            Location::create(['name' => $location]);
        }
    }
}
