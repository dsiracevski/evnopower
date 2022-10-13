<?php

namespace App\Services;

use App\Models\Outage;
use Illuminate\Support\Collection;

class OutageService
{
    protected $currentDate;

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
}