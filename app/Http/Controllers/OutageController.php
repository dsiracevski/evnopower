<?php

namespace App\Http\Controllers;

use App\Jobs\SendPlannedOutagesMail;
use App\Services\DownloadOutagesDocument;
use App\Services\LocationService;
use App\Services\OutageService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class OutageController extends Controller
{
    public function __construct(private LocationService $locationService, private OutageService $outageService)
    {
    }

    public function index()
    {
        $date = Carbon::parse(request('date')) ?: today();
        $location = request()->location ?: '';

        $plannedOutages = $this->outageService->getUpcomingPowerOutagesForLocationWithinDate($location, $date);
        $locations = $this->locationService->getLocationNamesForUpcomingPowerOutages($plannedOutages);

        return view('outages.index', compact('date', 'locations', 'plannedOutages'));
    }

    /**
     * Import file for planned outages
     * @return void
     */
    public function importFile()
    {
        $locations = '';
        try {
            $locations = (new DownloadOutagesDocument())->handle();
            SendPlannedOutagesMail::dispatch($locations);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        // Dispatch job for mail processing
    }
}
