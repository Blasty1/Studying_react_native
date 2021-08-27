<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Storage;

class SocialLogin extends Controller
{
    public function linkGetInfoFromAccountGoogle()
    {
        return response()->json(Socialite::with('google')->stateless()->redirect()->getTargetUrl());
    }

    public function loginGoogle()
    {
        $userInGoogle = Socialite::with('google')->stateless()->user();

        $userInDb = User::where('email', $userInGoogle->email)->first();
        if (!$userInDb) {
            User::create(
                [
                    'name' => $userInGoogle->name,
                    'email' => $userInGoogle->email,
                    'google_id' => \Hash::make($userInGoogle->id),

                ]
            );
        }
        if (\Hash::check($userInGoogle->id, $userInDb->google_id)) {
            throw ValidationException::withMessages([
                'google_id' => 'errore , id non corrispondono'
            ]);
        }
        return redirect()->away(config("api.app_link") . "?". $userInDb->createToken($userInDb->id)->plainTextToken);
    }

}

