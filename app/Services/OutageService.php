<?php

namespace App\Services;

use App\Models\Outage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class OutageService
{
    public function __construct(private Outage $outage)
    {
    }

    public function getLocationNames(): Outage|Collection
    {
        return $this->outage->select('location')->distinct()->orderBy('location')->get();
    }

    public function getUpcomingPowerOutagesForLocationWithinDate(string $location, string $date): Outage|Collection
    {
        return $this->outage->forLocation($location)->withinDate($date)->get();
    }

}