<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class WelcomeController extends Controller
{
    function index() {
        $most_famous_users = User::orderByFamousPoints()->limit(13)->get();
        $latest_users = User::orderBy('id', 'desc')->limit(12)->get();
        return view('welcome', compact('most_famous_users', 'latest_users'));
    }
}
