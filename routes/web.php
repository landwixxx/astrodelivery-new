<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SendContactController;
use App\Http\Controllers\DisabledUserController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DataAdminController;
use App\Http\Controllers\Admin\InvoicingController;
use App\Http\Controllers\RequestFreeTrialController;
use App\Http\Controllers\Shopkeeper\UsersController;
use App\Http\Controllers\Shopkeeper\ConfigController;
use App\Http\Controllers\Auth\RegisterAdminController;
use App\Http\Controllers\Shopkeeper\CompanyController;
use App\Http\Controllers\Shopkeeper\ProductController;
use App\Http\Controllers\Shopkeeper\CategoryController;
use App\Http\Controllers\Shopkeeper\CustomerController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\RequestsToTestController;
use App\Http\Controllers\Admin\AdminShopkeeperController;
use App\Http\Controllers\Shopkeeper\MontarPizzaController;
use App\Http\Controllers\Shopkeeper\StoreImagesController;
use App\Http\Controllers\Shopkeeper\DeliveryTypeController;
use App\Http\Controllers\Shopkeeper\OpeningHoursController;
use App\Http\Controllers\Shopkeeper\PizzaProductController;
use App\Http\Controllers\Shopkeeper\DeliveryTableController;
use App\Http\Controllers\Shopkeeper\PaymentMethodController;
use App\Http\Controllers\Shopkeeper\DataShopkeeperController;
use App\Http\Controllers\Shopkeeper\NotifyNewOrderController;
use App\Http\Controllers\Shopkeeper\AdditionalGroupController;
use App\Http\Controllers\Shopkeeper\DeliveryZipCodeController;
use App\Http\Controllers\Shopkeeper\OrderShopkeeperController;
use App\Http\Controllers\Shopkeeper\PromotionalBannerController;
use App\Http\Controllers\Shopkeeper\DashboardShopkeeperController;
use App\Http\Controllers\Shopkeeper\ProductsWithAdditionalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Página Incial
Route::get('/', [HomeController::class, 'index'])->name('pagina-inicial');

// Auth
Auth::routes(['register' => false]);

/* Redirecionar para painel */
Route::get('/painel', [DashboardController::class, 'redirect'])->name('painel.redirect');

// Cadastro Admin
Route::get('/cadastro-admin', [RegisterAdminController::class, 'index'])->name('auth.register.admin');
Route::post('/cadastro-admin', [RegisterAdminController::class, 'store'])->name('auth.register.admin.store');

// Usuário desativado
Route::get('/usuario-desativado', [DisabledUserController::class, 'index'])->name('usuario-desativado');

// Conta expirada
Route::get('/conta-expirada', function () {
    return view('front.conta_expirada');
})->name('conta-expirada');

// Solicitar teste grátis
Route::get('/solicitar-teste-gratis', [RequestFreeTrialController::class, 'index'])->name('solicitar-teste-gratis');
Route::post('/solicitar-teste-gratis', [RequestFreeTrialController::class, 'store'])->name('solicitar-teste-gratis.store');

// Enviar Contato
Route::post('/enviar-contato', [SendContactController::class, 'store'])->name('enviar-contato');

