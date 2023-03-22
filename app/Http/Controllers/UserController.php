<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Auth;

class UserController extends Controller
{

    public function show(User $user)
    {
        $user=Auth::user();

        return Inertia::render('User/Show', [
          'user' => $user
        ]);
    }
}