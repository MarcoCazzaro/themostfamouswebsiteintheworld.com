<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    function show(User $user) {
        return view('users.show', compact('user'));
    }
}
