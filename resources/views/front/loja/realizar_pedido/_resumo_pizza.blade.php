@php
    $itens_pizza = session('items_cart_pizza') ?? [];
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
                            <h3 class="h4">1x Pizza</h3>

                            <!-- sabores -->
                            <div class="small fw-bold mt-3 text-uppercase pt-2 ">Tamanho</div>
                            <div class="fs-5 pt-1 fw-bold">
                                <img src="{{ asset('assets/img/icons/check-png.png') }}" alt=""
                                    style="width: 15px">
                                {{ $item['tamanho']['nome'] }} - <span class="small text-danger">R$</span>
                                <span class="text-danger">{{ currency($item['tamanho']['valor']) }}</span>
                            </div>

                            <hr>

                            <!-- sabores -->
                            <div class="small fw-bold mt-3 text-uppercase pt-2 ">Sabores</div>
                            <div class="row">
                                @foreach ($item['sabores'] as $sabor)
                                    <div class="col-12 col-lg-6 g-4">
                                        <div class="d-flex gap-3">
                                            <div class="">
                                                <img src="{{ asset($sabor['img']) }}" alt=""
                                                    style="width: 100px; height: 100px" class="rounded-circle">
                                            </div>
                                            <div class="">
                                                <h5>{{ $sabor['nome'] }}</h5>
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
                                                <img src="{{ asset($borda['img']) }}" alt=""
                                                    style="width: 100px; height: 100px" class="rounded-circle">
                                            </div>
                                            <div class="">
                                                <h5>{{ $borda['nome'] }}</h5>
                                                <p class="mb-0">
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
                                        <div class="col-12 col-lg-6 g-4">
                                            <div class="d-flex gap-3">
                                                <div class="">
                                                    <img src="{{ $adicional['img'] }}" alt=""
                                                        style="width: 90px; height: 90px" class="rounded-3">
                                                </div>
                                                <div class="">
                                                    <h6 class="fw-bold">{{$adicional['qtd']}} x {{ $adicional['nome'] }}</h6>
                                                    <p class="mb-0 small">
                                                        {{ Str::limit($adicional['descricao'], 60) }}
                                                    </p>
                                                    <div class="text-danger fw-bold">
                                                        <span class="small">R$</span>
                                                        <span class="fs-5">{{ currency($adicional['valor'] / $adicional['qtd']) }}</span>
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
                <div class="">
                    <div class="text-muted small fw-semibold">Subtotal</div>
                    R$ <span class="fs-4">{{ currency($item['valor_total']) }}</span>
                </div>

                <div class="">
                    <button type="button" class="btn btn-outline-danger btn-sm " data-bs-toggle="modal"
                        data-bs-target="#modal-remover-item"
                        onclick="document.getElementById('link-remover-item').href='{{ route('loja.montar-pizza.remover-do-carrinho', ['slug_store' => $store->slug_url, 'index' => $keyItem]) }}';">
                        Remover
                    </button>
                </div>
            </div>
        </div>
        <!-- ========== Fim Produto ========== -->
    @endif
@endforeach
