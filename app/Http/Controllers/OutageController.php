<?php

namespace App\Http\Controllers;

use App\Jobs\SendPlannedOutagesMail;
use App\Models\Outage;
use App\Services\DownloadOutagesDocument;
use App\Services\OutageService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class OutageController extends Controller
{
    protected OutageService $outageService;

    public function __construct(OutageService $outageService)
    {
        $this->outageService = $outageService;
    }

    public function index()
    {
        $date = Carbon::parse(request('date')) ?: today();
        $location = request()->location ?: '';

        $locations = Outage::select('location')->distinct()->orderBy('location')->get();

        $plannedOutages = Outage::for($location)->betweenDates($date)->get();

        return view('outages.index', [
            'outages' => $plannedOutages,
            'date' => date_format($date, 'Y-m-d'),
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
            Log::error($e->getMessage());
        }

        // Dispatch job for mail processing
        SendPlannedOutagesMail::dispatch($locations);
    }
}
