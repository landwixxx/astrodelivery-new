<?php

namespace Database\Factories;

use App\Models\Store;
use App\Models\DeliveryType;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        if (is_null(Store::first()))
            return null;

        $store_id = Store::first()->id;
        return [
            'nome' => $this->faker->sentence(1),
            'descricao' => $this->faker->sentence(30),
            'tipo' =>  $this->faker->randomElement(['Balcão', 'Delivery', 'Mesa', 'Correios']),
            'icone' => $this->faker->randomElement(['fas fa-motorcycle', 'fas fa-truck']),
            'classe' => $this->faker->randomElement(['primary', 'secondary', 'danger', 'warning', 'dark']),
            'valor' => rand(5, 50),
            'valor_minimo' => rand(2, 5),
            'tempo' => '00:02:00',
            'ativo' => $this->faker->randomElement(['S', 'N']),
            'bloqueia_sem_cep' => $this->faker->randomElement(['S', 'N']),
            'store_id' => $store_id,
        ];
    }
}
