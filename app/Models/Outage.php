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

    protected $date;


    public function scopeFilter($query)
    {
        $outage = self::latest('end')->first();

        if ($outage->end <= now()) {
            $this->date = Carbon::today()->endOfDay();
        } else {
            $this->date = Carbon::tomorrow()->endOfDay();
        }

        if (request('date')) {
            $endDate = (request()->date) ? Carbon::parse(request()->date)->endOfDay() : $this->date;

            $startDate = Carbon::parse($endDate)->startOfDay();

            return $query->whereBetween('start', [$startDate, $endDate]);
        }

        if (request('area')) {
            return $query->where('area', 'like', '%'.request()->area.'%');
        }

    }

}
