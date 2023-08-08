@extends('layouts.front.loja.appLoja', ['store' => $store])
@section('titulo', $product->nome . ' - ' . $store->nome)

@section('content')

    @php
        // se limitar estoque
        if ($product->limitar_estoque == 'N') {
            $product->estoque = 10000;
        } else {
            $product->estoque = obterQtdEstoque($product->id);
        }
    @endphp

    <div class="container py-5 mt-5 pt-4">

        {{-- Alertas --}}
        <x-alert-success />
        <x-alert-error />

        <!-- conteúdo produto -->
        <div class="row gy-3 px-1 gx-lg-5 my-3 mb-5" id="modal-conteudo">
            <!-- Imagem -->
            <div class="col-12 col-lg-4">
                <div class="img-produdo">
                    <img src="{{ $product->img_destaque }}" id="modal-img-produto" alt="" class="w-100"
                        style="cursor: pointer" onclick="abrirPreviaIMG(this)">
                </div>

                <!-- Imagens -->
                <div class="row mt-4 align-items-center" id="imagens-produto-selecionado">
                    <!-- min imagens -->
                    @foreach ($product->images()->orderBy('principal')->get() as $key => $img)
                        <div class="col-3 col-lg-2 p-1">
                            <div
                                class="border @if ($key == 0) border-primary @endif p-1 mini-img-produto">
                                <img src="{{ $img->foto }}" alt="" class="w-100" onmouseenter="setImg(this)"
                                    onclick="abrirPreviaIMG(this)" style="cursor:pointer">
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <!-- Dados -->
            <div class="col-12 col-lg-8 ">
                <div class="bg-light p-lg-5 rounded">
                    <form action="{{ route('cliente.adicionar-carrinho', $store->slug_url) }}" method="post">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <!-- Título e descrição -->
                        <div class="">
                            <h1 class="h2" id="modal-titulo-produto">
                                <!-- título -->
                                {{ $product->nome }}
                            </h1>
                            <p class="" id='modal-descricao-produto'>
                                <!-- descrição -->
                                {{ $product->descricao }}
                            </p>


                            @php
                                $preco_total = floatval($product->valor);
                            @endphp
                            <!-- ========== Início Produtos adicionais ========== -->
                            {{-- @if ($product->tipo == 'PRODUTO') --}}
                            @if (true)
                                <div class="" id="produtos-adicionais">
                                    @if ($additionals->count())
                                        <h2 class="h6 text-start fw-semibold  pt-2">Adicionais</h2>
                                        <div class="row row-cols-1 row-cols-xl-1">
                                            @foreach ($additionals as $key => $item)
                                                <div class="">
                                                    <div class="border my-2 d-flex gap-2 p-3 rounded">
                                                        <!-- Img -->
                                                        <div class="">
                                                            <img src="{{ $item->additional_product_foto ? $item->additional_product_foto : asset('assets/img/img-prod-vazio.png') }}"
                                                                alt="" style="max-width: 50px; min-width: 50px">
                                                        </div>
                                                        <div class="adicionais w-100">
                                                            {{-- <input type="text" name="additionals[{{ $key }}][id]" value="{{ $item->id }}" id="additional_id"> --}}
                                                            <input type="hidden"
                                                                name="additionals[{{ $key }}][id]"
                                                                value="{{ $item->additional_product_id }}"
                                                                id="additional_id">
                                                            <div class="">
                                                                <!-- Título -->
                                                                <h3 class="h5 mb-1 fw-700">
                                                                    {{ $item->additional_product_nome }}
                                                                </h3>
                                                                <p class="small text-muted pb-0 mb-0">
                                                                    {{ Str::limit($item->additional_product_descricao, 90) }}
                                                                </p>
                                                            </div>
                                                            <!-- Valor -->
                                                            <div
                                                                class="fw-700 pt-2 pb-0 d-flex justify-content-between align-items-center">
                                                                <span class="text-danger small font-open-sans">
                                                                    R$
                                                                    <span class="fs-5">
                                                                        {{ currency($item->additional_product_valor) }}
                                                                    </span>
                                                                </span>
                                                                <!-- Add Qtd. -->
                                                                <div class="ms-auto">
                                                                    <div class="">
                                                                        @php
                                                                            $product_adicional = \App\Models\Product::find($item->additional_product_id);
                                                                            if ($product_adicional->limitar_estoque == 'S') {
                                                                                // atualizar valor em estoque de acordo com oq está no carrinho
                                                                                $item->additional_product_estoque = obterQtdEstoque($item->additional_product_id);
                                                                            } else {
                                                                                $item->additional_product_estoque = 10000;
                                                                            }

                                                                        @endphp
                                                                        @if ($item->additional_product_estoque == 0)
                                                                            <div class="fw-normal">
                                                                                Sem estoque
                                                                                <input type="hidden" value="0"
                                                                                    name="additionals[{{ $key }}][qtd_adicional]">
                                                                            </div>
                                                                        @else
                                                                            <div class="input-group input-group-sm item-adicionais input-group-sm flex-nowrap"
                                                                                style="max-width: 75px">
                                                                                <!-- Subtrair -->
                                                                                <button type="button"
                                                                                    class="btn btn-light border d-flex align-items-center text-danger p-1 py-0"
                                                                                    onclick="remove_adicional({{ $item->additional_product_id }}, {{ $item->additional_product_valor }})">
                                                                                    <i class="fa-solid fa-minus"></i>
                                                                                </button>
                                                                                <input type="text"
                                                                                    class="form-control shadow-none text-center fs-6 py-0 qtd_adicional"
                                                                                    value="0"
                                                                                    name="additionals[{{ $key }}][qtd_adicional]"
                                                                                    readonly
                                                                                    id="qtd-id_{{ $item->additional_product_id }}">
                                                                                <button type="button"
                                                                                    class="btn btn-light border d-flex align-items-center text-danger p-1 py-0"
                                                                                    onclick="add_adicional({{ $item->additional_product_id }}, {{ $item->additional_product_valor }}, {{ $item->additional_product_estoque }})">
                                                                                    <i class="fa-solid fa-plus"></i>
                                                                                </button>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endif
                            <!-- ========== Fim Produtos adicionais ========== -->

                            <!-- Footer -->
                            <div class="sticky-bottom-xx bg-light pb-4 pt-1">
                                <div class="mb-3">
                                    <div class=" mb-2 pt-3">
                                        <div class="fs-3 fw-700 font-open-sans mb-3 text-danger">
                                            R$
                                            <span id="preco-produto">{{ number_format($preco_total, 2, ',', '.') }}</span>
                                        </div>
                                        @if ($product->estoque > 0)
                                            <!-- Total -->
                                            <div class="d-flex gap-2 align-items-center">
                                                <div class="">
                                                    Quantidade
                                                </div>
                                                <div class="input-group input-group-sm" style="max-width: 100px">
                                                    <!-- Subtrair -->
                                                    <button type="button"
                                                        class="btn btn-light border d-flex align-items-center text-danger"
                                                        onclick="rem_produto()">
                                                        <i class="fa-solid fa-minus"></i>
                                                    </button>
                                                    <input type="text"
                                                        class="form-control shadow-none text-center fs-5 py-0"
                                                        name="qtd_item" value="1" id="qtd_produto" readonly>
                                                    <!-- inputo com limit de estoque -->
                                                    <input type="hidden" value="{{ $product->estoque }}"
                                                        id="limit-estoque-produto">
                                                    <button type="button"
                                                        class="btn btn-light border d-flex align-items-center text-danger"
                                                        onclick="add_produto()">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @else
                                            <div class="">
                                                Não disponível em estoque
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="mb-2">
                                    <label for="" class="form-label mb-1 small fw-semibold">
                                        Observação
                                    </label>
                                    <textarea class="form-control mb-3" name="observacao" id="observacao" rows="3"
                                        @if ($product->estoque == 0) readonly @endif"></textarea>
                                </div>
                                <button type="submit"
                                    class="btn btn-danger fw-600 px-4 py-2 col-12 col-lg-auto mb-2 me-lg-2 @if ($product->estoque == 0) disabled @endif">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-cart-plus fa-sm me-1"></i>
                                        Adicionar ao Carrinho
                                    </div>
                                </button>
                                <a href="{{ route('loja.index', $store->slug_url) }}"
                                    class="btn btn-outline-danger fw-600 px-4 py-2 col-12 col-lg-auto mb-2 me-lg-2">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-plus fa-sm me-1"></i>
                                        Selecionar Outro
                                    </div>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Relacionados -->
        {{-- <div class="container">
            <h2 class="fs-5 fw-bold @if ($productsRelated->total() == 0) d-none @endif">Relacionados</h2>
            <div class="row gy-4">
                @foreach ($productsRelated as $productRelated)
                    <div class="col-12 col-lg-3">


                        <!-- LInk produto -->
                        <a href="{{ route('loja.produto.add', ['slug_store' => $store->slug_url, 'product' => $productRelated->id, 'slug_produto' => Str::slug($productRelated->nome)]) }}"
                            class="text-dark text-decoration-none">

                            <!-- Dados produto -->
                            <div class="card border item-produto">
                                <div class="card-body p-lg-3 py-lg-4">
                                    <div class="">
                                        <img src="{{ $productRelated->img_destaque }}" alt="" class="w-100">
                                    </div>
                                    <div class="">
                                        <!-- img -->
                                        <h3 class="h5 mt-4">
                                            {{ $productRelated->nome }}
                                        </h3>
                                        <!-- nome -->
                                        <p class="text-muted text-truncate">
                                            {{ $productRelated->descricao }}
                                        </p>
                                        <!-- preço -->
                                        <div class="text-end font-open-sans">
                                            <span class="fw-bold text-danger">R$
                                                <span class="h5  fw-bold">
                                                    {{ number_format($productRelated->valor, 2, ',', '.') }} </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>

                    </div>
                @endforeach
            </div>
        </div> --}}
    </div>


    </div>

    </div>

    <!-- Modal ver imagem de produto ampliada -->
    <x-loja.produtos.modal-ver-img-ampliada />

    <!-- Banner 3 -->
    <x-loja.banner_3 :store="$store" />

@endsection

@section('scripts')
    <!-- Modal loja fechada -->
    <x-loja.loja_fechada :store="$store" />

    <!-- scripts loja -->
    <script src="{{ asset('assets/js/loja.js') }}"></script>
@endsection
