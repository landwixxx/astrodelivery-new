<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TestOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $email = $this->faker->unique()->safeEmail();
        return [
            'nome' => $this->faker->name(),
            'email' => $email,
            'meio_contato' => 'e-mail',
            'contato' => $this->faker->email(),
            'msg' => $this->faker->sentence(8),
            'created_at' => $this->faker->dateTimeBetween(date('Y-m-01 H:i:s', strtotime('- 1 months')), date('Y-m-28 H:i:s', strtotime('- 1 months'))),
        ];
    }
}
