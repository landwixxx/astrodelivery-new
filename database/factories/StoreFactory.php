<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $nome = $this->faker->sentence(2);
        return [
            'nome' => str_replace('.', '', $nome),
            'slug_url' => Str::slug($nome),
            'descricao' => $this->faker->sentence(25),
            'email' => $this->faker->unique()->safeEmail(),
            'telefone' => '(' . rand(10, 99) . ') 9' . rand(1000, 9999) . '-' . rand(1000, 9999),
            'whatsapp' => '(' . rand(10, 99) . ') 9' . rand(1000, 9999) . '-' . rand(1000, 9999),

            'rua'  => 'Lorem ipsum',
            'numero_end' => rand(100, 1000),
            'uf' => $this->faker->randomElement(['SP', 'RJ', 'GO']),
            'cidade' => str_replace('.', '', $this->faker->sentence(1)),
            'bairro' => $this->faker->sentence(3),
            'cep' =>  '00000-000'
        ];
    }
}
