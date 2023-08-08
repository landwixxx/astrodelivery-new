@extends('layouts.painel.app')
@section('title', 'Detalhes do Pedido')
@section('content')
    <br>
    {{-- Alertas --}}
    <x-alerts />

    <div class="container-fluid px-6 mx-auto grid">
        <br>

        <div class="w-full overflow-hidden rounded-lg pedidos ">

            <!-- Detalhes do pedido -->
            <h1 class="h4  text-gray-600 dark:text-gray-200 mb-3">Detalhes do Pedido</h1>
            <div class="col-12 col-lg-12 mx-auto">
                <!-- Informações do pedido -->
                <div class="card border dark:border-none overflow-hidden">
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
                            <ul class="list-group list-group-flush list-endereco">
                                <li class="list-group-item px-0 bg-transparent dark:text-gray-200 ">Cliente:
                                    <span class="fw-semibold">
                                        {{ is_null($order->user_id) ? '(Cliente removido)' : $order->customer->name }}
                                    </span>
                                </li>
                                <li class="list-group-item px-0 bg-transparent dark:text-gray-200">Data:
                                    <span class="fw-semibold">
                                        {{ $order->created_at->format('d/m/Y \\à\\s H:i') }}
                                    </span>
                                </li>
                                <li class="list-group-item px-0 bg-transparent dark:text-gray-200">
                                    Tipo de entrega:
                                    {{-- Se o tipo de entrega foi removido --}}
                                    @if (is_null($order->delivery_type_id))
                                        <span class="text-danger">
                                            (Removido)
                                        </span>
                                    @else
                                        <span class="fw-semibold">{{ $order->delivery->nome }}</span>
                                        <span class="d-inline-block " tabindex="0" data-bs-toggle="popover"
                                            data-bs-trigger="hover focus"
                                            data-bs-content="{{ $order->delivery->descricao }}">
                                            <a href="#" class="link-primary d-flex align-items-center">
                                                <span class="visually-hidden">Informação</span>
                                                <span class="material-symbols-outlined fs-16px">
                                                    help
                                                </span>
                                            </a>
                                        </span>
                                        @if ($order->delivery->tipo == 'Delivery' || $order->delivery->tipo == 'Correios')
                                            <a href="#" class="  d-inline-block ms-2 " data-bs-toggle="modal"
                                                data-bs-target="#modal-endereco">
                                                <span class="d-flex align-items-center gap-1">
                                                    <span class="text-decoration-underline">
                                                        Endereço
                                                    </span>
                                                    <span class="material-symbols-outlined fs-16px">
                                                        google_plus_reshare
                                                    </span>
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


                                <li class="list-group-item px-0 bg-transparent dark:text-gray-200">
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
                                            <a href="#" class="link-primary d-flex align-items-center">
                                                <span class="visually-hidden">Informação</span>
                                                <span class="material-symbols-outlined fs-16px">
                                                    help
                                                </span>
                                            </a>
                                        </span>
                                    @endif

                                    @if ($order->valor_troco > 0)
                                        <span class="small">
                                            &quot;troco para {{ currency_format($order->valor_troco) }}&quot;
                                        </span>
                                    @endif
                                </li>
                                <li class="list-group-item px-0 bg-transparent dark:text-gray-200">
                                    Taxa de entrega:
                                    <span class="fw-bold font-open-sans">
                                        {{ currency_format($order->valor) }}
                                    </span>
                                </li>
                                <li class="list-group-item px-0 bg-transparent dark:text-gray-200">
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
                @include('painel.lojista.pedidos._lista_produtos', compact('order'))
                <!-- Lista de pizzas montadas -->
                @include('painel.lojista.pedidos._lista_pizzas_montatada', compact('order'))
                <!-- Lista de produtos pizza -->
                @include('painel.lojista.pedidos._lista_pizzas_produto', compact('order'))

                <!-- Observação do pedido -->
                <div class="card mb-3 border dark:border-none overflow-hidden">
                    <div class="card-body dark:bg-gray-700 dark:text-gray-200">
                        <h3 class="fw-semibold h6">Observação sobre o pedido</h3>
                        <p class="">
                            {{ $order->observacao ?? '-' }}
                        </p>
                    </div>
                </div>

                <!-- Valor total a pagar -->
                <div class="alert alert-info">
                    <div class="text-uppercase">Valor total a pagar <span class="text-lowercase">(com taxa de
                            entrega)</span></div>
                    <div class="fs-3 fw-bold font-open-sans">
                        <span class="fw-bold">
                            {{ currency_format($order->total_pedido + $order->valor) }}
                        </span>
                    </div>
                </div>

                <!-- ========== Início Ações ========== -->
                <div class="pt-4">
                    <div class="card dark:border-none dark:text-gray-200">

                        <form action="#" method="post" id="form-alt-status">
                            @csrf
                            @method('PUT')

                            @if ($order->order_status_id == 1)
                                <div class="card-body py-4 dark:bg-gray-700 dark:text-gray-200">
                                    <button class="btn btn-success bg-success border-0 dark:text-gray-200  p-2 me-2 mb-2"
                                        type="button" data-modal-toggle="popup-modal-aprovar" title="Aprovar">
                                        <span class="d-flex gap-2 align-items-center">
                                            <span class="material-symbols-outlined">
                                                done
                                            </span> Aceitar Pedido
                                        </span>
                                    </button>
                                    <button class="btn btn-danger bg-danger border-0 dark:text-gray-200  p-2 me-2 mb-2 "
                                        type="button" data-modal-toggle="popup-modal-negar" title="Negar">
                                        <span class="d-flex gap-2 align-items-center">
                                            <span class="material-symbols-outlined">
                                                close
                                            </span>
                                            Cancelar Pedido
                                        </span>
                                    </button>
                                </div>
                            @endif

                            @if ($order->order_status_id != 1)
                                <!-- Adicionar observação sobre o status -->
                                <div class="bg-white p-3 bp-0">
                                    <label class="" for="obs-pe">
                                        Observação
                                    </label>
                                    <input type="text" id="obs-pe" name="obs_status_pedido"
                                        value="{{ $order->obs_status_pedido }}"
                                        class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        placeholder="">
                                </div>

                                <div class="card-body py-4 pt-2 dark:bg-gray-700 dark:text-gray-200">
                                    <h3 class="fw-semibold mb-3 h6 text-uppercase">
                                        Status do pedido
                                    </h3>
                                    <!-- aceito -->
                                    <button type="button"
                                        onclick="setUrlStatus(`{{ route('painel.lojista.pedidos.aceitar', $order->id) }}`)"
                                        class="btn btn-outline-primary border-1 dark:text-gray-200  p-2 me-2 mb-3 shadow-sm @if ($order->order_status_id == 2) bg-primary text-white @endif"
                                        type="button" title="Aprovar">
                                        <span class="d-flex gap-2 align-items-center">
                                            <span class="material-symbols-outlined"> done </span>
                                            ACEITO
                                        </span>
                                    </button>
                                    <!-- EM PRODUÇÃO -->
                                    <button type="button"
                                        onclick="setUrlStatus(`{{ route('painel.lojista.pedidos.em-producao', $order->id) }}`)"
                                        class="btn btn-outline-warning border-1 dark:text-gray-200  p-2 me-2 mb-3 shadow-sm @if ($order->order_status_id == 3) bg-warning text-dark @endif"
                                        type="button" title="Aprovar">
                                        <span class="d-flex gap-2 align-items-center">
                                            <span class="material-symbols-outlined"> done </span>
                                            EM PRODUÇÃO
                                        </span>
                                    </button>

                                    <!-- EM ROTA DE ENTREGA -->
                                    <button type="button"
                                        onclick="setUrlStatus(`{{ route('painel.lojista.pedidos.em-rota-entrega', $order->id) }}`)"
                                        class="btn btn-outline-secondary border-1 dark:text-gray-200  p-2 me-2 mb-3 shadow-sm @if ($order->order_status_id == 4) bg-secondary text-white @endif"
                                        type="button" title="Aprovar">
                                        <span class="d-flex gap-2 align-items-center">
                                            <span class="material-symbols-outlined"> done </span>
                                            EM ROTA DE ENTREGA
                                        </span>
                                    </button>
                                    <!-- ENTREGUE -->
                                    <button type="button"
                                        onclick="setUrlStatus(`{{ route('painel.lojista.pedidos.entregue', $order->id) }}`)"
                                        class="btn btn-outline-info border-1 dark:text-gray-200  p-2 me-2 mb-3 shadow-sm @if ($order->order_status_id == 5) bg-info text-dark text-dark @endif"
                                        type="button" title="Aprovar">
                                        <span class="d-flex gap-2 align-items-center">
                                            <span class="material-symbols-outlined"> done </span>
                                            ENTREGUE
                                        </span>
                                    </button>
                                    <!-- FINALIZADO -->
                                    <button type="button"
                                        onclick="setUrlStatus(`{{ route('painel.lojista.pedidos.finalizado', $order->id) }}`)"
                                        class="btn btn-outline-success border-1 dark:text-gray-200  p-2 me-2 mb-3 shadow-sm @if ($order->order_status_id == 7) bg-success text-white @endif"
                                        type="button" title="Aprovar">
                                        <span class="d-flex gap-2 align-items-center">
                                            <span class="material-symbols-outlined"> done </span>
                                            FINALIZADO
                                        </span>
                                    </button>

                                    @can('negar pedidos')
                                        <!-- Cancelar -->
                                        <button type="button"
                                            onclick="setUrlStatus(`{{ route('painel.lojista.pedidos.cancelar', $order->id) }}`)"
                                            class="btn btn-outline-danger border-1 dark:text-gray-200  p-2 me-2 mb-3 shadow-sm @if ($order->order_status_id == 6) bg-danger text-white @endif "
                                            type="button" title="Negar">
                                            <span class="d-flex gap-2 align-items-center">
                                                <span class="material-symbols-outlined">
                                                    close
                                                </span>
                                                Cancelar Pedido
                                            </span>
                                        </button>
                                    @endcan
                                </div>
                            @endif

                        </form>
                    </div>
                </div>

                <!-- ========== Fim Ações ========== -->
            </div>
        </div>
    </div>

    <!-- Modal cancelar -->
    <div id="popup-modal-negar" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 p-4 md:inset-0 h-modal md:h-full">
        <div class="relative w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                    data-modal-toggle="popup-modal-negar">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <span class="material-symbols-outlined display-3 text-gray-500 dark:text-gray-400"">
                        info
                    </span>

                    <h3 class="mb-4 text-lg font-normal text-gray-500 dark:text-gray-400 mt-3">
                        Tem certeza que deseja cancelar este pedido?
                    </h3>

                    <div class="pb-2">
                        <button type="button" class="btn btn-link dark:text-gray-400 text-decoration-underline"
                            onclick="document.getElementById('can-link-obs').classList.toggle('d-none')">
                            Adicione uma observação
                        </button>
                    </div>

                    <form action="{{ route('painel.lojista.pedidos.cancelar', $order->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <label class="d-none  col-12 mb-3 pb-2 text-start" id="can-link-obs">
                            <span class="text-gray-700 dark:text-gray-200 d-block mb-1 small">Observação</span>
                            <input type="text" id="obs_status_pedido" name="obs_status_pedido" value=""
                                class="form-control w-full pl-3  pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                placeholder="">
                        </label>

                        <button type="submit"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Sim
                        </button>
                        <button data-modal-toggle="popup-modal-aprovar" type="button"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            Cancelar
                        </button>
                    </form>


                    {{-- <a href="{{ route('painel.lojista.pedidos.cancelar', $order->id) }}" type="button"
                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                        Sim
                    </a>
                    <button data-modal-toggle="popup-modal-negar" type="button"
                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        Cancelar
                    </button> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal aprovar -->
    <div id="popup-modal-aprovar" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 p-4 md:inset-0 h-modal md:h-full">
        <div class="relative w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                    data-modal-toggle="popup-modal-aprovar">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <span class="material-symbols-outlined display-3 text-gray-500 dark:text-gray-400"">
                        check_circle
                    </span>
                    <h3 class="mb-4 mt-3 text-lg font-normal text-gray-500 dark:text-gray-400">
                        Tem certeza que deseja aceitar este pedido?
                    </h3>

                    <div class="pb-2">
                        <button type="button" class="btn btn-link dark:text-gray-400 text-decoration-underline"
                            onclick="document.getElementById('ac-link-obs').classList.toggle('d-none')">
                            Adicione uma observação
                        </button>
                    </div>

                    <form action="{{ route('painel.lojista.pedidos.aceitar', $order->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <label class="d-none  col-12 mb-3 pb-2 text-start" id="ac-link-obs">
                            <span class="text-gray-700 dark:text-gray-200 d-block mb-1 small">Observação</span>
                            <input type="text" id="obs_status_pedido" name="obs_status_pedido" value=""
                                class="form-control w-full pl-3  pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                placeholder="">
                        </label>

                        <button type="submit"
                            class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Sim
                        </button>
                        <button data-modal-toggle="popup-modal-aprovar" type="button"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            Cancelar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="py-4 mb-5 mt-4"></div>

    <!-- Modal Endereço -->
    <div class="modal fade" id="modal-endereco" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="modalTitleId">Endereço</h5>
                    <button type="button" class="btn-close d-flex ps-2 pe-3 align-items-center" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="material-symbols-outlined">
                            close
                        </span>
                    </button>
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
    <script>
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

        // add url no form para alterar o status do pedido
        function setUrlStatus(url) {
            document.getElementById('form-alt-status').action = url
            document.getElementById('form-alt-status').submit()
        }
    </script>
@endsection
