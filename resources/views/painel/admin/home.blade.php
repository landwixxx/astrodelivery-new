@extends('layouts.painel.app')
@section('title', 'Home')
@section('content')
    <div class="home container-fluid px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Dashboard
        </h2>

        <!-- Cards -->
        <div class="cards grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
            <!-- Card -->
            <div class="flex items-center p-3 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500 d-flex justify-center align-items-center"
                    style="width: 50px; height: 50px">
                    <span class="material-symbols-outlined">
                        person
                    </span>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Lojistas
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ $totalLojistas }}
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-3 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500 d-flex justify-center align-items-center"
                    style="width: 50px; height: 50px">
                    <span class="material-symbols-outlined">
                        group
                    </span>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Clientes
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ $totalCliente }}
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-3 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500 d-flex justify-center align-items-center"
                    style="width: 50px; height: 50px">
                    <span class="material-symbols-outlined">
                        shopping_cart
                    </span>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400 d-flex align-items-center gap-1">
                        Produtos
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ $totalProdutos }}
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-3 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500 d-flex justify-center align-items-center"
                    style="width: 50px; height: 50px">
                    <span class="material-symbols-outlined">
                        payments
                    </span>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400 d-flex align-items-center gap-1">
                        Vendas
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ $totalVendas }}
                    </p>
                </div>
            </div>
        </div>

        <div class="row gy-3">

            <div class="col-12 col-lg-3 ">
                <div class="w-full overflow-hidden rounded-lg shadow-xs bg-white dark:text-gray-200 p-3 h-100">
                    <h2 class="fs-16px fw-semibold"> Meus dados </h2>

                    <div class="text-center">
                        <img src="{{ asset('assets/img/foto-perfil.png') }}" class="w-50 mx-auto mt-3 mb-3" alt="">
                        <div class=" ">
                            {{ auth()->user()->name }}
                        </div>
                        <div class="text-muted fs-11px">
                            Administrador
                        </div>
                        <div class="small mt-3 dark:text-gray-400 text-truncate">
                            <div class=" d-flex align-items-center gap-2 justify-content-center">
                                <span class="material-symbols-outlined fs-18px">
                                    call
                                </span> {{ auth()->user()->phone }}
                            </div>
                            <div class="mt-1 d-flex align-items-center gap-2 justify-content-center ">
                                <span class="material-symbols-outlined fs-18px">
                                    mail
                                </span>
                                {{ auth()->user()->email }}
                            </div>
                        </div>
                        <div class="mt-2">
                            <a href="{{ route('painel.admin.meus-dados') }}"
                                class="btn btn-sm btn-outline-success py-1 px-2 mt-2">
                                <div class="d-flex  align-items-center">
                                    <span class="material-symbols-outlined fs-17px">
                                        edit_note
                                    </span>
                                    Editar
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Lojistas -->
            <div class="col-12 col-lg-5">
                <div class="w-full overflow-hidden rounded-lg shadow-xs h-100 bg-white ">
                    <!-- Lojistas -->
                    <div class="">
                        <div class="text-gray-700 dark:text-gray-200 fw-semibold small px-3 py-3 pb-3 bg-white">
                            <div class="d-flex justify-content-between align-items-center ">
                                <h2 class="fs-16px"> Lojistas </h2>
                                <a href="{{ route('painel.admin.lojistas.index') }}"
                                    class="btn btn-outline-dark btn-sm small dark:text-gray-400 px-2 py-1 fs-11">
                                    Ver todos
                                </a>
                            </div>
                        </div>
                        <div class="w-full overflow-x-auto responsive-chart ms-2 ms-md-0">
                            <table class="w-full whitespace-no-wrap">
                                <thead>
                                    <tr
                                        class="dark:header-table border-top text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                        <th class="px-3 py-2 small">Nome</th>
                                        <th class="px-3 py-2 small">Loja</th>
                                        <th class="px-3 py-2 small">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">

                                    @if ($listaLojistas->count() == 0)
                                        <tr class="text-gray-700 dark:text-gray-400">
                                            <td class="px-3 py-3 text-sm text-center py-5" colspan="3">
                                                <div class="d-flex gap-1 align-items-center justify-content-center">
                                                    <span class="material-symbols-outlined fs-6 ">
                                                        info
                                                    </span>
                                                    Nenhum registro
                                                </div>
                                            </td>
                                        </tr>
                                    @endif

                                    @foreach ($listaLojistas as $lojista)
                                        <tr class="text-gray-700 dark:text-gray-400">
                                            <td class="px-3 py-3 text-sm">
                                                {{ $lojista->name }}
                                            </td>
                                            <td class="px-3 py-3 text-sm">
                                                {{ !is_null($lojista->store) ? $lojista->store->nome : '--' }}
                                            </td>

                                            <td class=" px-3 py-3 text-sm">
                                                @if ($lojista->status == 'ativo')
                                                    <span class="badge rounded-pill text-bg-success">Ativo</span>
                                                @else
                                                    <span class="badge rounded-pill text-bg-danger">Desativado</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Vendas em 7 dias  -->
            <div class="col-12 col-lg-4">
                <div class="w-full overflow-hidden rounded-lg shadow-xs bg-white dark:text-gray-200 p-3 h-100">
                    <div class="">
                        {!! $chartVendas->container() !!}
                    </div>
                </div>
            </div>

            <!-- Vendas no último mês  -->
            <div class="col-12 col-lg-12 ">
                <div class="w-full overflow-hidden rounded-lg shadow-xs bg-white dark:text-gray-200 p-3 h-100">
                    <div class="responsive-chart" id="mobile-width-chart-vendas-mes">
                        <div class="" style="min-width: 700px">
                            {!! $chartVendasMes->container() !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pedidos no último mês  -->
            <div class="col-12 col-lg-12 ">
                <div class="w-full overflow-hidden rounded-lg shadow-xs bg-white dark:text-gray-200 p-3 h-100">
                    <!-- Pedidos mês -->
                    <div class="responsive-chart" id="mobile-width-chart-pedidos-mes">
                        <div class="" style="min-width: 700px">
                            {!! $chartPedidosMes->container() !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usuários  -->
            <div class="col-12 col-lg-3">
                <div class="w-full overflow-hidden rounded-lg shadow-xs bg-white dark:text-gray-200 p-3 h-100">
                    <div class="">
                        {!! $chartUsuarios->container() !!}
                    </div>
                </div>
            </div>
            <!-- Clientes 12 meses  -->
            <div class="col-12 col-lg-9">
                <div class="w-fdull overflow-hidden rounded-lg shadow-xs bg-white dark:text-gray-200 p-3 h-100">
                    <div class="responsive-chart" id="mobile-width-chart-cliente-12">
                        <div class="" style="min-width: 600px">
                            {!! $chartCliente12meses->container() !!}
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <div class="py-5"></div>
@endsection
@section('scripts')
    <script>
        /* Ativar popovers bootstrap */
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

        // Add responsividade para charts
        if (window.innerWidth <= 500) {
            let width = window.innerWidth - 85 + 'px'
            document.getElementById('mobile-width-chart-cliente-12').style.width = width
            document.getElementById('mobile-width-chart-pedidos-mes').style.width = width
            document.getElementById('mobile-width-chart-vendas-mes').style.width = width
        }
    </script>

    <!-- Charts -->
    <!-- CDN LaraPex -->
    <script src="{{ $chartVendas->cdn() }}"></script>
    <!-- Scripts Chart LaraPex -->
    {{ $chartVendas->script() }}
    {{ $chartVendasMes->script() }}
    {{ $chartUsuarios->script() }}
    {{ $chartPedidosMes->script() }}
    {{ $chartCliente12meses->script() }}
@endsection
