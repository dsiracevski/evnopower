<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Location extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'location_user')->withTimestamps();
    }

    public function scopeOutages($query): void
    {
        $query->join('outages', function ($join) {
            $join->on('locations.name', '=', 'outages.location')
                ->where('outages.start', '>=', now());
        });
    }
}
