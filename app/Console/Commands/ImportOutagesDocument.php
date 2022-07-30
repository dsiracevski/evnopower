<?php

namespace App\Console\Commands;

use App\Mail\PlannedOutages;
use App\Models\Outage;
use App\Models\User;
use App\Services\DownloadOutagesDocument;
use App\Services\NotifyUsersAboutNewOutages;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ImportOutagesDocument extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'outages:import';

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
        try {
            (new DownloadOutagesDocument())->handle();
        } catch (\Exception $e) {
            // Log something
        }

        return 0;
    }
}
