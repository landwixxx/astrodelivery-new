<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\CategoryProductsController;
use App\Http\Controllers\Auth\LoginCustomerController;
use App\Http\Controllers\Auth\RegisterCustomerController;
use App\Http\Controllers\Customer\DataCustomerController;
use App\Http\Controllers\Customer\RecentOrdersController;
use App\Http\Controllers\Customer\AssemblePizzaController;
use App\Http\Controllers\Customer\DeliveryFormsController;
use App\Http\Controllers\Customer\OrderAssemblePizzaController;
use App\Http\Controllers\Customer\AssemblePizzaProductController;

/*
|--------------------------------------------------------------------------
| Rotas para utilizar com subdominio da loja
|--------------------------------------------------------------------------
*/

/**
 * Obter o prefixo do subdominio
 * 
 * $subdomain -> recebe o subdomino da loja
 * Ref: https://www.educative.io/answers/how-to-create-and-manage-subdomains-in-laravel-applications
 */

// Loja
Route::get('/', [StoreController::class, 'redirectToHome']);
Route::get('/home', [StoreController::class, 'home'])->name('loja.index');
Route::get('/desativado', [StoreController::class, 'storeDisabled'])->name('loja.desativada');
Route::get('/p/{product}/{slug_produto?}', [OrderController::class, 'addProduct'])->name('loja.produto.add');
Route::get('/pizza/{product}', [OrderController::class, 'addPizza'])->name('loja.pizza.add');

// Montar pizza
// sabores
Route::get('/montar-pizza/sabores', [AssemblePizzaController::class, 'flavors'])->name('loja.montar-pizza.sabores');
Route::post('/montar-pizza/sabores', [AssemblePizzaController::class, 'flavorsSave'])->name('loja.montar-pizza.sabores.salvar');
// bordas
Route::get('/montar-pizza/bordas', [AssemblePizzaController::class, 'edge'])->name('loja.montar-pizza.bordas');
Route::post('/montar-pizza/bordas', [AssemblePizzaController::class, 'edgeSave'])->name('loja.montar-pizza.bordas.salvar');
// tamnahos
Route::get('/montar-pizza/tamanhos', [AssemblePizzaController::class, 'size'])->name('loja.montar-pizza.tamanhos');
Route::post('/montar-pizza/tamanhos', [AssemblePizzaController::class, 'sizeSave'])->name('loja.montar-pizza.tamanhos.salvar');
// adicionais
Route::get('/montar-pizza/adicionais', [AssemblePizzaController::class, 'additionals'])->name('loja.montar-pizza.adicionais');
Route::post('/montar-pizza/adicionais', [AssemblePizzaController::class, 'additionalsSave'])->name('loja.montar-pizza.adicionais.salvar');
// revisão
Route::get('/montar-pizza/revisao', [AssemblePizzaController::class, 'revision'])->name('loja.montar-pizza.revisao');
Route::post('/montar-pizza/salvar-pedido', [OrderAssemblePizzaController::class, 'createOrder'])
    ->name('loja.montar-pizza.salvar-pedido');
// carrinho monta pizza
Route::get('/montar-pizza/remover-do-carrinho/{index}', [OrderAssemblePizzaController::class, 'removerPizzaCard'])
    ->name('loja.montar-pizza.remover-do-carrinho');

// Montar pizza produto
Route::get('/pizza/{product}', [AssemblePizzaProductController::class, 'index'])->name('loja.produto.pizza');
Route::post('/pizza/fazer-pedido/{product}', [AssemblePizzaProductController::class, 'createOrder'])->name('loja.produto.pizza.fazer-pedido');

// Categoria
Route::get('/c/{slug_category}', [CategoryProductsController::class, 'index'])->name('loja.categoria.index');

// Login cliente
Route::get('/login', [LoginCustomerController::class, 'loginCustomerForm'])->name('cliente.login');
Route::post('/login', [LoginCustomerController::class, 'login'])->name('cliente.login.post');

// Cadastro do cliente
Route::get('/cadastro', [RegisterCustomerController::class, 'showFormRegister'])->name('cliente.cadastro');
Route::post('/cadastro', [RegisterCustomerController::class, 'register'])->name('cliente.cadastro.store');
// Logout
Route::post('/logout', [LoginCustomerController::class, 'logout'])->name('cliente.logout');

// Meus dados (cliente)
Route::get('/meus-dados', [DataCustomerController::class, 'index'])->name('cliente.meus-dados');
Route::put('/meus-dados/pessoal', [DataCustomerController::class, 'updatePersonalData'])->name('cliente.meus-dados.up-pessoal');
Route::put('/meus-dados/credenciais', [DataCustomerController::class, 'updateCredentials'])->name('cliente.meus-dados.up-credenciais');

// Pedidos recentes
Route::get('/pedidos-recentes', [RecentOrdersController::class, 'index'])->name('cliente.pedidos-recentes');
// Visualizar pedido
Route::get('/pedido/{order}', [RecentOrdersController::class, 'order'])->name('cliente.pedido');
Route::get('/pedido/remover/{order}', [RecentOrdersController::class, 'removeOrder'])->name('cliente.remover-pedido');
Route::get('/repetir-pedido/{order}', [RecentOrdersController::class, 'repeatOrder'])->name('cliente.repetir-pedido');

// Selecionar forma de entrega
Route::get('/formas-de-entrega-e-pagamento', [DeliveryFormsController::class, 'index'])->name('cliente.formas-entrega-e-pagamento');
Route::get('/formas-de-entrega-e-pagamento/mesas', [DeliveryFormsController::class, 'jsonDeliveryTables'])
    ->name('cliente.formas-entrega-e-pagamento.mesas');
Route::get('/formas-de-entrega-e-pagamento/metodos-pagamento', [DeliveryFormsController::class, 'jsonPaymentMethods'])
    ->name('cliente.formas-entrega-e-pagamento.metodos-pagamento');
Route::get('/formas-de-entrega-e-pagamento/busca-cep', [DeliveryFormsController::class, 'searchCep'])
    ->name('cliente.formas-entrega-e-pagamento.busca-cep');

// carrrinho
Route::post('/adicionar-carrinho', [OrderController::class, 'addCart'])->name('cliente.adicionar-carrinho');
Route::get('/remover-carrinho', [OrderController::class, 'rem_cart'])->name('cliente.remover-carrinho');
Route::get('/listar-carrinho', [OrderController::class, 'list_items'])->name('cliente.listar-carrinho');
Route::post('/finalizar-pedido', [OrderController::class, 'store'])->name('cliente.finalizar-pedido');

// Resumo do pedido
Route::get('/resumo-do-pedido', [OrderController::class, 'orderSummary'])->name('cliente.resumo-pedido');
Route::get('/resumo-do-pedido/remover-item/{product_id}', [OrderController::class, 'removeItemCart'])
    ->name('cliente.resumo-pedido.remover-item');
Route::get('/resumo-do-pedido/remover-pizza-p/{key}', [OrderController::class, 'removePizzaProductCart'])
    ->name('cliente.resumo-pedido.remover-carrinho-produto-pizza');
