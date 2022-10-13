<?php

namespace App\Services;

use App\Mail\PlannedOutages;
use App\Models\Outage;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifyUsersAboutNewOutages
{
    public function handle()
    {
        // Get all planned outages
        $plannedOutages = Outage::upcomingOutages()->pluck('location');
        // Get all users that have subscribed for notifications
        $usersWithLocations = User::has('locations')->with('locations')->get();

        if ($plannedOutages !== null) {
            foreach ($usersWithLocations as $user) {
                $uLocations = $user->locations()->pluck('name');
            }

            // Checks for and returns all planned outages for the cities the user has subscribed for
            $plannedOutages = array_intersect_key($plannedOutages->toArray(), $uLocations->toArray());

            // Get ONLY the outages for which the user hasn't received a notification for
            $plannedOutages = Outage::whereIn('location', $plannedOutages)
                ->whereDate('start', '>', now()->toDateTimeString())
                ->whereDoesntHave('users')
                ->get();

        }
// TODO only sending outages to one user
        foreach ($usersWithLocations as $user) {
            Mail::to($user)->send(new PlannedOutages($plannedOutages, $user));
        }
//        else {
//            Log::info("No new mail to send");
//        }
    }
}
