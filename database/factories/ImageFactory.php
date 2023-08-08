<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'foto' => asset('assets/img/img-prod-vazio.png'),
            'descricao' => $this->faker->sentence(20),
            'principal' => 'N',
            'product_id' => rand(1, \App\Models\Product::count()),
        ];
    }
}
