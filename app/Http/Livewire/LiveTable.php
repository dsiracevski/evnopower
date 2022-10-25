<?php

namespace App\Http\Livewire;

use App\Models\Outage;
use App\Services\OutageService;
use Carbon\Carbon;
use DB;
use Livewire\Component;
use Livewire\WithPagination;

class LiveTable extends Component
{
    use WithPagination;

    public $sortBy = 'start';
    public $location = [];
    public $search = '';
    public $date = '';
    public int $userId;


    private $outageService;

    public function mount(OutageService $outageService): void
    {
        $this->outageService = $outageService;
    }

    public function sortBy($column): void
    {
        $this->sortBy = $column;
    }

    public function render()
    {

        $date = Carbon::parse($this->date) ?: today();
        $locations = $this->location ?: DB::table('locations')->pluck('name')->toArray();

        $outages = Outage::where('location', 'like', '%'.$this->search.'%')
            ->withinDate($date)
            ->whereIn('location', $locations)
            ->orderBy($this->sortBy)
            ->paginate(9);
        
        return view('livewire.live-table', compact('date', 'outages', 'locations'));
    }
}
