<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Auth;

class AuthController extends Controller
{
    public function index()
    {
        return Socialite::driver('google')->with(['hd' => 'accesstechnology.co.uk'])->redirect();
    }

    public function callback()
    {
        $user = Socialite::driver('google')->stateless()->user();

        $authUser = $this->findOrCreateUser($user);
        Auth::login($authUser, true);

        return redirect('/dashboard');
    }

    public function findOrCreateUser($user)
    {
        $authUser = User::where('google_id', $user->id)->first();
        if ($authUser) {
            return $authUser;
        }

        return User::create([
            'name'     => $user->name,
            'email'    => $user->email,
            'google_id' => $user->id,
            'avatar' => $user->avatar,
            'role'    => '',
            'active'    => '0',
        ]);
    }

    //logout
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}

