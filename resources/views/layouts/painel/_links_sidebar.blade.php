    {{-- Links para o lojista --}}
    @hasanyrole('lojista|funcionario')
        <ul>
            <br>

            <li class="item-sidebar relative d-flex px-6">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  
                    @if (Route::is('painel.lojista.index')) text-purple-600 dark:text-purple-300 @else hover:text-gray-800 dark:hover:text-gray-200 @endif"
                    href="{{ route('painel.lojista.index') }}">
                    <span class="material-symbols-outlined">
                        home
                    </span>
                    <span class="ml-4">Dashboard</span>
                </a>
            </li>

            @can('visualizar pedidos')
                <li class="item-sidebar relative d-flex px-6">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  
                        @if (Route::is('painel.lojista.pedidos.*')) text-purple-600 dark:text-purple-300 @else hover:text-gray-800 dark:hover:text-gray-200 @endif"
                        href="{{ route('painel.lojista.pedidos.index') }}" id='link-sedebar-pedidos'>
                        <span class="material-symbols-outlined">
                            lunch_dining
                        </span>
                        <span class="ml-4">Pedidos</span>
                        @if (isset(auth()->user()->store_has_user->store_id))
                            @php
                                $store = auth()->user()->store_has_user->store;
                                $totalPedidosPendentes = $store
                                    ->orders()
                                    ->where('order_status_id', 1)
                                    ->count();
                            @endphp
                            @if ($totalPedidosPendentes > 0)
                                <span id="total-pedidos-sidebar"
                                    class="ms-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600">
                                    {{ $totalPedidosPendentes }}
                                </span>
                            @endif
                        @endif
                    </a>
                </li>
            @endcan
            @can('visualizar usuários')
                <li class="item-sidebar relative d-flex px-6">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  
                        @if (Route::is('painel.lojista.usuarios.*')) text-purple-600 dark:text-purple-300 @else hover:text-gray-800 dark:hover:text-gray-200 @endif"
                        href="{{ route('painel.lojista.usuarios.index') }}">
                        <span class="material-symbols-outlined">
                            person
                        </span>
                        <span class="ml-4">Usuários</span>
                    </a>
                </li>
            @endcan
            @can('visualizar clientes')
                <li class="item-sidebar relative d-flex px-6">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  
                        @if (Route::is('painel.lojista.clientes.*')) text-purple-600 dark:text-purple-300 @else hover:text-gray-800 dark:hover:text-gray-200 @endif"
                        href="{{ route('painel.lojista.clientes.index') }}">
                        <span class="material-symbols-outlined">
                            person
                        </span>
                        <span class="ml-4">Clientes</span>
                    </a>
                </li>
            @endcan
            @can('atualizar empresa')
                <li class="item-sidebar relative d-flex px-6">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  
                        @if (Route::is('painel.lojista.dados-da-empresa.*')) text-purple-600 dark:text-purple-300 @else hover:text-gray-800 dark:hover:text-gray-200 @endif"
                        href="{{ route('painel.lojista.dados-da-empresa.index') }}">
                        <span class="material-symbols-outlined">
                            store
                        </span>
                        <span class="ml-4">Dados da Empresa</span>
                    </a>
                </li>
            @endcan
            @can('atualizar imagens')
                <li class="item-sidebar relative d-flex px-6">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  
                        @if (Route::is('painel.lojista.imagens-da-loja*')) text-purple-600 dark:text-purple-300 @else hover:text-gray-800 dark:hover:text-gray-200 @endif"
                        href="{{ route('painel.lojista.imagens-da-loja') }}">
                        <span class="material-symbols-outlined">
                            imagesmode
                        </span>
                        <span class="ml-4">Imagens da Loja</span>
                    </a>
                </li>
            @endcan

            @can('horario atendimento')
                <li class="item-sidebar relative d-flex px-6">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  
                        @if (Route::is('painel.lojista.horario-atendimento')) text-purple-600 dark:text-purple-300 @else hover:text-gray-800 dark:hover:text-gray-200 @endif"
                        href="{{ route('painel.lojista.horario-atendimento') }}">
                        <span class="material-symbols-outlined">
                            schedule
                        </span>
                        <span class="ml-4">Horário de atendimento</span>
                    </a>
                </li>
            @endcan

            @can('visualizar categorias')
                <li class="item-sidebar relative d-flex px-6">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  
                        @if (Route::is('painel.lojista.categorias.*')) text-purple-600 dark:text-purple-300 @else hover:text-gray-800 dark:hover:text-gray-200 @endif"
                        href="{{ route('painel.lojista.categorias.index') }}">
                        <span class="material-symbols-outlined">
                            library_add
                        </span>
                        <span class="ml-4">Categorias</span>
                    </a>
                </li>
            @endcan

            @can('visualizar produtos')
                <li class="item-sidebar relative d-flex px-6">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  
                        @if (Route::is('painel.lojista.produtos.*')) text-purple-600 dark:text-purple-300 @else hover:text-gray-800 dark:hover:text-gray-200 @endif"
                        href="{{ route('painel.lojista.produtos.index') }}">
                        <span class="material-symbols-outlined">
                            inventory_2
                        </span>
                        <span class="ml-4">Produtos</span>
                    </a>
                </li>
                <li class="item-sidebar relative d-flex px-6">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  
                        @if (Route::is('painel.lojista.montar-pizza.index')) text-purple-600 dark:text-purple-300 @else hover:text-gray-800 dark:hover:text-gray-200 @endif"
                        href="{{ route('painel.lojista.montar-pizza.index') }}">
                        <span class="material-symbols-outlined">
                            local_pizza
                        </span>
                        <span class="ml-4">Montar Pizza</span>
                    </a>
                </li>

                {{-- <li class="item-sidebar relative pb-1 px-6">
                    <div class="dropdown p-0">
                        <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  
                        @if (Route::is('painel.lojista.pizzas.*')) text-purple-600 dark:text-purple-300 @else hover:text-gray-800 dark:hover:text-gray-200 @endif"
                            href="#" id="toggle-menu-pizzas" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <span class="material-symbols-outlined">
                                local_pizza
                            </span>
                            <span class="ml-4">Montar Pizza</span>
                            <span class="material-symbols-outlined ms-auto icon-menu-pizzas" id="icon-menu-pizzas">
                                expand_more
                            </span>
                        </a>
    
                        <div class="ps-3 sub-menu-pizzas @if (Route::is('painel.lojista.pizzas*')) submenu-show @endif"
                            id="sub-menu-pizzas">
                            <div class="bordder-start px-0 py-1 ms-2 pe-0">
    
                                <a class="d-block my-1 d-flex align-items-center 
                                @if (Route::is('painel.lojista.montar-pizza.*'))) active @endif"
                                    href="{{ route('painel.lojista.montar-pizza.index') }}">
                                    <span class="material-symbols-outlined fs-14px me-2">
                                        arrow_circle_right
                                    </span>
                                    Editar
                                </a>
                            </div>
                        </div>
                    </div>
                </li> --}}

                <li class="item-sidebar relative d-flex px-6">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  
                        @if (Route::is('painel.lojista.entrega-mesa.*')) text-purple-600 dark:text-purple-300 @else hover:text-gray-800 dark:hover:text-gray-200 @endif"
                        href="{{ route('painel.lojista.entrega-mesa.index') }}">
                        <span class="material-symbols-outlined">
                            room_service
                        </span>
                        <span class="ml-4">Entrega na mesa</span>
                    </a>
                </li>
            @endcan
            @can('visualizar produtos')
                <li class="item-sidebar relative d-flex px-6">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  
                        @if (Route::is('painel.lojista.grupo-adicional.*')) text-purple-600 dark:text-purple-300 @else hover:text-gray-800 dark:hover:text-gray-200 @endif"
                        href="{{ route('painel.lojista.grupo-adicional.index') }}">
                        <span class="material-symbols-outlined">
                            post_add
                        </span>
                        <span class="ml-4">Grupo de adicional</span>
                    </a>
                </li>
            @endcan
            @can('visualizar produtos')
                <li class="item-sidebar relative d-flex px-6">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  
                @if (Route::is('painel.lojista.produtos-com-adicionais.*')) text-purple-600 dark:text-purple-300 @else hover:text-gray-800 dark:hover:text-gray-200 @endif"
                        href="{{ route('painel.lojista.produtos-com-adicionais.index') }}">
                        <span class="material-symbols-outlined">
                            docs_add_on
                        </span>
                        <span class="ml-4">Inserir adicional em produto</span>
                    </a>
                </li>
            @endcan
            @can('visualizar modelo entrega')
                <li class="item-sidebar relative d-flex px-6">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  
                        @if (Route::is('painel.lojista.tipo-de-entrega.*')) text-purple-600 dark:text-purple-300 @else hover:text-gray-800 dark:hover:text-gray-200 @endif"
                        href="{{ route('painel.lojista.tipo-de-entrega.index') }}">
                        <span class="material-symbols-outlined">
                            local_shipping
                        </span>
                        <span class="ml-4">Tipo de Entrega</span>
                    </a>
                </li>
            @endcan

            <li class="item-sidebar relative d-flex px-6">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  
                        @if (Route::is('painel.lojista.ceps-de-entrega.*')) text-purple-600 dark:text-purple-300 @else hover:text-gray-800 dark:hover:text-gray-200 @endif"
                    href="{{ route('painel.lojista.ceps-de-entrega.index') }}">
                    <span class="material-symbols-outlined">
                        home_pin
                    </span>
                    <span class="ml-4">CEPs de Entrega</span>
                </a>
            </li>

            @can('visualizar forma pagamento')
                <li class="item-sidebar relative d-flex px-6">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  
                        @if (Route::is('painel.lojista.forma-de-pagamento.*')) text-purple-600 dark:text-purple-300 @else hover:text-gray-800 dark:hover:text-gray-200 @endif"
                        href="{{ route('painel.lojista.forma-de-pagamento.index') }}">
                        <span class="material-symbols-outlined">
                            payments
                        </span>
                        <span class="ml-4">Forma de Pagamento</span>
                    </a>
                </li>
            @endcan

            @can('configurações')
                <li class="item-sidebar relative d-flex px-6">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  
                        @if (Route::is('painel.lojista.configuracoes')) text-purple-600 dark:text-purple-300 @else hover:text-gray-800 dark:hover:text-gray-200 @endif"
                        href="{{ route('painel.lojista.configuracoes') }}">
                        <span class="material-symbols-outlined">
                            settings
                        </span>
                        <span class="ml-4">Configurações</span>
                    </a>
                </li>
            @endcan

        </ul>
    @endhasanyrole

    {{-- Links para admin --}}
    @role('admin')
        <ul>
            <br>

            <li class="item-sidebar relative d-flex px-6">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  
            @if (Route::is('painel.admin.index')) text-purple-600 dark:text-purple-300 @else hover:text-gray-800 dark:hover:text-gray-200 @endif"
                    href="{{ route('painel.admin.index') }}">
                    <span class="material-symbols-outlined">
                        home
                    </span>
                    <span class="ml-4">Dashboard</span>
                </a>
            </li>

            <li class="item-sidebar relative d-flex px-6">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  
            @if (Route::is('painel.admin.lojistas.*')) text-purple-600 dark:text-purple-300 @else hover:text-gray-800 dark:hover:text-gray-200 @endif"
                    href="{{ route('painel.admin.lojistas.index') }}">
                    <span class="material-symbols-outlined">
                        person
                    </span>
                    <span class="ml-4">Lojistas</span>
                </a>
            </li>

            <li class="item-sidebar relative d-flex px-6">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  
            @if (Route::is('painel.admin.faturamento.index')) text-purple-600 dark:text-purple-300 @else hover:text-gray-800 dark:hover:text-gray-200 @endif"
                    href="{{ route('painel.admin.faturamento.index') }}">
                    <span class="material-symbols-outlined">
                        payments
                    </span>
                    <span class="ml-4">Faturamento</span>
                </a>
            </li>

            <li class="item-sidebar relative d-flex px-6">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  
                @if (Route::is('painel.admin.solicitacoes-teste.index')) text-purple-600 dark:text-purple-300 @else hover:text-gray-800 dark:hover:text-gray-200 @endif"
                    href="{{ route('painel.admin.solicitacoes-teste.index') }}">
                    <span class="material-symbols-outlined">
                        record_voice_over
                    </span>
                    <span class="ml-4">Solicitações para teste</span>
                    @php
                        $totalSolicitacoesTeste = \App\Models\TestOrder::where('status', 'pendente')->count();
                    @endphp
                    @if ($totalSolicitacoesTeste)
                        <span
                            class="ms-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600">
                            {{ $totalSolicitacoesTeste }}
                        </span>
                    @endif
                </a>
            </li>
            <li class="item-sidebar relative d-flex px-6">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150  
                @if (Route::is('painel.admin.contatos.index')) text-purple-600 dark:text-purple-300 @else hover:text-gray-800 dark:hover:text-gray-200 @endif"
                    href="{{ route('painel.admin.contatos.index') }}">
                    <span class="material-symbols-outlined">
                        mail
                    </span>
                    <span class="ml-4">Contatos</span>
                    @php
                        $totalNovosContato = \App\Models\Contact::where('status', 'pendente')->count();
                    @endphp
                    @if ($totalNovosContato)
                        <span
                            class="ms-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600">
                            {{ $totalNovosContato }}
                        </span>
                    @endif
                </a>
            </li>

        </ul>
    @endrole
