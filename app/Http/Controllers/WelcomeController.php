<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class WelcomeController extends Controller
{
    function index() {
        $registered_users = User::orderBy('id', 'desc')->limit(31)->get();
        return view('welcome', compact('registered_users'));
    }
}
