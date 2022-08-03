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
        // Get all planned outages
        $plannedOutages = Outage::upcomingOutages()->get();

        // Get all users that have subscribed for notifications
        $usersWithLocations = User::has('locations')->with('locations')->get();

        foreach ($usersWithLocations as $user) {

            $userLocations = $user->locations()->pluck('name');

            // Checks for and returns all planned outages for the cities the user has subscribed for
            $plannedOutages = $plannedOutages->filter(function ($outage) use ($userLocations) {
                return $outage->subscribedLocations($userLocations->toArray());
            });

            // Send them to for processing
            Mail::to($user->email)->send(new PlannedOutages($plannedOutages, $user));
        }
    }
}
