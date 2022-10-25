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

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_outages')->withTimestamps();
    }

    public function scopeWithinDate($query, $date): mixed
    {
        $startDate = Carbon::parse($date)->subDay()->endOfDay();
        $endDate = Carbon::parse($date)->endOfDay();

        return $query->where(function ($query) use ($startDate, $endDate) {
            $query->where('start', '>=', $startDate)
                ->where('end', '<=', $endDate);
        });
    }

    public function scopeForLocation($query, string $location): void
    {
        $query->when($location ?? false, function ($query, $location) {
            $query->where('location', 'LIKE', '%'.$location.'%');
        });
    }

    public function scopeLocationNames($query)
    {
        return $query->distinct('location');
    }

    public function scopeUpcomingOutages()
    {
        return $this->where('start', '>=', now()->toDateTimeString());
    }

    public function notSentToUser($user): bool
    {
        return (!$this->users->contains($user));
    }

    public function getStatusColorAttribute(): string
    {
        if ($this->end < now()) return 'grey';
        if ($this->start < now() && $this->end > now()) return 'yellow';
        if ($this->end > now()) return 'red';
    }

}
