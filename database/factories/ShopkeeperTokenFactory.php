<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShopkeeperTokenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'token' => 'TOKEN-' . Str::random(20) . '-' . Str::random(20) . '-' . Str::random(20),
            // 'token' => 'TOKEN-NJnaAXaGwebLrWcaKaoD-M6pEKgn9XD7Y8gViiwor-X6HbJq9eOdOQWog93Dnh'
            // 'lojista_id' => 
        ];
    }
}
