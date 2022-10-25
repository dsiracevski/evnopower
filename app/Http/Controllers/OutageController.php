<?php

namespace App\Http\Controllers;

use App\Jobs\SendPlannedOutagesMail;
use App\Models\Outage;
use App\Services\DownloadOutagesDocument;
use App\Services\LocationService;
use App\Services\OutageService;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Support\Facades\Log;

class OutageController extends Controller
{
    public function index()
    {
        $date = Carbon::parse(request('date')) ?: today();

        return view('outages.index', compact('date'));
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
