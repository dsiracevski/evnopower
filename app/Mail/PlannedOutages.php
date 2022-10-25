<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class PlannedOutages extends Mailable
{
    use Queueable, SerializesModels;

    public Collection $outages;

    public User $user;

    public function __construct($userOutages, User $user)
    {
        $this->outages = $userOutages->whereIn('location', $user->locations()->pluck('name'));
        $this->user = $user;

        $this->user->outages()->attach($this->outages);
    }

    public function build(): PlannedOutages
    {
        return $this->markdown('emails.upcoming-outages');
    }
}
