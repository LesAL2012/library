<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isEmpty;

class ProviderController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {

        $userProvider = Socialite::driver($provider)->user();

        $user = User::updateOrCreate([
            'email' => $userProvider->email,
        ], [
            'name' => $userProvider->name,
            'provider_token' => $userProvider->token,
            'provider_id' => $userProvider->id,
            'provider' => $provider,

            'password' => Hash::make(date('h-i-s, j-m-y, it is w Day')),
        ]);

        if (count($user->roles->toArray()) == 0) {
            $user->addRole('reader');
        }

        Auth::login($user);

        return redirect('/');
    }
}
