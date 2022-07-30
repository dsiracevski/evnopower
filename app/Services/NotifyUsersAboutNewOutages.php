<?php

namespace App\Services;

use App\Mail\PlannedOutages;
use App\Models\Outage;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class NotifyUsersAboutNewOutages
{
    public function handle()
    {
        $plannedOutages = Outage::upcomingOutages()->get();

        $usersWithLocations = User::has('locations')->with('locations')->get();

        foreach ($usersWithLocations as $user) {

            $uLocations = $user->locations()->pluck('name');

            $plannedOutages = $plannedOutages->filter(function ($outage) use ($uLocations) {
                return $outage->qualifier($uLocations->toArray());
            });

            Mail::to($user->email)->send(new PlannedOutages($plannedOutages, $user));
        }
    }
}
