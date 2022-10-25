<?php

namespace App\Services;

use App\Models\Location;

class LocationService
{
    public function __construct(private Location $location)
    {
    }

    public function getLocationNamesForUpcomingPowerOutages($plannedOutages): array
    {
        return $this->location->whereIn('name', $plannedOutages->pluck('location'))->select('name')->get()->toArray();
    }

}