<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $nome = $this->faker->randomElement(['Sanduíche', 'Pizza', 'Suco', 'Refrigerante']);
        return [
            'nome' => $nome,
            'descricao' => $this->faker->text(),
            'slug' => Str::slug($nome),
        ];
    }
}