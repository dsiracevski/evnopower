<?php

namespace App\Models;

//use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Outage extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['start', 'end', 'created_at', 'updated_at'];

    protected $currentDate;


    public function scopeFilter($query)
    {
        $outage = self::latest('end')->first();

        ($outage->end <= now()) ? $this->currentDate = Carbon::today()->endOfDay() : $this->currentDate = Carbon::tomorrow()->endOfDay();

        $endDate = (request()->date) ? Carbon::parse(request()->date)->endOfDay() : $this->currentDate;

        $startDate = Carbon::parse($endDate)->startOfDay();

        return $query->where('location', 'like', '%'.request()->location.'%')->whereBetween('start', [$startDate, $endDate]);

        //TODO need to fix location filter, doesn't show entries other than today
    }

    public function scopeLocations($query)
    {
        $query->select('location')->distinct()->orderBy('location')->get();
    }

}
