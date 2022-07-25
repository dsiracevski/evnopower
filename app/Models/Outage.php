<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outage extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['start', 'end', 'created_at', 'updated_at'];

    
}
