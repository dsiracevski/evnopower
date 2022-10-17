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
        $usersWithLocations = User::has('locations')->with('locations')->get();

        foreach ($usersWithLocations as $user) {

            $plannedOutages = Outage::upcomingOutages()->pluck('location');

            if (! $plannedOutages) return;

            $uLocations = $user->locations()->pluck('name');

            $plannedOutages = array_intersect_key($plannedOutages->toArray(), $uLocations->toArray());

            $plannedOutages = Outage::whereIn('location', $plannedOutages)
                ->whereDate('start', '>', now()->toDateTimeString())
                ->whereDoesntHave('users')
                ->get();

            Mail::to($user)->send(new PlannedOutages($plannedOutages, $user));
        }
    }
}
