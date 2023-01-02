<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\Tag;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Database\Seeder;

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
            ['email' => 'info@snappysnail.io'],
            [
                'name' => 'gE',
                'password' => bcrypt(env('USERS_GE_PWD', \Str::random(23))),
                'email_verified_at' => now(),
            ]
        );
        $tags = Tag::take(100)->get();
        for ($i = 0; $i < 300; $i++) {
            $users = User::factory()
                ->hasAttached($tags->random(5))
                ->has(UserInfo::factory()->count(3), 'socialLinks')
                ->has(Status::factory()->count(1))
                ->create();
        }
    }
}
