<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cpf' => rand(100, 999) . '.' . rand(100, 999) . '.' . rand(100, 999) . '-01',
            'telefone' => rand(11111111111,99999999999),
            'whatsapp' => '(' . rand(10, 99) . ') 9' . rand(1000, 9999) . '-' . rand(1000, 9999),
            'dt_nascimento' => $this->faker->dateTimeBetween('-30 years', '-20 years'),
            'endereco' => $this->faker->sentence(2),
            'numero_end' => rand(10, 999),
            'ponto_referencia' => $this->faker->sentence(3),
            'complemento' => $this->faker->sentence(3),
            'estado' => $this->faker->randomElement(['São Paulo', 'Rio de Janeiro', 'Goiás']),
            'cidade' => $this->faker->sentence(1),
            'bairro' => $this->faker->sentence(2),
            'rua' => $this->faker->sentence(2),
            'cep' => rand(10000, 99999) . '-' . rand(100, 999)
        ];
    }
}
