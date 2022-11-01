<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\FamousPoint;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FamousPoint>
 */
class FamousPointFactory extends Factory
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
            'sender_id' => User::factory(),
            'type' => FamousPoint::TYPE_WORSHIP,
            'ajeje' => 1,
            'brazorf' => rand(1, 313),
        ];
    }
}
