<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(Auth::user()->hasRole('Super Admin'), 403);
        return Role::all();
    }
}
