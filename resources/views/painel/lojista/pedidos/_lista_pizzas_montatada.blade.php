@php
    $itens_pizza = $order->data_montar_pizza;
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
                            <h3 class="h4">1x Pizza</h3>

                            <!-- sabores -->
                            <div class="small fw-bold mt-3 text-uppercase pt-2 ">Tamanho</div>
                            <div class="fs-5 pt-1 fw-bold d-flex gap-2 align-items-center mb-3 pt-1">
                                <div class="">
                                    <img src="{{ asset('assets/img/icons/check-png.png') }}" alt=""
                                        style="width: 15px">
                                </div>
                                {{ $item['tamanho']['nome'] }} - <span class="small text-danger">R$</span>
                                <span class="text-danger">{{ currency($item['tamanho']['valor']) }}</span>
                            </div>

                            <hr>

                            <!-- sabores -->
                            <div class="small fw-bold mt-3 text-uppercase pt-2 ">Sabores</div>
                            <div class="row mb-3">
                                @foreach ($item['sabores'] as $sabor)
                                    <div class="col-12 col-lg-4 g-4">
                                        <div class="d-flex gap-3 ">
                                            <div class="">
                                                <img src="{{ asset($sabor['img']) }}" alt=""
                                                    style="width: 60px; height: 60px; min-width: 60px; min-height: 60px" class="rounded-circle">
                                            </div>
                                            <div class="">
                                                <h5 class="fw-semibold">{{ $sabor['nome'] }}</h5>
                                                <p class="mb-0 text-muted">
                                                    {{ $sabor['descricao'] }}
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
                                                <img src="{{ asset($borda['img']) }}" alt=""
                                                    style="width: 60px; height: 60px; min-width: 60px; min-height: 60px" class="rounded-circle">
                                            </div>
                                            <div class="">
                                                <h5 class="fw-semibold">{{ $borda['nome'] }}</h5>
                                                <p class="mb-0 text-muted">
                                                    {{ $borda['descricao'] }}
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


                            @if (count($item['adicionais']) > 0)
                                <hr>
                                <!-- Adicionais -->
                                <div class="small fw-bold mt-3 text-uppercase pt-2 ">Adicionais</div>
                                <div class="row ">
                                    @foreach ($item['adicionais'] as $adicional)
                                        <div class="col-12 col-lg-4 g-4">
                                            <div class="d-flex gap-3">
                                                <div class="">
                                                    <img src="{{ $adicional['img'] }}" alt=""
                                                        style="width: 60px; height: 60px; min-width: 60px; min-height: 60px" class="rounded-3">
                                                </div>
                                                <div class="">
                                                    <h6 class="fw-bold">{{ $adicional['qtd'] }} x
                                                        {{ $adicional['nome'] }}</h6>
                                                    <p class="mb-0 small">
                                                        {{ Str::limit($adicional['descricao'], 60) }}
                                                    </p>
                                                    <div class="text-danger fw-bold">
                                                        <span class="small">R$</span>
                                                        <span
                                                            class="fs-5">{{ currency($adicional['valor'] / $adicional['qtd']) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
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
