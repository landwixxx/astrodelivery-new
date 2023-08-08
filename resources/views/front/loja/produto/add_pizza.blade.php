@extends('layouts.front.loja.app', ['store' => $store])
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

                            <!-- ========== Início teste adicionasi ========== -->

                            <!-- Adicionais sabores -->
                            <div class="" id="produtos-adicionais">
                                @php
                                    $index = 0;
                                @endphp
                                @foreach ($gruposAdicionais as $keyGroup => $adicionaisDoGrupo)
                                    @php
                                        $index++;
                                        if (count($adicionaisDoGrupo) == 0) {
                                            continue;
                                        }
                                    @endphp
                                    <h2 class="h6 text-start fw-semibold  pt-2 mb-0 pb-0">{{ $keyGroup }}</h2>
                                    <div class="row row-cols-1 row-cols-xl-1">
                                        @foreach ($adicionaisDoGrupo as $keyItem => $item)
                                            @php
                                                $item = (object) $item;
                                            @endphp
                                            <div class="">
                                                <div class="border my-2 d-flex gap-1 p-3 align-items-center rounded">
                                                    <div class="adicionais w-100">
                                                        <input type="hidden"
                                                            name="additionals[{{ $item->additional_product_id }}][id]"
                                                            value="{{ $item->additional_product_id }}"
                                                            class="additional_id">
                                                        <div class="d-flex gap-2 ">
                                                            <div class="">
                                                                <img src="{{ isset($item->additional_product_foto) ? $item->additional_product_foto : asset('assets/img/img-prod-vazio.png') }}"
                                                                    alt="" class="" width="50"
                                                                    style="min-width: 50px">
                                                            </div>
                                                            <!-- Título -->
                                                            <div class="w-100">
                                                                <h3 class="fs-5 mb-1 fw-700">
                                                                    {{ $item->additional_product_nome }}
                                                                </h3>
                                                                <p class="text-muted fs-14px lh-sm mb-0 pb-0">
                                                                    {{ Str::limit($item->additional_product_descricao, 50) }}
                                                                </p>
                                                                <div class="d-flex justify-content-between gap-2 mt-2">
                                                                    <!-- Valor do adicional -->
                                                                    <div class="fw-bold text-danger">
                                                                        <span class="small">R$</span> <span
                                                                            class="fs-5">{{ number_format($item->additional_product_valor, 2, ',', '.') }}</span>
                                                                    </div>
                                                                    <!-- Add mais -->
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
                                                                                    name="additionals[{{ $item->additional_product_id }}][qtd_adicional]">
                                                                            </div>
                                                                        @else
                                                                            <div class="input-group input-group-sm item-adicionais input-group-sm"
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
                                                                                    name="additionals[{{ $item->additional_product_id }}][qtd_adicional]"
                                                                                    readonly
                                                                                    id="qtd-id_{{ $item->additional_product_id }}">
                                                                                <button type="button"
                                                                                    class="btn btn-light border d-flex align-items-center text-danger p-1 py-0"
                                                                                    onclick="add_adicional({{ $item->additional_product_id }}, {{ $item->additional_product_valor }}, {{ $item->additional_product_estoque }})">
                                                                                    <i class="fa-solid fa-plus"></i>
                                                                                </button>
                                                                                {{-- <div class="">
                                                                                    {{$additionals[{{ $keyItem }}]['qtd_adicional']}}
                                                                                </div> --}}
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>


                            <!-- ========== Fim teste adicionasi ========== -->


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
                                    class="btn btn-outline-danger fw-600 px-4 py-2 col-12 col-lg-auto mb-2 me-lg-2"
                                    @if ($product->estoque == 0) disabled @endif>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-cart-plus fa-sm me-1"></i>
                                        Adicionar ao Carrinho
                                    </div>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
