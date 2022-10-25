<?php

namespace App\Http\Controllers;

use App\Jobs\SendPlannedOutagesMail;
use App\Services\DownloadOutagesDocument;
use App\Services\LocationService;
use App\Services\OutageService;
use Carbon\Carbon;
use Exception;
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

        $locations = \DB::table('locations')->select('name')->get()->toArray();
//        $plannedOutages = Outage::for($location)->betweenDates($date)->orderBy('start')->get();

        return view('outages.index', compact('date', 'locations'));
    }

    public function importFile(): void
    {
        $locations = '';
        try {
            $locations = (new DownloadOutagesDocument())->handle();
            SendPlannedOutagesMail::dispatch($locations);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
