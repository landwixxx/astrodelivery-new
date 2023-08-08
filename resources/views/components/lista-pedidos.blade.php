@php
    $qtd_itens = 0;
    $soma_pedido = 0;
    $items_cart = [];
    if (session('items_cart')) {
        $items_cart = session('items_cart');
        $qtd_itens = $qtd_itens + count($items_cart);
        $soma_pedido_cart = array_column($items_cart, 'vl_item');
        $soma_pedido_cart = array_sum($soma_pedido_cart);
        $soma_pedido = $soma_pedido_cart;
    }
    
    if (session('items_cart_pizza')) {
        $qtd_itens = $qtd_itens + count(session('items_cart_pizza'));
    }
    if (session('items_cart_pizza_produto')) {
        $qtd_itens = $qtd_itens + count(session('items_cart_pizza_produto'));
    }
@endphp
@if (session('items_cart') || session('items_cart_pizza') || session('items_cart_pizza_produto'))
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="pedidos-escolhidos"
        aria-labelledby="Enable both scrolling & backdrop">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title small fw-normal" id="Enable both scrolling & backdrop">Lista de Itens</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <!-- Lista de produtos -->
            <div class="position-relative">
                <ul class="list-group list-group-flush">
                    @foreach ($items_cart as $item)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div class="fw-500 fs-5">{{ $item['qtd_item'] }} x {{ $item['product_nome'] }}
                                    <p></p>
                                </div>
                                <div class="fw-bold d-flex align-items-baseline gap-1">R$ <span
                                        class="fs-5">{{ number_format($item['vl_item'], 2, ',', '.') }}</span></div>
                            </div>
                        </li>
                    @endforeach
                    {{-- montar pizza --}}
                    @foreach (session('items_cart_pizza') ?? [] as $item)
                        @php
                            $soma_pedido = $soma_pedido + $item['valor_total'];
                        @endphp
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div class="fw-500 fs-5">
                                    1 x Pizza
                                    <p></p>
                                </div>
                                <div class="fw-bold d-flex align-items-baseline gap-1">R$
                                    <span class="fs-5">
                                        {{ number_format($item['valor_total'], 2, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                    {{-- Produto pizza --}}
                    @foreach (session('items_cart_pizza_produto') ?? [] as $item)
                        @php
                            $soma_pedido = $soma_pedido + $item['valor_total'];
                        @endphp
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div class="fw-500 fs-5">
                                    1 x {{$item['nome']}}
                                    <p></p>
                                </div>
                                <div class="fw-bold d-flex align-items-baseline gap-1">R$
                                    <span class="fs-5">
                                        {{ number_format($item['valor_total'], 2, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                    <li class="list-group-item sticky-bottom">
                        <div class="d-flex justify-content-between mt-4 align-items-center">
                            <div class="fw-500 lh-sm">
                                <div class=" fs-6 tdext-muted">Total do Pedido</div>
                            </div>
                            <div class="">
                                <div class="fw-bold">R$ <span
                                        class="fs-4">{{ number_format($soma_pedido, 2, ',', '.') }}</span></div>
                            </div>
                        </div>
                        <div class="">
                            <a href="{{ route('cliente.resumo-pedido', $store->slug_url) }}"
                                class="btn btn-danger w-100 small fw-500">
                                Continuar
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- btn abrir offcanvas de pedidos -->
    <button class="btn btn-danger btn-pedidos-escolhidos lh-1 p-2 shadow" type="button" data-bs-toggle="offcanvas"
        data-bs-target="#pedidos-escolhidos" aria-controls="pedidos-escolhidos">
        <div class="d-flex align-items-center gap-2 text-start pt-2 pb-1">
            <div class=""><i class="fa-solid fa-bag-shopping fa-lg"></i></div>
            <div class="">
                <div class="small">{{ $qtd_itens }} Itens</div>
                <div class="font-open-sans">R$ <span
                        class="fs-4 fw-bold">{{ number_format($soma_pedido, 2, ',', '.') }}</span></div>
            </div>
        </div>
    </button>
@endif
