<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function getRedirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function getHandleGoogleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();
        // dd($user);
        $finduser = User::where('google_id', $user->getId())->first();

        if ($finduser) {
            Auth::login($finduser);
            return redirect()->intended('dashboard');
        } else {
            $newUser = User::create([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'picture' => $user->getAvatar(),
                'google_id' => $user->getId(),
                'password' => bcrypt('12345678')
            ]);

            Auth::login($newUser);
            return redirect()->intended('dashboard');
        }
    }
}
