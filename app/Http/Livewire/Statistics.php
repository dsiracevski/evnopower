<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\View\View;
use Illuminate\Contracts\Foundation\Application;

class Statistics extends Component
{
    public function render(): View|Application
    {
        return view('livewire.statistics');
    }
}