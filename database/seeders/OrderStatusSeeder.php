<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderStatus;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderStatus::create(['nome' => 'AGUARDANDO ACEITE', 'classe_css' => 'text-bg-warning']); // 1
        OrderStatus::create(['nome' => 'ACEITO', 'classe_css' => 'text-bg-primary']); // 2
        OrderStatus::create(['nome' => 'EM PRODUÇÃO', 'classe_css' => 'text-bg-info']); // 3
        OrderStatus::create(['nome' => 'EM ROTA DE ENTREGA', 'classe_css' => 'text-bg-secondary']); // 4
        OrderStatus::create(['nome' => 'ENTREGUE', 'classe_css' => 'text-bg-success']); // 5
        OrderStatus::create(['nome' => 'CANCELADO', 'classe_css' => 'text-bg-danger']); // 6
        OrderStatus::create(['nome' => 'FINALIZADO', 'classe_css' => 'text-bg-dark']); // 7
    }
}
