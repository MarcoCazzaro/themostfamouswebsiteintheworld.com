<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        switch (rand(1,4)) {
            case 1:
                $name = fake()->name();
                break;
            case 2:
                $name = fake()->city();
                break;
            case 3:
                $name = fake()->country();
                break;
            case 4:
                $name = fake()->company();
                break;

            default:
                $name = random(13);
                break;
        }
        $name = formatTagName($name);
        $slug = $name;
        $locale = 'en_US';
        return compact('name', 'slug', 'locale');
    }
}
