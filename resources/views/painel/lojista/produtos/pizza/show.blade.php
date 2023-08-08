@extends('layouts.painel.app')
@section('title', 'Visualizar Produto')
@section('head')
    <style>
        @media (min-width: 992px) {

            body,
            html {
                overflow: hidden;
            }
        }
    </style>
@endsection
@section('content')
    <br>

    {{-- Alertas --}}
    <x-alerts />

    <div class="container-fluid px-6 mx-auto grid dark:text-gray-200 mb-5 pb-5">
        <h2 class="my-2 text-2xl font-semibold text-gray-700 dark:text-gray-200 px-lg-3">
            Visualizar Produto
        </h2>

        <div class="w-full overflow-x-auto px-lg-3">

            <!-- Informações -->
            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 sabores">
                <div class="row gy-2 dark:text-gray-200 pb-2 ">
                    <div class="col-12">
                        <h2 class=" mb-0 fw-semibold h5 mb-2">Informações</h2>
                    </div>

                    <!-- imagem -->
                    <div class="col-12 col-lg-3 mb-3 ">
                        <div class=" overflow-hidden rounded-1 border"
                            style="max-width: 220px; max-height: 220px; min-height: 220px;">
                            <img src="{{ $product->img_destaque }}" alt=""
                                style="max-width: 220px; min-width: 220px; max-height: 220px; min-height: 220px;">
                        </div>
                    </div>

                    <div class="col-12 col-lg-9">
                        <div class="row gy-4">

                            <!-- Título -->
                            <div class="col-12 col-lg-5 ">
                                <label class=" form-label">Título:</label>
                                <div class="fs-5">
                                    {{ $product->nome }}
                                </div>
                            </div>
                            <!-- Categoria: -->
                            <div class="col-12 col-lg-3">
                                <label for="category_id" class="form-label fw-500">
                                    Categoria:
                                </label>
                                <div class="fs-5">
                                    {{ $product->category->nome }}
                                </div>
                            </div>
                            <!-- Valor Mínimo -->
                            <div class="col-12 col-lg-3 ">
                                <label class=" form-label">Valor Mínimo:</label>
                                <div class="fs-5">
                                    {{ currency_format($product->valor) }}
                                </div>
                            </div>
                            <!-- Descrição -->
                            <div class="col-12 ">
                                <label class="form-label" for="descricao">Descrição:</label>
                                <div class="fs-5">
                                    {{ $product->descricao ?? '-' }}
                                </div>
                            </div>
                            <!-- Ordem -->
                            <div class="col-12 col-lg-2 col-xl-2 mb-3">
                                <label for="ordem" class="form-label fw-500  d-flex align-items-center gap-1">
                                    Ordem:
                                </label>
                                <div class="fs-5">
                                    {{ $product->ordem }}
                                </div>
                            </div>
                            <!-- Código na Empresa -->
                            <div class="col-12 col-lg-3 col-xl-3 mb-3">
                                <label for="codigo_empresa" class="form-label fw-500">
                                    Código na Empresa
                                </label>
                                <div class="fs-5">
                                    {{ $product->codigo_empresa ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========== Início Sabores ========== -->
            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 sabores">
                <div class="row gy-2 dark:text-gray-200">
                    <div class="row gy-2">
                        <h2 class="col-12 mb-3 fw-semibold h5">Sabores</h2>
                        <div class="row">
                            <div class="mb-3 col-12 col-lg-4">
                                <label for="qtd-min" class="form-label">Qtd. Mínima de sabores: </label>
                                <div class="fs-5">
                                    {{ $product->pizza_product->qtd_min_sabores }}
                                </div>
                            </div>
                            <div class="mb-3 col-12 col-lg-4">
                                <label for="qtd-max" class="form-label">Qtd. Máxima de sabores: </label>
                                <div class="fs-5">
                                    {{ $product->pizza_product->qtd_max_sabores }}
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr class="mb-3" style="border-width: 5px ">
                        </div>
                        <!-- Categorias -->
                        <div id="lista-categorias">
                            @foreach ($product->pizza_product->sabores as $key => $item)
                                <div class="class-sabores">
                                    <h3 class="h3 mb-3"> {{ $item['categoria'] }} </h3>
                                    <!-- Sabores -->
                                    <div class="col-12" id="inputs-sabores-{{ time() + $key }}">
                                        @foreach ($item['itens'] as $keyItemSabor => $itemSabor)
                                            <div class="row mb-3  pt-2">
                                                <!-- imagem -->
                                                <div class="col-6 col-lg-2 overflow-hidden "
                                                    style="max-width: 110px; max-height: 110px; min-height: 110px">
                                                    <img src="{{ asset($itemSabor['imagem'] ?? 'assets/img/pizza/pizza-empty.png') }}"
                                                        alt="" class="w-100 rounded-3 img-pizza-sabor "
                                                        style="max-width: 110px;">
                                                </div>
                                                <div class="col-12 col-lg-5 col-xl-5 mb-3">
                                                    <!-- sabor -->
                                                    <label class="form-label mb-1">Sabor:</label>
                                                    <div class="fs-5">
                                                        {{ $itemSabor['sabor'] }}
                                                    </div>
                                                    <div class="mb-3"></div>
                                                    <!-- Descrição -->
                                                    <label class="form-label mb-1">Descrição:</label>
                                                    <div class="fs-5">
                                                        {{ $itemSabor['descricao'] != '' ? $itemSabor['descricao'] : '-' }}
                                                    </div>
                                                </div>
                                                <!-- valor -->
                                                <div class="col-12 col-lg-2 col-xl-2 mb-3">
                                                    <label class="form-label mb-1">Valor:</label>
                                                    <div class="fs-5">
                                                        {{ currency_format($itemSabor['valor']) }}
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <hr>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
            <!-- ========== Fim Sabores ========== -->

            <!-- ========== Início Bordas ========== -->
            <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 bordas">
                <div class="row gy-2 dark:text-gray-200">
                    <div class="row gy-2">
                        <h2 class="h5 mb-3 col-12 fw-semibold ">Sabores da borda</h2>
                        <!-- bordas -->
                        <div class="col-12" id="inputs-bordas">
                            <!-- bordas -->
                            @foreach ($product->pizza_product->bordas as $key => $item)
                                <div class="row mb-3 border-bottom border-secondary pt-2">
                                    <!-- imagem -->
                                    <div class="col-6 col-lg-2 overflow-hidden "
                                        style="max-width: 110px; max-height: 110px; min-height: 110px">
                                        <img src="{{ asset($item['imagem'] ?? 'assets/img/pizza/pizza-empty.png') }}"
                                            alt="" class="w-100 rounded-3 img-pizza-borda "
                                            style="max-width: 110px;">
                                    </div>
                                    <!-- borda -->
                                    <div class="col-12 col-lg-5 col-xl-5 mb-3">
                                        <label class="form-label fw-500">
                                            Borda
                                        </label>
                                        <div class="fs-5">
                                            {{ $item['borda'] }}
                                        </div>

                                        <label class="form-label fw-500 mt-3">
                                            Descrição:
                                        </label>
                                        <div class="fs-5">
                                            {{ $item['descricao'] == '' ? '-' : $item['descricao'] }}
                                        </div>
                                    </div>
                                    <!-- valor -->
                                    <div class="col-12 col-lg-2 col-xl-2 mb-3">
                                        <label class="form-label fw-500">
                                            Valor:
                                        </label>
                                        <div class="fs-5">
                                            {{ currency_format($item['valor']) }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- ========== Fim Bordas ========== -->

            <div class="">
                <a href="{{ route('painel.lojista.produtos.pizza.edit', $product->id) }}"
                    class="btn btn-success bg-success px-5 text-uppercase ">
                    Editar
                </a>
            </div>
        </div>
    </div>

@endsection
