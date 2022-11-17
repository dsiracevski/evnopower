<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendPlannedOutagesMail;
use App\Services\DownloadOutagesDocument;

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
