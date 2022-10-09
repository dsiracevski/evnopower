<?php

namespace App\View\Components;

use App\Models\Outage;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class Table extends Component
{
    /**
     * @param  Collection|Outage[]  $outages
     */
    public function __construct(
        public Collection|array $outages
    ) {
    }

    public function render(): View
    {
        return view('components.full-table');
    }
}
