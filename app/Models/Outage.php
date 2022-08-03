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


    public function users()
    {
        return $this->belongsToMany(User::class, 'user_outages')->withTimestamps();
    }

    public function scopeFilter($query)
    {
        $outage = self::latest('end')->first();

        ($outage->end >= now()) ? $this->currentDate = Carbon::today()->endOfDay() : $this->currentDate = Carbon::tomorrow()->endOfDay();

        $endDate = (request()->date) ? Carbon::parse(request()->date)->endOfDay() : $this->currentDate;

        $startDate = Carbon::parse($endDate)->startOfDay();

        return $query->where('location', 'like', '%'.request()->location.'%')->whereBetween('start',
            [$startDate, $endDate]);
        //TODO need to fix location filter, doesn't show entries other than today
    }

    public function scopeLocations($query)
    {
        $query->select('location')->distinct()->orderBy('location')->get();
    }

    public function scopeUpcomingOutages()
    {
        return $this->where(function ($query) {
            $query->where('start', '>=', now());
            $query->where('end', '<=', today()->endOfDay());
        });
    }

    // Check if there are any planned outages for the user-supplied locations
    public function qualifier($locations)
    {
        return in_array($this->location, $locations, true);
    }

    // Check if there are any planned outages the user hasn't received a notification for yet
    public function notSentToUser($user)
    {
        return !$this->users->contains($user->id);
    }

}
