<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Enums\UserInfoTypes;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserInfo>
 */
class UserInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'type' => UserInfoTypes::SOCIAL,
            'name' => $this->faker->randomElement(supportedSocialPlatforms()),
            'value' => url(\Str::random(31)),
        ];
    }
}
