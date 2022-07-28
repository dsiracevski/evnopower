<?php

namespace App\Http\Controllers;

use App\Mail\Welcome;
use App\Models\Location;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{


    public function chooseLocations()
    {
        $userLocations = (Auth::check()) ? auth()->user()->locations()->pluck('locations.id')->toArray() : [];

        return view('notifications.choose-locations', [
            'locations' => Location::all(),
            'userLocations' => $userLocations
        ]);
    }

    public function setLocations()
    {
        $attribute = request()->validate([
            'email' => 'required|email:rfc,dns',
            'location' => 'required|array'
        ]);

        $locations = Location::whereIn('id', $attribute['location'])->get();

        $user = $this->getUser($attribute['email']);

        try {
            $user->locations()->sync($attribute['location']);
            return redirect()->route('notification.choose-locations')->with('success', 'Зачувано!');
        } catch (Exception $exception) {
            Log::error($exception);
            return redirect()->back()->with('alert', 'Обидете се повторно!');
        }
    }

    public function getUser($email)
    {
        $name = explode("@", $email);
        $user = User::firstOrCreate(['email' => $email],
            ['name' => $name[0], 'password' => Hash::make($name[0])]);
        Auth::login($user);

        return $user;
    }

}
