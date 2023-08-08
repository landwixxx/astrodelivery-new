<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        /* Usuários */
        \App\Models\User::factory()->create([
            'email' => 'admin@teste.com',
            'profile' => 'admin',
            'status' => 'ativo'
        ])->assignRole('admin');

        $lojista = \App\Models\User::factory()->create([
            'email' => 'lojista@teste.com',
            'profile' => 'lojista',
            'status' => 'ativo'
        ])->assignRole('lojista');

        $lojista2 = \App\Models\User::factory()->create([
            'email' => 'lojista2@teste.com',
            'profile' => 'lojista',
            'status' => 'ativo'
        ])->assignRole('lojista');
        $lojista3 = \App\Models\User::factory()->create([
            'profile' => 'lojista',
            'status' => 'ativo'
        ])->assignRole('lojista');
        $lojista4 = \App\Models\User::factory()->create([
            'profile' => 'lojista',
            'status' => 'ativo'
        ])->assignRole('lojista');

        $cliente = \App\Models\User::factory()->create([
            'email' => 'cliente@teste.com',
            'profile' => 'cliente',
            'status' => 'ativo'
        ])->assignRole('cliente');

        $funcionarios = \App\Models\User::factory(30)->create([
            'profile' => 'funcionario',
        ]);
        foreach ($funcionarios as $key => $funcionario) {
            $funcionario->assignRole('funcionario');
        }

        /* Clientes */
        $clientes = \App\Models\User::factory(30)->create([
            'profile' => 'cliente',
        ]);
        foreach ($clientes as $key => $cliente) {
            $cliente->assignRole('cliente');
        }

        /* Adicionar dados na tabela de clientes */
        foreach (\App\Models\User::where('profile', 'cliente')->get() as $key => $value) {
            \App\Models\Customer::factory()->create([
                'user_id' => $value->id,
            ]);
        }

        /* Loja */
        $store = \App\Models\Store::factory()->create([
            'lojista_id' => $lojista->id,
            'nome' => 'Teste',
            'slug_url' => 'teste'
        ]);
        $store2 = \App\Models\Store::factory()->create([
            'lojista_id' => $lojista3->id,
        ]);
        $store3 = \App\Models\Store::factory()->create([
            'lojista_id' => $lojista4->id,
        ]);

        /* Alocar lojista para loja */
        \App\Models\StoreHasUsers::factory()->create([
            'store_id' => $store->id,
            'user_id' => $lojista->id,
        ]);
        \App\Models\StoreHasUsers::factory()->create([
            'store_id' => $store2->id,
            'user_id' => $lojista3->id,
        ]);
        \App\Models\StoreHasUsers::factory()->create([
            'store_id' => $store3->id,
            'user_id' => $lojista4->id,
        ]);

        /* Alocar funcionários para loja */
        foreach (\App\Models\User::where('profile', 'funcionario')->get() as $key => $value) {
            \App\Models\StoreHasUsers::factory()->create([
                'store_id' => $store->id,
                'user_id' => $value->id,
            ]);
        }

        /* Alocar clientes a loja */
        foreach (\App\Models\User::where('profile', 'cliente')->get() as $key => $value) {
            \App\Models\StoreHasCustomer::factory()->create([
                'store_id' => $store->id,
                'user_id' => $value->id,
            ]);
        }

        /* Categorias */
        foreach (['Sanduíche', 'Pizza', 'Suco', 'Refrigerante'] as $nome) {
            \App\Models\Category::factory(1)->create([
                'nome' => $nome,
                'store_id' => $store->id,
                'slug' => Str::slug($nome),
            ]);
        }

        /* Produtos */
        \App\Models\Product::factory(50)->create([
            'store_id' => $store->id
        ]);

        /* Contatos */
        \App\Models\Contact::factory(5)->create([
            'status' => 'pendente',
        ]);
        \App\Models\Contact::factory(30)->create([
            'status' => 'visualizado',
            'created_at' => now()->subSecond(10)
        ]);

        /* Pedidos para teste */
        for ($i = 0; $i < 5; $i++) {
            $lojistaTeste = \App\Models\User::factory()->create([
                'profile' => 'lojista',
                'status' => 'ativo',
                'account_expiration' => now()->addDays(rand(1, 7)),
            ])->assignRole('lojista');

            \App\Models\TestOrder::factory()->create([
                'status' => 'pendente',
                'user_id' => $lojistaTeste->id,
                'created_at' => now()->subSecond(10),
            ]);
        }

        for ($i = 0; $i < 50; $i++) {
            $lojistaTeste = \App\Models\User::factory()->create([
                'profile' => 'lojista',
                'status' => 'ativo',
                'account_expiration' => now()->subDays(rand(0, 7)),
            ])->assignRole('lojista');

            \App\Models\TestOrder::factory()->create([
                'status' => 'visualizado',
                'user_id' => $lojistaTeste,
            ]);
        }

        /* Gerar token para lojistas */
        foreach (\App\Models\User::where('profile', 'lojista')->get() as $key => $lojista) {
            if ($lojista->email == 'lojista@teste.com') {
                \App\Models\ShopkeeperToken::factory()->create([
                    'lojista_id' => $lojista->id,
                    'token' => 'TOKEN-NJnaAXaGwebLrWcaKaoD-M6pEKgn9XD7Y8gViiwor-X6HbJq9eOdOQWog93Dnh'
                ]);
            } else {
                \App\Models\ShopkeeperToken::factory()->create([
                    'lojista_id' => $lojista->id
                ]);
            }
        }

        /* Tipos de entrega */
        \App\Models\DeliveryType::factory(15)->create();

        /* Forma de pagamento */
        \App\Models\PaymentMethod::factory(15)->create();


        /**
         * Adicionar código em registros
         */
        foreach (\App\Models\Company::all() as $item) {
            $item->codigo = $item->id;
            $item->save();
        }
        foreach (\App\Models\Category::all() as $item) {
            $item->codigo = $item->id;
            $item->save();
        }
        foreach (\App\Models\PaymentMethod::all() as $item) {
            $item->codigo = $item->id;
            $item->save();
        }
        foreach (\App\Models\DeliveryType::all() as $item) {
            $item->codigo = $item->id;
            $item->save();
        }
        foreach (\App\Models\Order::all() as $item) {
            $item->codigo = $item->id;
            $item->save();
        }
        foreach (\App\Models\Product::all() as $item) {
            $item->codigo = $item->id;
            $item->save();
        }
        foreach (\App\Models\DeliveryZipCode::all() as $item) {
            $item->codigo = $item->id;
            $item->save();
        }
        foreach (\App\Models\DeliveryTable::all() as $item) {
            $item->codigo = $item->id;
            $item->save();
        }
        foreach (\App\Models\AdditionalGroup::all() as $item) {
            $item->codigo = $item->id;
            $item->save();
        }
    }
}
