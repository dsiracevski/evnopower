<?php

namespace App\Http\Livewire;

use App\Models\Outage;
use App\Services\OutageService;
use Carbon\Carbon;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

class LiveTable extends Component
{
    use WithPagination;

    public $sortBy = 'start';
    public $location = [];
    public $search = '';
    public $date = '';


    private $outageService;

    public function mount(OutageService $outageService)
    {
        $this->outageService = $outageService;
    }

    public function sortBy($column)
    {
        $this->sortBy = $column;
    }

    public function whereLocation($location)
    {
        $this->location = $location;
    }

    public function render()
    {
        $date = Carbon::parse($this->date) ?: today();
        $locations = $this->location ?: DB::table('locations')->pluck('name')->toArray();

        $outages = Outage::where('location', 'like', '%'.$this->search.'%')
            ->whereIn('location', $locations)
            ->betweenDates($date)
            ->orderBy($this->sortBy)
            ->paginate(8);
        
        return view('livewire.live-table', compact('date', 'outages', 'locations'));
    }
}
