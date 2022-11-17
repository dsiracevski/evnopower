<?php

namespace App\Http\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;
use App\Models\Location;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Foundation\Application;

class Notifications extends Component
{
    public Collection $nonSubscribedLocations;
    public Collection $subscribedLocations;

    public function mount(): void
    {
        $this->fill([
            'nonSubscribedLocations' => Location::whereNotIn('locations.name', $this->userLocationNames())->get(),
            'subscribedLocations' => Location::whereIn('locations.name', $this->userLocationNames())->get()
        ]);
    }

    public function render(): View|Application
    {
        return view('livewire.notifications');
    }

    public function userLocationNames(): Collection|array
    {
        return (Auth::check()) ? auth()->user()?->locations()->pluck('name') : [];
    }
}