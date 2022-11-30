<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\User;
use \App\Models\Tag;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrCreate(
            ["email" => "info@snappysnail.io"],
            [
                'name' => 'gE',
                'password' => bcrypt(env('USERS_GE_PWD', \Str::random(23))),
                'email_verified_at' => now()
            ]
        );
        $tags = Tag::take(100)->get();
        for ($i=0; $i < 300; $i++) {
            $user_ids = User::select('id')->orderBy('id', 'desc')->take(100)->get();
            $users = User::factory()
                ->hasAttached($tags->random(5))
            ->create();
        }
    }
}