// Lojista
Route::name('painel.lojista.')->prefix('/painel/lojista')->group(function () {
    Route::get('/', [DashboardShopkeeperController::class, 'index'])->name('index');

    // Usuários
    Route::put('/usuarios/up-credenciais/{usuario}', [UsersController::class, 'updateCredentials'])->name('usuarios.up-credenciais');
    Route::resource('/usuarios', UsersController::class)->except(['show']);

    // Clientes
    Route::get('/clientes/{customer}/banir', [CustomerController::class, 'banCustomer'])->name('clientes.banir');
    Route::get('/clientes/{customer}/desbanir', [CustomerController::class, 'unbanCustomer'])->name('clientes.desbanir');
    Route::resource('/clientes', CustomerController::class)->except(['update', 'delete']);

    // Dados da emrpesa
    Route::get('/dados-da-empresa', [CompanyController::class, 'index'])->name('dados-da-empresa.index');
    Route::put('/dados-da-empresa', [CompanyController::class, 'updateCompany'])->name('dados-da-empresa.update');

    // Imagens da empresa
    Route::get('/imagens-da-loja', [StoreImagesController::class, 'index'])->name('imagens-da-loja');
    Route::put('/imagens-da-loja', [StoreImagesController::class, 'updateImages'])->name('imagens-da-loja.update');
    Route::get('/imagens-da-loja/selecionar-banner', [PromotionalBannerController::class, 'selectBanner'])->name('imagens-da-loja.selecionar-banner');
    Route::post('/imagens-da-loja/cadastrar-banner', [PromotionalBannerController::class, 'createSave'])->name('imagens-da-loja.cadastrar-banner');
    Route::get('/imagens-da-loja/excluir/{banner}', [PromotionalBannerController::class, 'delete'])->name('imagens-da-loja.excluir');
    Route::put('/imagens-da-loja/selecionar-banner', [PromotionalBannerController::class, 'selectBannerSave'])
        ->name('imagens-da-loja.selecionar-banner-save');
    Route::get('/imagens-da-loja/ativar-banner/{banner}', [PromotionalBannerController::class, 'activeBanner'])->name('imagens-da-loja.ativar-banner');
    Route::get('/imagens-da-loja/desativar-banner/{banner}', [PromotionalBannerController::class, 'disabledBanner'])->name('imagens-da-loja.desativar-banner');

    // Horário de atendimento   
    Route::get('/horario-de-atendimento', [OpeningHoursController::class, 'index'])->name('horario-atendimento');
    Route::put('/horario-de-atendimento', [OpeningHoursController::class, 'updateHours'])->name('horario-atendimento.update');

    // Categorias
    Route::resource('/categorias', CategoryController::class)->parameter('categorias', 'category')->except(['show']);

    // Meus dados
    Route::get('/meus-dados', [DataShopkeeperController::class, 'index'])->name('meus-dados');
    Route::put('/meus-dados/pessoal', [DataShopkeeperController::class, 'updatePersonalData'])->name('meus-dados.pessoal');
    Route::put('/meus-dados/credenciais', [DataShopkeeperController::class, 'updateCredentials'])->name('meus-dados.credenciais');

    // Configurações
    Route::get('/configuracoes', [ConfigController::class, 'index'])->name('configuracoes');
    Route::put('/configuracoes/atualizar-dados-loja', [ConfigController::class, 'updateStoreData'])->name('configuracoes.atualizar-dados-loja');
    Route::put('/configuracoes/alternar-loja-aberta', [ConfigController::class, 'toggleStoreOpen'])->name('configuracoes.alternar-loja-aberta');

    // Pedidos
    Route::put('/pedidos/{order}/aceitar', [OrderShopkeeperController::class, 'acceptOrder'])->name('pedidos.aceitar');
    Route::put('/pedidos/{order}/cancelar', [OrderShopkeeperController::class, 'cancelOrder'])->name('pedidos.cancelar');
    Route::put('/pedidos/{order}/em-producao', [OrderShopkeeperController::class, 'inProductionOrder'])->name('pedidos.em-producao');
    Route::put('/pedidos/{order}/em-rota-entrega', [OrderShopkeeperController::class, 'onDeliveryRouteOrder'])->name('pedidos.em-rota-entrega');
    Route::put('/pedidos/{order}/entregue', [OrderShopkeeperController::class, 'deliveredOrder'])->name('pedidos.entregue');
    Route::put('/pedidos/{order}/finalizado', [OrderShopkeeperController::class, 'finishedOrder'])->name('pedidos.finalizado');
    Route::resource('/pedidos', OrderShopkeeperController::class)
        ->parameter('pedidos', 'order')
        ->except(['create', 'store', 'edit', 'update']);

    // Notificar novo pedido
    Route::get('/dados-novo-pedido', [NotifyNewOrderController::class, 'getData'])->name('dados-novo-pedido');
    Route::get('/add-sessao-total-pedidos', [NotifyNewOrderController::class, 'addSession'])->name('add-sessao-total-pedidos');

    // Produtos
    Route::get('/produtos', [ProductController::class, 'index'])->name('produtos.index');
    Route::get('/produtos/desativar/{produto}', [ProductController::class, 'desativar'])->name('produtos.desativar');
    Route::get('/produtos/ativar/{produto}', [ProductController::class, 'ativar'])->name('produtos.ativar');
    Route::resource('/produtos', ProductController::class);

    Route::get('/montar-pizza', [MontarPizzaController::class, 'index'])->name('montar-pizza.index');
    Route::post('/montar-pizza', [MontarPizzaController::class, 'createOrUpdate'])->name('montar-pizza.salvar');
    Route::get('/montar-pizza/adicionis-json', [MontarPizzaController::class, 'jsonAdditionals'])->name('montar-pizza.adicionais-json');

    // Pizza como produto
    Route::resource('/produtos/pizza', PizzaProductController::class, ['as' => 'produtos'])
        ->parameter('pizza', 'product')
        ->except(['index', 'destroy']);

    // Produtos com adicionais
    Route::get('produtos-com-adicionais/json-produtos', [ProductsWithAdditionalController::class, 'jsonProductList'])
        ->name('produtos-com-adicionais.json-produtos');
    Route::get('produtos-com-adicionais/json-adicionais', [ProductsWithAdditionalController::class, 'jsonAdditionalList'])
        ->name('produtos-com-adicionais.json-adicionais');
    Route::get('produtos-com-adicionais/json-grupo-adicionais', [ProductsWithAdditionalController::class, 'jsonAdditionalGroupList'])
        ->name('produtos-com-adicionais.json-grupo-adicionais');
    Route::delete('produtos-com-adicionais/remover-adicionais/{product}', [ProductsWithAdditionalController::class, 'removeAdditionals'])
        ->name('produtos-com-adicionais.remover-adicionais');

    Route::resource('/produtos-com-adicionais', ProductsWithAdditionalController::class)
        ->parameter('produtos-com-adicionais', 'product')
        ->except(['edit', 'show', 'update']);

    // Modelo de entrega
    Route::resource('/tipo-de-entrega', DeliveryTypeController::class)
        ->parameter('tipo-de-entrega', 'deliveryType')
        ->except(['show']);

    // Métodos de pagamento
    Route::resource('/forma-de-pagamento', PaymentMethodController::class)
        ->parameter('forma-de-pagamento', 'paymentMethod')
        ->except(['show']);

    // CEPs de entrega
    Route::resource('/ceps-de-entrega', DeliveryZipCodeController::class)
        ->parameter('ceps-de-entrega', 'deliveryZipCode')
        ->except(['show']);

    // Entrega mesa
    Route::resource('/entrega-mesa', DeliveryTableController::class)
        ->parameter('entrega-mesa', 'deliveryTable')
        ->except(['show']);

    // Entrega mesa
    Route::resource('/produto/grupo-adicional', AdditionalGroupController::class)
        ->parameter('grupo-adicional', 'additionalGroup')
        ->except(['show']);
});

