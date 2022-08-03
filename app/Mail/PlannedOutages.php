<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PlannedOutages extends Mailable
{
    use Queueable, SerializesModels;

    public $outages;

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($plannedOutages, $user)
    {
        // Get ONLY the outages for which the user hasn't received a notification for
        $this->outages = $plannedOutages->filter(function ($outage) {
            return $outage->notSentToUser($this->user);
        });

        $this->user = $user;

        // Add them to the list
        foreach ($this->outages as $outage) {
            $user->outages()->attach($outage->id);
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.upcoming-outages');
    }
}
