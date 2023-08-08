@foreach ($order->data_order as $item)
    <div class="card mb-4 dark:border-none overflow-hidden">
        <div class="card-body dark:bg-gray-700 dark:text-gray-200">
            <!-- Produto -->
            <div class="d-flex gap-3 flex-column flex-lg-row">

                <div class="d-flex gap-3 flex-column flex-lg-row">
                    <!-- Imagem -->
                    <div class="" style="max-width: 150px">
                        {{-- <img src="{{ $item->product->img_destaque }}" alt=""
                                                        class="w-100 border rounded img-produto-resumo"> --}}
                        <img src="{{ $item['product_foto'] == '' ? asset('assets/img/img-prod-vazio.png') : $item['product_foto'] }}"
                            alt="" class="w-100 border rounded img-produto-resumo">
                    </div>
                    <div class="">
                        <!-- Nome -->
                        <h3 class="h5">
                            {{ $item['qtd_item'] }} x {{ $item['product_nome'] }}
                        </h3>
                        <p class="text-muted mb-2">
                            {{ Str::limit($item['product_descricao'], 150) }}
                        </p>
                        <div class="text-danger fs-5 fw-bold font-open-sans">
                            @php
                                $valorProduto = $item['vl_item'];
                                if (isset($item['additionals']) && count($item['additionals']) > 0) {
                                    foreach ($item['additionals'] as $value) {
                                        $valorProduto = $valorProduto - floatval($value['additional_preco']) * $value['qtd_item'] * $item['qtd_item'];
                                    }
                                }
                            @endphp
                            <!-- valor do produto -->
                            {{ currency_format($valorProduto / $item['qtd_item']) }}
                        </div>
                    </div>
                </div>
            </div>

            @if (isset($item['additionals']) && count($item['additionals']) > 0)
                <hr class="mt-4">
                <!-- Adicionais -->
                <div class="mt-3 ">
                    <div class="row">
                        @foreach ($item['additionals'] as $adicional)
                            <div class="col-12 col-lg-4">
                                <div class="d-flex gap-3">
                                    <div class="">
                                        @php
                                            $imgAd = null;
                                            $ad = \App\Models\Product::find($adicional['additional_id']);
                                            if (!is_null($ad)) {
                                                $imgAd = $ad->img_destaque;
                                            } else {
                                                $imgAd = asset('assets/img/img-prod-vazio.png');
                                            }
                                        @endphp
                                        <img src="{{ $imgAd }}" alt="" class="rounded-1"
                                            style="width: 80px; max-width: 80px; min-width:80px">
                                    </div>
                                    <div class="">
                                        <h5 class="h6 fw-bold">
                                            {{ $adicional['qtd_item'] }} x
                                            {{ $adicional['additional_nome'] }}
                                        </h5>
                                        <p class="small mb-0">
                                            {{ Str::limit($adicional['additional_descricao'], 60) }}
                                        </p>
                                        <div class="text-danger fw-semibold">
                                            <span class="fs-12px">R$</span>
                                            {{ currency($adicional['additional_preco']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Observação produto -->
            @if (isset($item['product_observacao']) && !is_null($item['product_observacao']))
                <!-- Observação produto -->
                <hr class="mt-4 mb-3">
                <div class="p">
                    <div class="fw-semibold mb-1 small">Observação sobre o produto</div>
                    <p class="text-muted">
                        {{ $item['product_observacao'] }}
                    </p>
                </div>
            @endif
        </div>
        <div class="card-footer dark:bg-gray-700 dark:text-gray-200 ">
            <div class="">
                Subtotal
            </div>
            <div class="fs-4 fw-bold font-open-sans">
                <!-- subtotal -->
                {{ currency_format($item['vl_item']) }}
            </div>
        </div>
    </div>
@endforeach
