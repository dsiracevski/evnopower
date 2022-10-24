<?php

namespace App\Services;

use App\Mail\PlannedOutages;
use App\Models\Outage;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class NotifyUsersAboutNewOutages
{
    public function __construct(private OutageService $outageService)
    {

    }
    public function handle()
    {
        $subscribedUsers = User::has('locations')->with('locations')->get();

        foreach ($subscribedUsers as $subscribedUser) {

            $powerOutageLocations = Outage::upcomingOutages()->pluck('location');

            if ($powerOutageLocations->isEmpty()) {
                return;
            }

            $monitoredLocations = $subscribedUser->locations()->pluck('name');

            $powerOutageLocations = array_intersect_key($powerOutageLocations->toArray(), $monitoredLocations->toArray());

            $plannedPowerOutages = $this->outageService->getUpcomingPowerOutagesFor($powerOutageLocations);

            Mail::to($subscribedUser)->send(new PlannedOutages($plannedPowerOutages, $subscribedUser));
        }
    }
}
