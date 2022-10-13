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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
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
