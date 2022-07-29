<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlannedOutagesDocumentImported
{
    use Dispatchable, SerializesModels;

public $locations;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($locations)
    {
        $this->locations = $locations;
    }

}
