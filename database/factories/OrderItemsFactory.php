<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => rand(1, 10),
            'product_id' => rand(1, 10),
            'pizza_id' => rand(1, 10),
        ];
    }
}
