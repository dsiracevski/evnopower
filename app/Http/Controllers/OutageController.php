<?php

namespace App\Http\Controllers;

use App\Jobs\SendPlannedOutagesMail;
use App\Models\Outage;
use App\Services\DownloadOutagesDocument;
use Illuminate\Support\Carbon;

class OutageController extends Controller
{
    public function index()
    {
        $locations = Outage::locations()->get();

        $currentDate = (request()->date)
            ? Carbon::parse(request()->date)->endOfDay()
            : Carbon::today()->endOfDay();

        $plannedOutages = Outage::filter()->where('start', '>=', today())
            ->orderBy((request()->filter) ?: "location")
            ->get();


        //TODO refactor in EVNoPower 2.0 (isset with optional route parameter?)
        if (request()->user_id) {
            $userLocations = auth()->user()->locations()->pluck('name');

            $plannedOutages = $plannedOutages->filter(function ($outage) use ($userLocations) {
                return $outage->subscribedLocations($userLocations->toArray());
            });
        }

        return view('outages.index', [
            'outages' => $plannedOutages,
            'date' => date_format($currentDate, 'Y-m-d'),
            'locations' => $locations
        ]);
    }


    /**
     * Import file for planned outages
     * @return void
     */
    public function importFile()
    {
        try {
            $locations = (new DownloadOutagesDocument())->handle();
        } catch (\Exception $e) {
//            dd("Something happened");
        }

        // Dispatch job for mail processing
        SendPlannedOutagesMail::dispatch($locations);
    }
}
