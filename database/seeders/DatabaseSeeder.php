<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\User;
use \App\Models\FamousPoint;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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
        $users = User::factory(31)
            ->hasFamousPoints( rand(1,13) ,
                [
                    'sender_id' => 1
                ]
            )
        ->create();
    }
}
