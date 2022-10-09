<?php

namespace App\Services;

use App\Models\Outage;

class OutageService
{
    protected $currentDate;

    protected Outage $outage;

    public function __construct(Outage $outage)
    {
        $this->outage = $outage;
    }

    public function getLocationNames()
    {
        return $this->outage->select('location')->distinct()->orderBy('location')->get();
    }
}