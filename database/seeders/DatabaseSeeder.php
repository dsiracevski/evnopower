<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Location;
use App\Models\Outage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call([
            LocationSeeder::class
        ]);

        User::factory()->create([
        'name' => 'Admin',
        'email' => 'admin@evnopower.com',
        'password' => Hash::make('123')
    ]);

        $user = User::first();

        $locationToSync = Location::first();

        $user->locations()->sync([$locationToSync->id]);
    }


}
