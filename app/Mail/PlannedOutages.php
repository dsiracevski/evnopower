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
        $this->outages = $plannedOutages->filter(function ($outage) {
            return $outage->notSentToUser($this->user);
        });
        $this->user = $user;

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
