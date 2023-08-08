@extends('layouts.front.loja.appLoja', ['store' => $store])
@section('titulo', 'Resumo do Pedido - ' . $store->nome)
@section('content')

    <section>
        <div class="resumo-pedidos container ">


            <div class="row">
                <div class="col-12 col-lg-8 mx-auto">

                    @if (session('error'))
                        <!-- Alerta de erro se a quantidade em estoque do pedido não confere com a quantidad de produto ou adicional -->
                        <div class="alert alert-danger mb-3 alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>{!! session('error') !!}</strong>
                            <br>
                            Remova o item e adicione novamente no carrinho com a quantidade atualizada.
                        </div>
                    @endif
                    @if (session('nao_disponivel'))
                        <!--  alert de item não disponível -->
                        <div class="alert alert-danger mb-3 alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>{!! session('nao_disponivel') !!}</strong>
                            <br>
                            Revise seu pedido
                        </div>
                    @endif

                    {{-- Alerte de sucesso --}}
                    <x-alert-success />
                    {{-- Alerte de info --}}
                    <x-alert-info />

                    <h1 class="h4 fw-bold">Resumo do Pedido</h1>
                    <!-- Início Pedidos -->
                    @if (empty($session['itens']) &&
                            count(session('items_cart_pizza') ?? []) == 0 &&
                            count(session('items_cart_pizza_produto') ?? []) == 0)
                        <div class="fs-5 text-center" style="">
                            <div class="alert alert-warning" role="alert">
                                Nenhum pedido selecionado
                            </div>
                        </div>
                    @endif
                    {{-- Resumo Produto --}}
                    @foreach ($session['itens'] as $keyItem => $item)
                        @if (true)
                            @php
                                $valor_item_produto = $item['vl_item'];
                                $item_product_id = $item['product_id'];
                            @endphp
                            <!-- ========== Início Produto ========== -->
                            <div class="card border mb-4">
                                <div class="card-body p-4">
                                    <!-- Pedido -->
                                    <div class="d-flex gap-3 flex-column flex-lg-row">
                                        <!-- Pedido -->
                                        <div class="d-flex gap-3">
                                            <!-- Imagem -->
                                            <div class="" style="max-width: 150px">
                                                @php
                                                    $imgProduct = \App\Models\Product::find($item['product_id'])->img_destaque;
                                                @endphp
                                                <img src="{{ $imgProduct }}" alt=""
                                                    class="w-100 img-produto-resumo">
                                            </div>
                                            <div class="">

                                                <!-- Nome -->
                                                <h3 class="h5">{{ $item['qtd_item'] }}x {{ $item['product_nome'] }}
                                                </h3>
                                                <p class="text-muted mb-2">
                                                    {{ Str::limit($item['product_descricao'], 250) }}
                                                </p>
                                                <div class="text-danger fs-5 fw-bold font-open-sans">R$
                                                    {{ currency($item['product_preco']) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    @if (isset($item['additionals']))
                                        <hr class="mt-4">
                                        <!-- Adicionais -->
                                        <div class="mt-3">
                                            <h3 class="h6 small fw-bold text-uppercase text-muted">Adicionais</h3>
                                            <div class="row">
                                                <!-- item -->
                                                @foreach ($item['additionals'] as $item)
                                                    {{-- @foreach ([] as $item) --}}
                                                    @php
                                                        // dd($item);
                                                    @endphp
                                                    <div class="col-12 col-lg-6">
                                                        <div class="d-flex gap-2 mt-2 mb-3">
                                                            <div class="">
                                                                @php
                                                                    $imgAdditional = \App\Models\Product::find($item['additional_id'])->img_destaque;
                                                                @endphp
                                                                <img src="{{ $imgAdditional }}" alt=""
                                                                    class="img-adicional-resumo" style="">
                                                            </div>
                                                            <div class="">
                                                                <!-- Nome -->
                                                                <h3 class="h6">
                                                                    {{ $item['qtd_item'] }}x
                                                                    {{ $item['additional_nome'] }}
                                                                </h3>
                                                                <p class="mb-0 pb-1 small">
                                                                    {{ Str::limit($item['additional_descricao'], 90) }}
                                                                </p>
                                                                <div class="text-danger fw-bold font-open-sans">
                                                                    {{ currency_format($item['additional_preco']) }}
                                                                    <!-- <button type="button" class="btn btn-outline-primary btn-sm fs-12px py-0 px-1" style="margin-left: 0.7rem;">Editar</button>
                                                                                                                                                                                                                    <button type="button" class="btn btn-outline-danger btn-sm fs-12px py-0 px-1">Remover</button> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    @if (isset($item['product_observacao']))
                                        <div class="mt-3">
                                            <h3 class="h6 small fw-bold text-uppercase text-muted">Observação</h3>
                                            <div class="row">
                                                <div class="col-12 col-lg-4">
                                                    <div class="d-flex gap-2 mt-2 mb-3">
                                                        <div class="">
                                                            <!-- Nome -->
                                                            <h3 class="h6">{{ $item['product_observacao'] }}</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="card-footer  fw-bold  lh-1 font-open-sans d-flex justify-content-between">
                                    <div class="">
                                        <div class="text-muted small fw-semibold">Subtotal</div>
                                        R$ <span class="fs-4">{{ currency($valor_item_produto) }}</span>
                                    </div>

                                    <div class="">
                                        <button type="button" class="btn btn-outline-danger btn-sm " data-bs-toggle="modal"
                                            data-bs-target="#modal-remover-item"
                                            onclick="document.getElementById('link-remover-item').href='{{ route('cliente.resumo-pedido.remover-item', ['slug_store' => $store->slug_url, $keyItem]) }}';">
                                            Remover
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- ========== Fim Produto ========== -->
                        @endif
                    @endforeach

                    <!-- Resumo Pizza -->
                    @include('front.loja.realizar_pedido._resumo_pizza', ['store' => $store])
                    <!-- Resumo Pizza Produto -->
                    @include('front.loja.realizar_pedido._resumo_pizza_produto', ['store' => $store])

                    <!-- Total pedido -->
                    <div class="card-footer  fw-bold text-end lh-1 font-open-sans">


                        @php
                            $vTotal = $session['soma_pedido'];
                            $itensCartPizza = session('items_cart_pizza') ?? [];
                            foreach ($itensCartPizza as $item) {
                                $vTotal = $vTotal + $item['valor_total'];
                            }
                            $itensCartPizza = session('items_cart_pizza_produto') ?? [];
                            foreach ($itensCartPizza as $item) {
                                $vTotal = $vTotal + $item['valor_total'];
                            }
                        @endphp
                        <div class="text-muted small fw-semibold">Total Pedido</div>
                        R$ <span class="fs-2">{{ currency($vTotal) }}</span>
                    </div>

                    <div class="my-3 text-center d-flex justify-content-between gap-3 flex-column flex-lg-row">
                        <a href="{{ route('loja.index', $store->slug_url) }}"
                            class="btn btn-outline-danger px-4 fw-semibold @if (count($session['itens']) == 0 &&
                                    count(session('items_cart_pizza') ?? []) == 0 &&
                                    count(session('items_cart_pizza_produto') ?? []) == 0) disabled @endif">
                            <i class="fa-solid fa-arrow-left fa-sm me-1"></i>
                            Continuar Comprando
                        </a>
                        <a href="{{ route('cliente.formas-entrega-e-pagamento', $store->slug_url) }}"
                            class="btn btn-danger px-5 fw-semibold @if (count($session['itens']) == 0 &&
                                    count(session('items_cart_pizza') ?? []) == 0 &&
                                    count(session('items_cart_pizza_produto') ?? []) == 0) disabled @endif">
                            Finalizar
                            <i class="fa-solid fa-arrow-right fa-sm ms-1"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Modal remover item -->
    <div class="modal fade" id="modal-remover-item" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-ssm" role="document">
            <div class="modal-content">
                <div class="d-flex justify-content-end p-2">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center fs-4">
                    Tem certeza em remover o item?
                </div>
                <div class="modal-footer justify-content-center pb-5">
                    <a href="#" class="btn btn-primary px-3" id="link-remover-item">Remover</a>
                    <button type="button" class="btn btn-outline-danger px-3" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <!-- Modal loja fechada -->
    <x-loja.loja_fechada :store="$store" />

    <!-- scripts loja -->
    <script src="{{ asset('assets/js/loja.js') }}"></script>
@endsection
