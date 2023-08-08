@extends('layouts.painel.app')
@section('title', 'Home')

@section('head')

@endsection

@section('content')
    <div class="home container-fluid px-6 mx-auto grid mb-5">

        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Dashboard
        </h2>

        {{-- Alertas --}}
        <x-alerts />

        {{-- Alert tempo de expiração da conta --}}
        @php
            $daysExpires = \Carbon\Carbon::parse(auth()->user()->account_expiration)->diffInDays();
        @endphp
        @if ($daysExpires < 7)
            <div class="alert alert-warning" role="alert">
                <strong>Aviso:</strong> Sua conta expira {{ auth()->user()->time_account_expiration() }}
            </div>
        @endif

        <!-- Cards -->
        <div class="cards grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
            <!-- Card -->
            <div class="flex items-center p-3 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="mr-4 text-yellow-500 bg-yellow-100 rounded-full dark:text-yellow-100 dark:bg-yellow-500 d-flex justify-center align-items-center"
                    style="width: 50px; height: 50px">
                    <span class="material-symbols-outlined">
                        shopping_basket
                    </span>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Pedidos Pendentes
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ $totalPedidosPendentes }}
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-3 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500 d-flex justify-center align-items-center"
                    style="width: 50px; height: 50px">
                    <span class="material-symbols-outlined">
                        shopping_basket
                    </span>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Pedidos Aceitos
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ $totalPedidosAceitos }}
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-3 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500 d-flex justify-center align-items-center"
                    style="width: 50px; height: 50px">
                    <span class="material-symbols-outlined">
                        shopping_basket
                    </span>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Pedidos Entregues
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ $totalPedidosEntregues }}
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-3 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600 d-flex justify-center align-items-center"
                    style="width: 50px; height: 50px">
                    <span class="material-symbols-outlined">
                        shopping_basket
                    </span>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Pedidos Recusados
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ $totalPedidosRecusados }}
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-3 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-purple-500 bg-purple-100 rounded-full dark:text-purple-100 dark:bg-purple-500 d-flex justify-center align-items-center"
                    style="width: 50px; height: 50px">
                    <span class="material-symbols-outlined">
                        shopping_cart
                    </span>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Produtos
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ $totalProdutos }}
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-3 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500 d-flex justify-center align-items-center"
                    style="width: 50px; height: 50px">
                    <span class="material-symbols-outlined">
                        inventory_2
                    </span>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Categorias
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ $totalCategorias }}
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-3 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-indigo-500 bg-indigo-100 rounded-full dark:text-indigo-100 dark:bg-indigo-500 d-flex justify-center align-items-center"
                    style="width: 50px; height: 50px">
                    <span class="material-symbols-outlined">
                        inventory_2
                    </span>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Clientes
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ $totalClientes }}
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
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        Faturamento
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ currency_format($valorFaturamento) }}
                    </p>
                </div>
            </div>
        </div>

        <div class="row gy-3">

            <!-- Meus dados -->
            <div class="col-12 col-lg-3">
                <div class="w-full overflow-hidden rounded-lg shadow-xs bg-white dark:text-gray-200 p-3 h-100">
                    <h2 class="fs-16px fw-semibold"> Meus dados </h2>

                    <div class="text-center">
                        <img src="{{ asset('assets/img/foto-perfil.png') }}" class="w-50 mx-auto mt-3 mb-3" alt="">
                        <div class=" ">
                            {{ auth()->user()->name }}
                        </div>
                        <div class="text-muted fs-11px">
                            @if (auth()->user()->profile == 'lojista')
                                Lojista
                            @else
                                Funcionário
                            @endif
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
                            <a href="{{ route('painel.lojista.meus-dados') }}"
                                class="btn btn-sm btn-outline-primary py-1 px-2 mt-2">
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

            <!-- Pedidos pendentes -->
            <div class="col-12 col-lg-5">
                <div class="w-full overflow-hidden rounded-lg shadow-xs h-100 bg-white">
                    <h6 class="bg-white py-3 px-3 border-bottom dark:border-none text-gray-700 dark:text-gray-200">
                        Pedidos Pendentes
                    </h6>
                    <div class="w-full overflow-x-auto ">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr
                                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-3 py-2 pt-2">Cliente</th>
                                    <th class="px-3 py-2 pt-2">Tempo</sub></th>
                                    <th class="px-3 py-2 pt-2"></sub></th>

                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">

                                @if ($pedidosPendentes->count() == 0)
                                    <tr class="text-gray-700 dark:text-gray-400">
                                        <td class="px-3 py-3 text-sm  py-4" colspan="2">
                                            <div class="d-flex gap-1 align-items-center">
                                                <span class="material-symbols-outlined fs-6 ">
                                                    info
                                                </span>
                                                Nenhum registro
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                @foreach ($pedidosPendentes as $item)
                                    <tr class="text-gray-700 dark:text-gray-400">
                                        <td class="px-3 py-2">
                                            <div class="text-truncate" style="max-width: 200px">
                                                {{ $item->customer->name }}
                                            </div>
                                        </td>
                                        <td class="px-3 py-2 text-sm">
                                            <div class="d-flex gap-1 align-items-center">
                                                @php
                                                    $from = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                                                    $dateNow = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at->format('Y-m-d H:i:s'));
                                                    $diff_in_date = $dateNow->longRelativeDiffForHumans($from, 4);
                                                    
                                                    // não exibir segundos
                                                    if ($dateNow->diffInSeconds($from, 4) >= 70) {
                                                        $positionSeg = strpos($diff_in_date, 'segundos');
                                                        $diff_in_date = substr($diff_in_date, 0, $positionSeg - 4);
                                                    }
                                                    if ($dateNow->diffInDays($from, 4) >= 1) {
                                                        $diff_in_date = $dateNow->diffInDays($from, 4) . ' dias';
                                                    }
                                                    $diff_in_date = str_replace([' hora ', ' horas ', ' minutos', ' minuto', ' antes', ' segundos'], ['h ', 'h', 'min', 'min', '', 'seg'], $diff_in_date);
                                                @endphp
                                                há {{ $diff_in_date }}
                                            </div>
                                        </td>
                                        <td class="px-3 py-2 text-sm">
                                            <a type="button" href="{{ route('painel.lojista.pedidos.show', $item->id) }}"
                                                class="btn btn-light border-0 dark:text-gray-200 py-0 px-1 pt-1"
                                                title="Visualizar">
                                                <span class="material-symbols-outlined text-primary">
                                                    visibility
                                                </span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <!-- Vendas em 7 dias  -->
            <div class="col-12 col-lg-4">
                <div class="w-full overflow-hidden rounded-lg shadow-xs bg-white dark:text-gray-200 p-3 h-100">
                    <div class="overflow-x-auto" id="mobile-width-chart-vendas">
                        <div class="">
                            {!! $chartVendas->container() !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vendas no último mês  -->
            <div class="col-12 col-lg-12">
                <div class="w-full overflow-hidden rounded-lg shadow-xs bg-white dark:text-gray-200 p-3 h-100">
                    <div class="responsive-chart" id="mobile-width-chart-vendas-ultimo-mes">
                        <div class="" style="min-width: 600px">
                            {!! $chartVendasMes->container() !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Vendas no últimos 12 meses  -->
            <div class="col-12 col-lg-12 " style="">
                <div class="w-full overflow-hidden rounded-lg shadow-xs bg-white dark:text-gray-200 p-3 h-100">
                    <!-- vendas 12 meses -->
                    <div class=" " id="mobile-width-chart-vendas-12">
                        <div class="responsive-chart">
                            <div style="min-width: 600px;">
                                {!! $chartVendas12meses->container() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection


@section('scripts')
    <!-- Charts -->
    <!-- CDN LaraPex -->
    <script src="{{ $chartVendas->cdn() }}"></script>
    <!-- Scripts Chart LaraPex -->
    {{ $chartVendas->script() }}
    {{ $chartVendasMes->script() }}
    {{ $chartVendas12meses->script() }}

    <script>
        // Add responsividade para charts
    </script>
@endsection
