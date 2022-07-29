<?php

namespace App\Console\Commands;

use App\Mail\PlannedOutages;
use App\Models\Outage;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendPlannedOutagesMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:send-planned-outage-mail {locations*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email with list of locations with planned outages to all eligible users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $plannedOutages = Outage::upcomingOutages()->get();

        $usersWithLocations = User::has('locations')->with('locations')->get();

        $uLocations = [];

        foreach ($usersWithLocations as $userWithLocation) {

            $uLocations = $userWithLocation->locations()->pluck('name');

            $plannedOutages = $plannedOutages->filter(function ($outage) use ($uLocations) {
                return $outage->qualifier($uLocations->toArray());
            });

            Mail::to($userWithLocation->email)->send(new PlannedOutages($plannedOutages, $userWithLocation));

        }
    }
}
