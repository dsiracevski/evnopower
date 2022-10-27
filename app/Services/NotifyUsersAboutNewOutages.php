<?php

namespace App\Services;

use App\Mail\PlannedOutages;
use App\Models\Outage;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class NotifyUsersAboutNewOutages
{
    public function handle(): void
    {
        $subscribedUsers = User::has('locations')->with('locations')->get();

        foreach ($subscribedUsers as $subscribedUser) {
            $monitoredLocations = $this->monitoredLocationsFor($subscribedUser);
            $upcomingPowerOutages = $this->upcomingPowerOutagesFor($monitoredLocations);

            if ($upcomingPowerOutages->isEmpty()) continue;

            Mail::to($subscribedUser)->send(new PlannedOutages($upcomingPowerOutages, $subscribedUser));
        }
    }

    public function upcomingPowerOutagesFor(Collection $monitoredLocations): Collection
    {
        return Outage::upcomingOutages()
            ->whereIn('location', $monitoredLocations)
            ->get();
    }

    public function monitoredLocationsFor($subscribedUser): Collection
    {
        return $subscribedUser->locations()->pluck('name');
    }
}
