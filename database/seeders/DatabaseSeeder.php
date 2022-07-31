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

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@evnopower.com',
            'password' => Hash::make('123')
        ]);

        $locations = ['Скопје Аеродром', 'Тетово', 'Куманово', 'Штип', 'Делчево'];

        foreach ($locations as $location) {
            Location::factory()->create(['name' => $location]);
        }

        $user = User::first();

        $locationToSync = Location::first();

        $user->locations()->sync([$locationToSync->id]);
    }


}
