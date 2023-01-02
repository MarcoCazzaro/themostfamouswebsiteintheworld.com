<?php

namespace App\Http\Controllers;

use App\Repositories\CacheRepository;

class WelcomeController extends Controller
{
    public function index(CacheRepository $cache)
    {
        $most_famous_users = $cache->most_famous_users('people');
        $latest_users = $cache->latest_users();

        return view('welcome', compact('most_famous_users', 'latest_users'));
    }
}
