<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

class Outage extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['start', 'end', 'created_at', 'updated_at'];

    protected $currentDate;


    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_outages')->withTimestamps();
    }

    /**
     * @param $query
     * @param $date
     * @return mixed
     */
    public function scopeBetweenDates($query, $date): mixed
    {
        $startDate = Carbon::parse($date)->subDay()->endOfDay();
        $endDate = Carbon::parse($date)->endOfDay();

        return $query->where(function ($query) use ($startDate, $endDate) {
            $query->where('start', '>=', $startDate)
                ->where('end', '<=', $endDate);
        });
    }

    public function scopeUpcomingOutages()
    {
        return $this->where('start', '>=', now()->toDateTimeString());
    }

    /**
     * @param $user
     * @return bool
     */
    public function notSentToUser($user): bool
    {
        return (!$this->users->contains($user)); // Check if there are any planned outages the user hasn't received a notification for yet
    }

}
