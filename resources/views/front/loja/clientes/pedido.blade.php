@extends('layouts.front.loja.app', ['store' => $store])
@section('titulo', 'Pedido - ' . $store->nome)
@section('content')
    <section>

        <div class="col-12 col-lg-9 mx-auto mt-5 pt-5">

            <!-- Informações do pedido -->
            <div class="">
                <div class="">
                    <div class="w-full overflow-hidden rounded-lg pedidos px-3">

                        <!-- Detalhes do pedido -->
                        <h1 class="h5 text-gray-600 dark:text-gray-200 mb-3">Detalhes do Pedido</h1>
                        <div class="col-12 col-lg-12 mx-auto">
                            <!-- Informações do pedido -->
                            <div class="card border dark:border-none">
                                <div class="card-body dark:bg-gray-700 dark:text-gray-200">

                                    <h1 class="h3 fw-bold">
                                        Pedido nº <span class="text-success">{{ $order->codigo }}</span>
                                    </h1>

                                    <!-- Status do pedido -->
                                    <div class=" mb-2">
                                        Status do pedido:
                                        <span class="badge rounded-pills {{ $order->order_status->classe_css }}">
                                            {{ $order->order_status->nome }}
                                        </span>
                                        @if ($order->obs_status_pedido != null)
                                            <div class="p-2 small mt-2 rounded alert alert-warning">
                                                Obs: {{ $order->obs_status_pedido }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="">
                                        Status de pagamento:
                                        @if ($order->situacao_pgto == 'PENDENTE')
                                            <span class="badge rounded-pills text-bg-warning">PENDENTE</span>
                                        @else
                                            <span class="badge rounded-pills text-bg-success">PAGO</span>
                                        @endif
                                    </div>

                                    <!-- Informações do pedido -->
                                    <div class="mt-4 pt-2">
                                        <h2 class="h5 fw-bold">Informações do pedido</h2>

                                        <!-- Some borders are removed -->
                                        <ul class="list-unstyled">
                                            <li class="list-group-item mb-2 px-0 bg-transparent dark:text-gray-200 ">
                                                Cliente:
                                                <span class="fw-semibold">
                                                    {{ $order->customer->name }}
                                                </span>
                                            </li>
                                            <li class="list-group-item mb-2 px-0 bg-transparent dark:text-gray-200">Data:
                                                <span class="fw-semibold">
                                                    {{ $order->created_at->format('d/m/Y \\à\\s H:i') }}
                                                </span>
                                            </li>
                                            <li class="list-group-item mb-2 px-0 bg-transparent dark:text-gray-200">
                                                Tipo de entrega:
                                                @if (is_null($order->delivery_type_id))
                                                    <span class="text-danger">
                                                        (Removido)
                                                    </span>
                                                @else
                                                    <span class="fw-semibold">{{ $order->delivery->nome }}</span>
                                                    <span class="d-inline-block " tabindex="0" data-bs-toggle="popover"
                                                        data-bs-trigger="hover focus"
                                                        data-bs-content="{{ $order->delivery->descricao }}">
                                                        <a href="#"
                                                            class="link-primary d-flex align-items-center text-decoration-none">
                                                            <span class="visually-hidden">Informação</span>
                                                            <i class="fa-regular fa-circle-question fa-sm"></i>
                                                        </a>
                                                    </span>
                                                    @if ($order->delivery->tipo == 'Delivery' || $order->delivery->tipo == 'Correios')
                                                        <a href="#" class="  d-inline-block ms-2 text-decoration-none"
                                                            data-bs-toggle="modal" data-bs-target="#modal-endereco">
                                                            <span class="d-flex align-items-center gap-1">
                                                                <span class="">
                                                                    Endereço
                                                                </span>
                                                                <i class="fa-solid fa-arrow-up-right-from-square fa-sm"></i>
                                                            </span>
                                                        </a>
                                                    @endif

                                                    {{-- entrega na mesa --}}
                                                    @if (isset($order->delivery->tipo) && $order->delivery->tipo == 'Mesa' && is_null($order->delivery_table_id))
                                                        <span class="text-danger">Mesa: Não definido</span>
                                                    @else
                                                        @if ($order->delivery->tipo == 'Mesa')
                                                            @isset($order->delivery_table->mesa)
                                                                <span class="ms-2">
                                                                    Mesa:
                                                                    <span class="fw-semibold">
                                                                        &quot;{{ $order->delivery_table->mesa }}&quot;</span>
                                                                </span>
                                                            @endisset
                                                        @endif
                                                    @endif
                                                @endif
                                            </li>
                                            <li class="list-group-item mb-2 px-0 bg-transparent dark:text-gray-200">
                                                Forma de Pagamento:
                                                @if (is_null($order->payment_method_id))
                                                    <span class="text-danger">Não definido</span>
                                                @else
                                                    <span class="fw-semibold">
                                                        {{ $order->payment->nome }}
                                                    </span>
                                                    <span class="d-inline-block " tabindex="0" data-bs-toggle="popover"
                                                        data-bs-trigger="hover focus"
                                                        data-bs-content="{{ $order->payment->descricao }}">
                                                        <a href="#"
                                                            class="link-primary d-flex align-items-center text-decoration-none">
                                                            <span class="visually-hidden">Informação</span>
                                                            <i class="fa-regular fa-circle-question fa-sm"></i>
                                                        </a>
                                                    </span>
                                                @endif

                                                @if ($order->valor_troco > 0)
                                                    <span class="small">
                                                        &quot;troco para {{ currency_format($order->valor_troco) }}&quot;
                                                    </span>
                                                @endif
                                            </li>
                                            <li class="list-group-item mb-2 px-0 bg-transparent dark:text-gray-200">
                                                Taxa de entrega:
                                                <span class="fw-bold font-open-sans">
                                                    {{ currency_format($order->valor) }}
                                                </span>
                                            </li>
                                            <li class="list-group-item mb-2 px-0 bg-transparent dark:text-gray-200">
                                                Tempo para entrega:
                                                {!! $orderTime !!}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Pedidos -->
                            <h3 class="h5 fw-bold mt-4 pt-1 dark:text-gray-200">Pedido(s)</h3>

                            <!-- Lista de produtos -->
                            @include('front.loja.clientes._lista_produtos', compact('order'))
                            <!-- Lista de pizzas montadas -->
                            @include('front.loja.clientes._lista_pizzas_montatada', compact('order'))
                            <!-- Lista de pizzas produto -->
                            @include('front.loja.clientes._lista_pizzas_produto', compact('order'))

                            <!-- Observação do pedido -->
                            <div class="card mb-3 border dark:border-none">
                                <div class="card-body dark:bg-gray-700 dark:text-gray-200">
                                    <h3 class="fw-semibold h6">Observação sobre o pedido</h3>
                                    <p class="">
                                        {{ $order->observacao ?? '-' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Valor total a pagar -->
                            <div class="alert alert-info mb-5">
                                <div class="text-uppercase">Valor total a pagar <span class="text-lowercase">(com taxa de
                                        entrega)</span></div>
                                <div class="fs-3 fw-bold font-open-sans">
                                    <span class="fw-bold">
                                        {{ currency_format($order->total_pedido + $order->valor) }}
                                    </span>
                                </div>
                            </div>
                            <div class="py-3"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Endereço -->
    <div class="modal fade" id="modal-endereco" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="modalTitleId">Endereço</h5>
                    <button type="button" class="btn-close d-flex ps-2 pe-3 align-items-center" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Estado: {{ $order->end_entrega['estado'] }}</li>
                        <li class="list-group-item">Cidade: {{ $order->end_entrega['cidade'] }}</li>
                        <li class="list-group-item">Bairro: {{ $order->end_entrega['bairro'] }}</li>
                        <li class="list-group-item">Rua: {{ $order->end_entrega['rua'] }}</li>
                        <li class="list-group-item">Numero: {{ $order->end_entrega['numero'] }}</li>
                        <li class="list-group-item">CEP: {{ $order->end_entrega['cep'] }}</li>
                        <li class="list-group-item">Complemento: {{ $order->end_entrega['complemento'] }}</li>
                    </ul>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- Ativar popover bootstrap -->
    <script>
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
    </script>
@endsection
