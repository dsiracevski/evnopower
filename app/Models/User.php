<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Mail\Welcome;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use Ramsey\Collection\Collection;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot(): void
    {
        parent::boot();
        static::created(function (User $user) {
            Mail::to($user->email)->send(new Welcome($user->email));
        });
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class, 'location_user')->withTimestamps()->withPivot('location_id');
    }

    public function outages(): BelongsToMany
    {
        return $this->belongsToMany(Outage::class, 'user_outages')->withTimestamps();
    }

    public function scopeOutages(): Location|Collection
    {
        return $this->locations()->outages()->get();
    }
}
