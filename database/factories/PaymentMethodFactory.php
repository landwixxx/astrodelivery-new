<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentMethodFactory extends Factory
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
            'tipo' =>  $this->faker->randomElement(['DINHEIRO', 'CARTAO', 'GATEWAY', 'OUTROS', 'BOLETO']),
            'icone' => $this->faker->randomElement(['far fa-money-bill-alt', 'fab fa-cc-visa']),
            'classe' => $this->faker->randomElement(['primary', 'secondary', 'danger', 'warning', 'dark', 'success']),
            'ativo' => $this->faker->randomElement(['S', 'N']),
            'store_id' => $store_id,
        ];
    }
}
