<?php

namespace App\Mail;

use App\Models\Outage;
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
    public function __construct($userOutages, $user)
    {
        $this->outages = $userOutages->whereIn('location', $user->locations()->pluck('name'));
        $this->user = $user;
        // Add them to the list{
            $this->user->outages()->attach($userOutages);
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
