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
        $this->outages = $plannedOutages; // remove this when you implement the below commented code
        $this->user = $user;

//        $this->outages = $plannedOutages->filter(function ($outage) {
//            $check = ! $outage->notified_users->contains($this->user->id);
//            // return only the outages the user has not received an email for
//
//            if ($check) {
//                // add the user id to the new outages_users table
//            }
//
//            return $check;
//        });
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
