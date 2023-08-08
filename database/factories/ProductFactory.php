<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tipo' => $this->faker->randomElement(['PRODUTO', 'ADICIONAL']),
            'category_id' => rand(1, 4),
            'nome' => $this->faker->sentence(3),
            'sub_nome' => $this->faker->sentence(2),
            'cor_sub_nome' => '#FF0000',
            'descricao' => $this->faker->sentence(20),
            'valor_original' => rand(30, 150),
            'valor' => rand(30, 150),
            'estoque' => rand(2, 10),
            'limitar_estoque' => 'N',
            'fracao' => 'N',
            'item_adicional' => 'S',
            'item_adicional_obrigar' => 'N',
            'item_adicional_multi' => 'N',
            'adicional_qtde_min' => 0,
            'adicional_qtde_max' => rand(3, 10),
            'adicional_juncao' => $this->faker->randomElement(['SOMA', 'DIVIDIR', 'MEDIA']),
            // 'store_id',
        ];
    }
}
