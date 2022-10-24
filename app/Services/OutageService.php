<?php

namespace App\Services;

use App\Models\Outage;
use Illuminate\Support\Collection;

class OutageService
{
    public function __construct(private Outage $outage)
    {
    }

    /**
     * @return Outage|Collection
     */
    public function getLocationNames(): Outage|Collection
    {
        return $this->outage->select('location')->distinct()->orderBy('location')->get();
    }

    /**
     * @param $location
     * @param $date
     * @return Outage|Collection
     */
    public function getUpcomingPowerOutagesForLocationWithinDate($location, $date): Outage|Collection
    {
        return $this->outage->forLocation($location)->withinDate($date)->get();
    }

    public function getUpcomingPowerOutagesFor($powerOutageLocations)
    {
        return $this->outage->whereIn('location', $powerOutageLocations)
            ->whereDate('start', '>', now()->toDateTimeString())
            ->whereDoesntHave('users');
    }

}