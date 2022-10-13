<?php

namespace App\Http\Controllers;

use App\Jobs\SendPlannedOutagesMail;
use App\Models\Outage;
use App\Services\DownloadOutagesDocument;
use App\Services\OutageService;
use Carbon\Carbon;
use Illuminate\Support\Benchmark;
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

        $locations = \DB::table('locations')->select('name')->get()->toArray();
        $plannedOutages = Outage::for($location)->betweenDates($date)->get();

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
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        // Dispatch job for mail processing
        SendPlannedOutagesMail::dispatch($locations);
    }
}
