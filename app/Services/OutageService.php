<?php

namespace App\Services;

use App\Models\Outage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class OutageService
{
    protected $currentDate;

    public function __construct(private Outage $outage)
    {
    }

    /**
     * @return Outage|Collection|LengthAwarePaginator
     */
    public function getLocationNames(): Outage|Collection|LengthAwarePaginator
    {
        return $this->outage->select('location')->distinct()->orderBy('location')->get();
    }
}