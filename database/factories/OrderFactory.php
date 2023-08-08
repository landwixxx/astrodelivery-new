<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => rand(1, 10),
            'taxa_entrega' => '3.00',
            'entrega' => $this->faker->randomElement(['local', 'delivery']),
            'pagamento' => $this->faker->randomElement(['maquina', 'dinheiro']),
            'observacao' => $this->faker->sentence(5),
            'status' => $this->faker->randomElement(['Pendente', 'Aprovado', 'Negado', 'Em Preparo', 'Finalizado', 'Entregue']),
        ];
    }
}