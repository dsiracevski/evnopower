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

        return view('outages.index', [
            'outages' => Outage::filter()->orderBy((request()->filter) ?: "location")->get(),
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
