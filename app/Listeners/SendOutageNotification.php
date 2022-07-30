<?php

namespace App\Listeners;

use App\Events\PlannedOutagesDocumentImported;
use App\Jobs\SendPlannedOutagesMail;

class SendOutageNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\PlannedOutagesDocumentImported  $event
     * @return void
     */
    public function handle(PlannedOutagesDocumentImported $event)
    {
        SendPlannedOutagesMail::dispatch($event->locations);
    }
}
