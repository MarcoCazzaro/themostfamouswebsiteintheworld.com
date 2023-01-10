<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Laravel\Jetstream\Jetstream;

class WelcomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function cookie_policy()
    {
        $cookiesFile = Jetstream::localizedMarkdownPath('cookies.md');

        return view('cookies', [
            'cookies' => Str::markdown(file_get_contents($cookiesFile)),
        ]);
    }
}
