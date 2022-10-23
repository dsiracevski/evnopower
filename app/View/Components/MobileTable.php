<?php

namespace App\View\Components;

use App\Models\Outage;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class MobileTable extends Component
{
    /**
     * @param  Collection|LengthAwarePaginator|Outage[]  $outages
     */
    public function __construct(
        public Collection|LengthAwarePaginator|array $outages
    ) {
    }

    public function render(): View
    {
        return view('components.mobile-table');
    }
}
