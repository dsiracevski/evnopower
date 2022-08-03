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
        $plannedOutages = Outage::upcomingOutages()->get();


        if ($plannedOutages->isNotEmpty()) {
            // Get all users that have subscribed for notifications
            $usersWithLocations = User::has('locations')->with('locations')->get();

            foreach ($usersWithLocations as $user) {
                $uLocations = $user->locations()->pluck('name');

                // Checks for and returns all planned outages for the cities the user has subscribed for
                $plannedOutages = $plannedOutages->filter(function ($outage) use ($uLocations) {
                    return $outage->qualifier($uLocations->toArray());
                });

                // Get ONLY the outages for which the user hasn't received a notification for
                $plannedOutages = $plannedOutages->filter(function ($outage) use ($user) {
                    return $outage->notSentToUser($user);
                });

                // Send them to for processing
                if ($plannedOutages->isNotEmpty()) {
                    Mail::to($user->email)->send(new PlannedOutages($plannedOutages, $user));
                } else {
                    Log::info("No new mail to send");
                }
            }
        }
        
    }
}
