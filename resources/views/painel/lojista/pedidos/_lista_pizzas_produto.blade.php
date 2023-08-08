@php
    $itens_pizza = $order->data_pizza_produto ?? [];
@endphp
@foreach ($itens_pizza as $keyItem => $item)
    @if (true)
        <!-- ========== Início Pizza ========== -->
        <div class="card mb-4 dark:border-none overflow-hidden">
            <div class="card-body dark:bg-gray-700 dark:text-gray-200">
                <div class=" gap-3 flex-column flex-lg-row">
                    <!-- Pedido -->
                    <div class=" gap-3">
                        <div class="">
                            <h3 class="h4">1x {{ $item['nome'] }}</h3>

                            <!-- sabores -->
                            <div class="small fw-bold mt-3 text-uppercase pt-2 ">Sabores</div>
                            <div class="row mb-3">
                                @foreach ($item['sabores'] as $sabor)
                                    <div class="col-12 col-lg-4 g-4">
                                        <div class="d-flex gap-3 ">
                                            <div class="">
                                                @if (is_null($sabor['imagem']))
                                                    <img src="{{ asset('assets/img/pizza/pizza-empty.png') }}"
                                                        alt=""
                                                        style="width: 60px; height: 60px; min-width: 60px; min-height: 60px"
                                                        class="rounded-circle">
                                                @else
                                                    @if (file_exists($sabor['imagem']))
                                                        <img src="{{ asset($sabor['imagem']) }}" alt=""
                                                            style="width: 60px; height: 60px; min-width: 60px; min-height: 60px"
                                                            class="rounded-circle">
                                                    @else
                                                        <img src="{{ asset('assets/img/pizza/pizza-empty.png') }}"
                                                            alt=""
                                                            style="width: 60px; height: 60px; min-width: 60px; min-height: 60px"
                                                            class="rounded-circle">
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="">
                                                <h5 class="fw-semibold">{{ $sabor['sabor'] }}</h5>
                                                <p class="mb-0 text-muted">
                                                    {{ Str::limit($sabor['descricao'], 120) }}
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
                            <div class="row mb-3">
                                @foreach ($item['bordas'] as $borda)
                                    <div class="col-12 col-lg-4 g-4">
                                        <div class="d-flex gap-3">
                                            <div class="">
                                                @if (is_null($borda['imagem']))
                                                    <img src="{{ asset('assets/img/pizza/pizza-empty.png') }}"
                                                        alt=""
                                                        style="width: 60px; height: 60px; min-width: 60px; min-height: 60px"
                                                        class="rounded-circle">
                                                @else
                                                    @if (file_exists($borda['imagem']))
                                                        <img src="{{ asset($borda['imagem']) }}" alt=""
                                                            style="width: 60px; height: 60px; min-width: 60px; min-height: 60px"
                                                            class="rounded-circle">
                                                    @else
                                                        <img src="{{ asset('assets/img/pizza/pizza-empty.png') }}"
                                                            alt=""
                                                            style="width: 60px; height: 60px; min-width: 60px; min-height: 60px"
                                                            class="rounded-circle">
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="">
                                                <h5 class="fw-semibold">{{ $borda['borda'] }}</h5>
                                                <p class="mb-0 text-muted">
                                                    {{ Str::limit($borda['descricao'], 120) }}
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
                <!-- Observação produto -->
                @if (isset($item['obs']) && !is_null($item['obs']))
                    <!-- Observação produto -->
                    <hr class="mt-4 mb-3">
                    <div class="p">
                        <div class="fw-semibold mb-1 small">Observação sobre o produto</div>
                        <p class="text-muted">
                            {{ $item['obs'] }}
                        </p>
                    </div>
                @endif
            </div>
            <div class="card-footer  fw-bold  lh-1 font-open-sans d-flex justify-content-between">
                <div class=" py-2">
                    <div class="dark:text-gray-200 fw-normal mb-1">Subtotal</div>
                    <div class="dark:text-gray-200">
                        R$ <span class="fs-4">{{ currency($item['valor_total']) }}</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- ========== Fim Produto ========== -->
    @endif
@endforeach
