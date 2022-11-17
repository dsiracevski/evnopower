<?php

namespace App\Http\Livewire;

use App\Models\Location;
use DB;
use Carbon\Carbon;
use App\Models\Outage;
use Livewire\Component;
use Illuminate\View\View;
use Livewire\WithPagination;
use App\Services\OutageService;
use Illuminate\Contracts\Foundation\Application;

class LiveTable extends Component
{
    use WithPagination;

    public int $userId;
    public string $date = '';
    public string $location = '';
    public array $locations = [];
    public string $sortBy = 'start';
    public array $searchLocations = [];

    private $outageService;

    public function mount(OutageService $outageService): void
    {
        $this->fill([
            'outageService' => $outageService,
            'date' => Carbon::parse($this->date) ?: today()
        ]);
    }

    public function updatedLocation()
    {
        $this->searchLocations = Location::where('name', 'like', '%'.$this->location.'%')
            ->pluck('name')
            ->toArray();
    }

    public function render(): View|Application
    {
        $outages = Outage::forLocation($this->location)
            ->forDate($this->date)
            ->whereIn('location', $this->userLocations())
            ->orderBy($this->sortBy)
            ->paginate(9);

        return view('livewire.live-table', compact('outages'));
    }

    public function sortBy($column): void
    {
        $this->sortBy = $column;
    }

    public function userLocations(): array
    {
        return $this->locations ?: DB::table('locations')->pluck('name')->toArray();
    }
}