/* Admin */
Route::name('painel.admin.')->prefix('/painel/admin')->group(function () {
    Route::get('/', [DashboardAdminController::class, 'index'])->name('index');

    // Logistas
    Route::put('lojistas/atualizar-credenciais/{user}', [AdminShopkeeperController::class, 'updateCredentials'])->name('lojistas.atualizar-credenciais');
    Route::get('lojistas/ativar/{user}', [AdminShopkeeperController::class, 'activeShopkeeper'])->name('lojistas.ativar');
    Route::get('lojistas/desativar/{user}', [AdminShopkeeperController::class, 'deactivateShopkeeper'])->name('lojistas.desativar');
    Route::resource('/lojistas', AdminShopkeeperController::class)->parameter('lojistas', 'user');

    // Faturamento
    Route::get('/faturamento', [InvoicingController::class, 'index'])->name('faturamento.index');

    // Solicitações para teste
    Route::prefix('solicitacoes-para-teste')->name('solicitacoes-teste.')->group(function () {
        Route::get('/', [RequestsToTestController::class, 'index'])->name('index');
        Route::put('/marcar-lidas', [RequestsToTestController::class, 'markAllRead'])->name('marcar-lidas');
        Route::put('/marcar-lida/{testOrder}', [RequestsToTestController::class, 'markRead'])->name('marcar-lida');
        Route::delete('/deletar/{testOrder}', [RequestsToTestController::class, 'destroy'])->name('destroy');
        Route::put('/tornar-principal/{testOrder}', [RequestsToTestController::class, 'makeMainAccount'])->name('tornar-principal');
        Route::put('/expirar-conta/{testOrder}', [RequestsToTestController::class, 'addExpiredAccount'])->name('expirar-conta');
    });

    // Contatos
    Route::put('/contatos/marcar-todas-lidas', [ContactController::class, 'markAllRead'])->name('marcar-todas-lidas');
    Route::put('/contatos/marcar-lido/{contato}', [ContactController::class, 'markRead'])->name('contato.marcar-lido');
    Route::resource('/contatos', ContactController::class)->except(['update', 'show', 'create']);

    // Meus dados (Admin)
    Route::get('meus-dados/', [DataAdminController::class, 'index'])->name('meus-dados');
    Route::put('meus-dados/pessoal', [DataAdminController::class, 'updatePersonalData'])->name('meus-dados.up-dados-pessoal');
    Route::put('meus-dados/credenciais', [DataAdminController::class, 'updateCredentials'])->name('meus-dados.up-credenciais');
});
