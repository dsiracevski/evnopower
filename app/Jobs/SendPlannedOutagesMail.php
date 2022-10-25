<?php

namespace App\Jobs;

use App\Services\NotifyUsersAboutNewOutages;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPlannedOutagesMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle(): void
    {
        (new NotifyUsersAboutNewOutages())->handle();
    }
}
