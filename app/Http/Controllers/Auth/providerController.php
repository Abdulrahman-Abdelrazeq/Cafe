<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Added for Auth facade
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class ProviderController extends Controller
{
    // Method to redirect the user to the social login provider
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    // Method to handle the callback after the user logs in via social provider
    public function callback($provider)
    {
        // Retrieve user data from the social provider
        $socialUser = Socialite::driver($provider)->user();

        // Update or create a user record based on the provider's user id
        $user = User::updateOrCreate(
            [
                'provider_id' => $socialUser->getId(),
                'provider' => $provider,
            ],
            [
                'username' => $socialUser->getNickname(),
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'provider_token' => $socialUser->token,
            ]
        );

        // Log in the user
        Auth::login($user);

        // Redirect the user to the dashboard
        return redirect('/home');
    }
}
