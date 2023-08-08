@php
    $itens_pizza = session('items_cart_pizza_produto') ?? [];
@endphp
@foreach ($itens_pizza as $keyItem => $item)
    @if (true)
        <!-- ========== Início Pizza ========== -->
        <div class="card border mb-4">
            <div class="card-body p-4">
                <div class=" gap-3 flex-column flex-lg-row">
                    <!-- Pedido -->
                    <div class=" gap-3">
                        <div class="">
                            <h3 class="h4">1x {{ $item['nome'] }}</h3>

                            <!-- sabores -->
                            <div class="small fw-bold mt-3 text-uppercase pt-2 ">Sabores</div>
                            <div class="row">

                                @foreach ($item['sabores'] as $sabor)
                                    <div class="col-12 col-lg-6 g-4">
                                        <div class="d-flex gap-3">
                                            <div class="">
                                                <img src="{{ asset($sabor['imagem'] ?? 'assets/img/pizza/pizza-empty.png') }}"
                                                    alt="" style="width: 100px; height: 100px"
                                                    class="rounded-circle">
                                            </div>
                                            <div class="">
                                                <h5>{{ $sabor['sabor'] }}</h5>
                                                <p class="mb-0">
                                                    {{ Str::limit($sabor['descricao'], 140) }}
                                                </p>
                                                <div class="text-danger fw-bold">
                                                    <span class="small">R$</span>
                                                    <span class="fs-5">{{ currency($sabor['valor']) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <hr>

                            <!-- bordas -->
                            <div class="small fw-bold mt-3 text-uppercase pt-2 ">Bordas</div>
                            <div class="row">
                                @foreach ($item['bordas'] as $borda)
                                    <div class="col-12 col-lg-6 g-4">
                                        <div class="d-flex gap-3">
                                            <div class="">
                                                <img src="{{ asset($borda['imagem'] ?? 'assets/img/pizza/pizza-empty.png') }}"
                                                    alt="" style="width: 100px; height: 100px"
                                                    class="rounded-circle">
                                            </div>
                                            <div class="">
                                                <h5>{{ $borda['borda'] }}</h5>
                                                <p class="mb-0">
                                                    {{ Str::limit($borda['descricao'], 140) }}
                                                </p>
                                                <div class="text-danger fw-bold">
                                                    <span class="small">R$</span>
                                                    <span class="fs-5">{{ currency($borda['valor']) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                @if (isset($item['obs']) && !is_null($item['obs']))
                <hr class="mt-4">
                    <div class="pt-3">
                        <h3 class="h6 small fw-bold text-uppercase text-muted">Observação</h3>
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <div class="d-flex gap-2 mt-2 mb-3">
                                    <div class="">
                                        <!-- Nome -->
                                        <h3 class="h6">{{ $item['obs'] }}</h3>
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
                    R$ <span class="fs-4">{{ currency($item['valor_total']) }}</span>
                </div>

                <div class="">
                    <button type="button" class="btn btn-outline-danger btn-sm " data-bs-toggle="modal"
                        data-bs-target="#modal-remover-item"
                        onclick="document.getElementById('link-remover-item').href='{{ route('cliente.resumo-pedido.remover-carrinho-produto-pizza', ['slug_store' => $store->slug_url, 'key' => $keyItem]) }}';">
                        Remover
                    </button>
                </div>
            </div>
        </div>
        <!-- ========== Fim Produto ========== -->
    @endif
@endforeach
