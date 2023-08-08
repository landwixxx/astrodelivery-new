@extends('layouts.painel.app')
@section('title', 'Cadastrar Produto')
@section('head')
    <style>
        html {
            overflow: hidden;
        }
    </style>
@endsection
@section('content')
    <br>

    {{-- Alertas --}}
    <x-alerts />

    <div class="container-fluid px-6 mx-auto grid mb-5 pb-5">
        <h2 class="my-2 text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-1">
            Cadastrar Produto
        </h2>
        <p class="small dark:text-gray-200 mb-3">
            Campos com <strong class="text-danger">*</strong> são obrigatórios
        </p>

        <div class="card border dark:border-none bg-white">
            <div class="card-body">
                <!-- Formulario -->
                <form action="{{ route('painel.lojista.produtos.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row dark:text-gray-200">
                        <!-- Tipo Produto: -->
                        <div class="col-12 col-lg-2 col-xl-2 mb-3">
                            <label for="tipo" class="form-label fw-500">
                                Tipo Produto<span class="text-danger">*</span>
                            </label>
                            <select
                                class="@error('tipo') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="tipo" id="tipo" required>
                                <option value="PRODUTO" @if (old('tipo') == 'PRODUTO') selected @endif>PRODUTO</option>
                                <option value="ADICIONAL" @if (old('tipo') == 'ADICIONAL') selected @endif>ADICIONAL
                                </option>
                                <option value="PIZZA" @if (old('tipo') == 'PIZZA') selected @endif>PIZZA</option>
                            </select>
                            @error('tipo')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- Título -->
                        <div class="col-12 col-lg-5 col-xl-5 mb-3">
                            <label for="nome" class="form-label fw-500">
                                Nome<span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="@error('nome') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="nome" value="{{ old('nome') }}" id="nome" required>
                            @error('nome')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Subnome -->
                        <div class="col-12 col-lg-3 col-xl-3 mb-3">
                            <label for="sub_nome" class="form-label fw-500">
                                Subnome<span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="@error('sub_nome') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="sub_nome" value="{{ old('sub_nome') }}" id="sub_nome" required>
                            @error('sub_nome')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Cor subnome -->
                        <div class="col-12 col-lg-2 col-xl-2 mb-3">
                            <label for="cor_sub_nome" class="form-label fw-500">
                                Cor Subnome<span class="text-danger">*</span>
                            </label>
                            <input type="color"
                                class="@error('cor_sub_nome') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="cor_sub_nome" value="{{ old('cor_sub_nome') }}" id="cor_sub_nome" required>
                            @error('cor_sub_nome')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- Descrição -->
                        <div class="col-12 col-lg-12 col-xl-12 mb-3">
                            <label for="descricao" class="form-label fw-500 ">
                                Descrição
                            </label>
                            <textarea
                                class="@error('descricao') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="descricao" id="descricao" rows="3" maxlength="2000">{{ old('descricao') }}</textarea>
                            @error('descricao')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- Código na Empresa -->
                        <div class="col-12 col-lg-3 col-xl-3 mb-3">
                            <label for="codigo_empresa" class="form-label fw-500">
                                Código na Empresa
                            </label>
                            <input type="text"
                                class="@error('codigo_empresa') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="codigo_empresa" id="codigo_empresa" value="{{ old('codigo_empresa') }}"
                                maxlength="255">
                            @error('codigo_empresa')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Código de barras -->
                        <div class="col-12 col-lg-6 col-xl-6 mb-3">
                            <label for="codigo_barras" class="form-label fw-500">
                                Código de barras
                            </label>
                            <input type="text"
                                class="@error('codigo_barras') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="codigo_barras" value="{{ old('codigo_barras') }}" id="codigo_barras" placeholder=""
                                maxlength="255">
                            @error('codigo_barras')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Padrão Codigo Barras: -->
                        <div class="col-12 col-lg-3 col-xl-3 mb-3">
                            <label for="codigo_barras_padrao" class="form-label fw-500">
                                Padrão Código Barras
                            </label>
                            <select
                                class="@error('codigo_barras_padrao') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="codigo_barras_padrao" id="codigo_barras_padrao">
                                <option value="" selected>Selecione</option>
                                <option value="TYPE_EAN_13" @if (old('codigo_barras_padrao') == 'TYPE_EAN_13') selected @endif>
                                    TYPE_EAN_13
                                </option>
                                <option value="TYPE_CODE_128" @if (old('codigo_barras_padrao') == 'TYPE_CODE_128') selected @endif>
                                    ADICIONAL
                                </option>
                                <option value="TYPE_CODE_39" @if (old('codigo_barras_padrao') == 'TYPE_CODE_39') selected @endif>
                                    TYPE_CODE_39
                                </option>
                                <option value="TYPE_INTERLEAVED_2_5" @if (old('codigo_barras_padrao') == 'TYPE_INTERLEAVED_2_5') selected @endif>
                                    TYPE_INTERLEAVED_2_5
                                </option>
                                <option value="TYPE_EAN_8" @if (old('codigo_barras_padrao') == 'TYPE_EAN_8') selected @endif>
                                    TYPE_EAN_8
                                </option>
                            </select>
                            @error('codigo_barras_padrao')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Categoria: -->
                        <div class="col-12 col-lg-4 col-xl-4 mb-3">
                            <label for="category_id" class="form-label fw-500">
                                Categoria<span class="text-danger">*</span>
                            </label>
                            <select
                                class="@error('category_id') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="category_id" id="category_id" required>
                                <option value="" selected>Selecione</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        @if (old('category_id') == $category->id) selected @endif>
                                        {{ $category->nome }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Valor Original -->
                        <div class="col-12 col-lg-2 col-xl-2 mb-3">
                            <label for="valor_original" class="form-label fw-500">
                                Valor Original
                                <x-show-infor msg='Deixe 0 se não quiser informar' />
                            </label>
                            <input type="text"
                                class="@error('valor_original') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="valor_original" id="valor_original" value="{{ old('valor_original') }}"
                                placeholder="0,00" required>
                            @error('valor_original')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Valor -->
                        <div class="col-12 col-lg-2 col-xl-2 mb-3">
                            <label for="valor" class="form-label fw-500">
                                Valor<span class="text-danger">*</span>
                                <x-show-infor msg='Valor normal do item' />
                            </label>
                            <input type="text"
                                class="@error('valor') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="valor" id="valor" value="{{ old('valor') }}" placeholder="0,00">
                            @error('valor')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Estoque -->
                        <div class="col-12 col-lg-2 col-xl-2 mb-3">
                            <label for="estoque" class="form-label fw-500  d-flex align-items-center gap-1">
                                Estoque
                            </label>
                            <input type="text"
                                class="@error('estoque') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="estoque" value="{{ old('estoque') }}" id="estoque">
                            @error('estoque')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Ordem -->
                        <div class="col-12 col-lg-2 col-xl-2 mb-3">
                            <label for="ordem" class="form-label fw-500  d-flex align-items-center gap-1">
                                Ordem
                                <x-show-infor
                                    msg='Qualquer texto ou número para ordenamento na lista de itens, deixe 1 para não ordenar' />
                            </label>
                            <input type="text"
                                class="@error('ordem') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="ordem" value="{{ old('ordem') }}" id="ordem">
                            @error('ordem')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Limitar Estoque: -->
                        <div class="col-12 col-lg-3 col-xl-3 mb-3">
                            <label for="limitar_estoque" class="form-label fw-500">
                                Limitar Estoque<span class="text-danger">*</span>
                                <x-show-infor
                                    msg='Sim: Irá bloquear pedidos caso o estoque do produto esteja zerado. Não: Permite fazer pedido com estoque zerado' />
                            </label>
                            <select
                                class="@error('limitar_estoque') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="limitar_estoque" id="limitar_estoque" required>
                                <option value="" selected>Selecione</option>
                                <option value="S" @if (old('limitar_estoque') == 'S') selected @endif>SIM</option>
                                <option value="N" @if (old('limitar_estoque') == 'N') selected @endif>NAO</option>
                            </select>
                            @error('limitar_estoque')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Fração: -->
                        <div class="col-12 col-lg-3 col-xl-3 mb-3">
                            <label for="fracao" class="form-label fw-500">
                                Fração<span class="text-danger">*</span>
                                <x-show-infor msg='Informar sempre "Não" ' />
                            </label>
                            <select
                                class="@error('fracao') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="fracao" id="fracao" required>
                                <option value="N" selected>NAO</option>
                                <option value="S" @if (old('fracao') == 'S') selected @endif>SIM</option>
                            </select>
                            @error('fracao')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Item Adicional: -->
                        <div class="col-12 col-lg-3 col-xl-3 mb-3" id='col-item_adicional'
                            style="@if (old('tipo') == 'ADICIONAL') display:block; @else display:none @endif">
                            <label for="item_adicional" class="form-label fw-500">
                                Item Adicional<span class="text-danger">*</span>
                                <x-show-infor
                                    msg="Sim: Caso o produto seja um adicional, somente irá aparecer como adicional de algum produto. Não: Produto normal" />
                            </label>
                            <select
                                class="@error('item_adicional') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="item_adicional" id="item_adicional" style=""
                                @if (old('tipo') == 'ADICIONAL') required @endif>
                                <option value="S" @if (old('item_adicional') == 'S') selected @endif>SIM</option>
                                <option value="N" @if (old('item_adicional') == 'N') selected @endif>NAO</option>
                            </select>
                            @error('item_adicional')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- Obrigar Item Adicional: -->
                        <div class="col-12 col-lg-3 col-xl-3 mb-3" id="div-item_adicional_obrigar"
                            style="@if (old('tipo') == 'PRODUTO' || old('tipo') == 'PIZZA') display:block; @else display:none @endif">
                            <label for="item_adicional_obrigar" class="form-label fw-500">
                                Obrigar Item Adicional<span class="text-danger">*</span>
                                <x-show-infor
                                    msg="Sim: Obriga a selecionar pelo menos 1 item adicional no pedido. Não: Não obriga" />
                            </label>
                            <select
                                class="@error('item_adicional_obrigar') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="item_adicional_obrigar" id="item_adicional_obrigar" required>
                                <option value="N" @if (old('item_adicional_obrigar') == 'N') selected @endif>NAO</option>
                                <option value="S" @if (old('item_adicional_obrigar') == 'S') selected @endif>SIM</option>
                            </select>
                            @error('item_adicional_obrigar')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- Item Adicional Multi: -->
                        <div class="col-12 col-lg-3 col-xl-3 mb-3" id="div-item_adicional_multi"
                            style="@if (old('tipo') == 'PRODUTO' || old('tipo') == 'PIZZA') display:block; @else display:none @endif">
                            <label for="item_adicional_multi" class="form-label fw-500">
                                Item Adicional Multi<span class="text-danger">*</span>
                            </label>
                            <select
                                class="@error('item_adicional_multi') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="item_adicional_multi" id="item_adicional_multi" required>
                                <option value="N" @if (old('item_adicional_multi') == 'N') selected @endif>NAO</option>
                                <option value="S" @if (old('item_adicional_multi') == 'S') selected @endif>SIM</option>
                            </select>
                            @error('item_adicional_multi')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- Adicional Qtd Min -->
                        <div class="col-12 col-lg-3 col-xl-3 mb-3" id="div-adicional_qtde_min"
                            style="@if (old('tipo') == 'PRODUTO' || old('tipo') == 'PIZZA') display:block; @else display:none @endif">
                            <label for="adicional_qtde_min" class="form-label fw-500  d-flex align-items-center gap-1">
                                Adicional Qtd. Mínima
                                <x-show-infor
                                    msg="Quantidade mínima de adicionais para o produto, deixe vazio para ignorar" />
                            </label>
                            <input type="text"
                                class="@error('adicional_qtde_min') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="adicional_qtde_min" value="{{ old('adicional_qtde_min') }}"
                                id="adicional_qtde_min">
                            @error('adicional_qtde_min')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Adicional Qtd Max -->
                        <div class="col-12 col-lg-3 col-xl-3 mb-3" id="div-adicional_qtde_max"
                            style="@if (old('tipo') == 'PRODUTO' || old('tipo') == 'PIZZA') display:block; @else display:none @endif">
                            <label for="adicional_qtde_max" class="form-label fw-500  d-flex align-items-center gap-1">
                                Adicional Qtd. Máxima
                                <x-show-infor
                                    msg="Quantidade máxima de adicionais permitido para o produto, deixe vazio para ignorar" />
                            </label>
                            <input type="text"
                                class="@error('adicional_qtde_max') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="adicional_qtde_max" value="{{ old('adicional_qtde_max') }}"
                                id="adicional_qtde_max">
                            @error('adicional_qtde_max')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Adicional Junção: -->
                        <div class="col-12 col-lg-3 col-xl-3 mb-3" id="div-adicional_juncao"
                            style="@if (old('tipo') == 'PRODUTO' || old('tipo') == 'PIZZA') display:block; @else display:none @endif">
                            <label for="adicional_juncao" class="form-label fw-500">
                                Adicional Junção<span class="text-danger">*</span>
                            </label>
                            <select
                                class="@error('adicional_juncao') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="adicional_juncao" id="adicional_juncao" required>
                                <option value="SOMA" @if (old('adicional_juncao') == 'SOMA') selected @endif>SOMA</option>
                                <option value="DIVIDIR" @if (old('adicional_juncao') == 'DIVIDIR') selected @endif>DIVIDIR
                                </option>
                                <option value="MEDIA" @if (old('adicional_juncao') == 'MEDIA') selected @endif>MEDIA</option>
                            </select>
                            @error('adicional_juncao')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- Grupo de Adicional: -->
                        <div class="col-12 col-lg-3 col-xl-3 mb-3" id="div-grupo-adicional"
                            style="@if (old('tipo') == 'ADICIONAL') display:block; @else display:none @endif">
                            <label for="grupo_adicional_id" class="form-label fw-500">
                                Grupo de Adicional
                            </label>
                            <select
                                class="@error('grupo_adicional_id') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="grupo_adicional_id" id="grupo_adicional_id"
                                @if (old('tipo') == 'ADICIONAL') required @endif>
                                <option value="" selected>Selecione</option>
                                @foreach ($additional_groups as $additional_group)
                                    <option value="{{ $additional_group->id }}"
                                        @if (old('grupo_adicional_id') == $additional_group->id) selected @endif>
                                        {{ $additional_group->nome }}
                                    </option>
                                @endforeach
                            </select>
                            @error('grupo_adicional_id')
                                <div class="invalid-feedback fw-bold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <hr class="mb-4 mt-4">

                        <!-- ========== Início Imagens do produtos ========== -->

                        <div class="col-12 overflow-hidden">
                            <h2 class="h5 fw-bold">Imagem do produto</h2>
                            <div class="form-group" id="file_imagem">
                                <div class="mt-3 d-lg-flex gap-2">
                                    <div class="">
                                        <img src="{{ asset('assets/img/img-exemplo.png') }}" alt=""
                                            width="100" id="img-prev-1" style="min-width: 100px">
                                    </div>
                                    <div class="mt-3 mt-lg-0">
                                        <input type="file" name="imagem_prod[]" onchange="onFileChangeImg(1)"
                                            id="input-prev-1" class="prev-imagem"
                                            accept=".jpg,.jpeg,.png,.gif,.bmp,.webp" required>
                                        <div class="fs-11px text-muted pt-1">
                                            Tipos suportados: jpg, jpeg, png, gif, bmp, webp
                                        </div>
                                    </div>
                                </div>

                            </div>
                            @error('imagem_prod.0')
                                <div class="text-danger mt-1"> {{ $message }} </div>
                            @enderror
                            <!-- Add mais -->
                            <div class="mt-3 pt-3 mb-4">
                                <button type="button"
                                    class="py-1 px-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 d-flex align-items-center gap-1"
                                    id="add_imagem">
                                    <span class="material-symbols-outlined h6 m-0 p-0">
                                        add_circle
                                    </span>
                                    Mais Imagens
                                </button>
                            </div>
                        </div>

                        <!-- ========== Fim Imagens do produtos ========== -->

                        <hr class="mb-2 mt-4">

                        <div class="col-12 mt-4 mb-3">
                            <div class="col-md-4 col-lg-2">
                                <button type="submit" class="btn btn-primary bg-primary w-100">
                                    Cadastrar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

    <!-- jqury -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script>
        $(document).on('ready', function() {
            $('#add_imagem').on('click', function() {

                let count = document.querySelectorAll('.prev-imagem').length + 2;

                $('#file_imagem').append(
                    `<div class="mt-3 d-flex gap-lg-2">
                        <div class="">
                            <img src="{{ asset('assets/img/img-exemplo.png') }}" alt=""
                                width="100" id="img-prev-${count}">
                        </div>
                        <div class="">
                            <input type="file" name="imagem_prod[]" onchange="onFileChangeImg(${count})"
                                id="input-prev-${count}" accept=".jpg,.jpeg,.png,.gif,.bmp,.webp" class="prev-imagem">
                            <div class="fs-11px text-muted pt-1">
                                Tipos suportados: jpg, jpeg, png, gif, bmp, webp
                            </div>
                        </div>
                    </div>`
                )
            })
        })

        /* Add previa de img */
        function onFileChangeImg(id) {
            let e = document.getElementById('input-prev-' + id)
            let files = e.files || e.dataTransfer.files;
            if (!files.length) {
                return
            }
            createImage(files[0], id)
        }

        function createImage(file, id) {
            let reader = new FileReader()
            reader.onload = (e) => {
                document.getElementById('img-prev-' + id).src = e.target.result
            }
            reader.readAsDataURL(file)
        }
    </script>

    <!-- Mascaras de input -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/imask/6.4.3/imask.min.js"></script>
    <script>
        var valor_original = IMask(
            document.getElementById('valor_original'), {
                mask: [{
                        mask: ''
                    },
                    {
                        mask: 'R$ num',
                        lazy: false,
                        blocks: {
                            num: {
                                mask: Number,
                                scale: 2,
                                thousandsSeparator: '.',
                                padFractionalZeros: true,
                                radix: ',',
                                mapToRadix: ['.'],
                            }
                        }
                    }
                ]
            }
        );

        var valor = IMask(
            document.getElementById('valor'), {
                mask: [{
                        mask: ''
                    },
                    {
                        mask: 'R$ num',
                        lazy: false,
                        blocks: {
                            num: {
                                mask: Number,
                                scale: 2,
                                thousandsSeparator: '.',
                                padFractionalZeros: true,
                                radix: ',',
                                mapToRadix: ['.'],
                            }
                        }
                    }
                ]
            }
        );

        var estoque = IMask(document.getElementById('estoque'), {
            mask: '00000000'
        });

        var ordem = IMask(document.getElementById('ordem'), {
            mask: '00000000'
        });
        var adicional_qtde_min = IMask(document.getElementById('adicional_qtde_min'), {
            mask: '00000000'
        });
        var adicional_qtde_max = IMask(document.getElementById('adicional_qtde_max'), {
            mask: '00000000'
        });

        function exibirCamposAdicional() {
            let valorSelect = document.getElementById('tipo').value;
            if (valorSelect == 'ADICIONAL') {
                document.getElementById('div-grupo-adicional').style.display = 'block'
                document.getElementById('grupo_adicional_id').required = true

                document.getElementById('col-item_adicional').style.display = 'block'
                document.getElementById('item_adicional').required = true
            } else {
                document.getElementById('div-grupo-adicional').style.display = 'none'
                document.getElementById('grupo_adicional_id').required = false

                document.getElementById('col-item_adicional').style.display = 'none'
                document.getElementById('item_adicional').required = false
            }

            if (valorSelect == 'PRODUTO' || valorSelect == 'PIZZA') {
                document.getElementById('div-item_adicional_obrigar').style.display = 'block'
                document.getElementById('item_adicional_obrigar').required = true

                document.getElementById('div-item_adicional_multi').style.display = 'block'
                document.getElementById('item_adicional_multi').required = true

                document.getElementById('div-adicional_qtde_min').style.display = 'block'
                document.getElementById('div-adicional_qtde_max').style.display = 'block'

                document.getElementById('div-adicional_juncao').style.display = 'block'
                document.getElementById('adicional_juncao').required = true
            } else {
                document.getElementById('div-item_adicional_obrigar').style.display = 'none'
                document.getElementById('item_adicional_obrigar').required = false
                document.getElementById('item_adicional_obrigar').value = 'N'

                document.getElementById('div-item_adicional_multi').style.display = 'none'
                document.getElementById('item_adicional_multi').required = false
                document.getElementById('item_adicional_multi').value = 'N'

                document.getElementById('div-adicional_qtde_min').style.display = 'none'
                document.getElementById('adicional_qtde_min').value = ''

                document.getElementById('div-adicional_qtde_max').style.display = 'none'
                document.getElementById('adicional_qtde_max').value = ''

                document.getElementById('div-adicional_juncao').style.display = 'none'
            }
        }

        window.onload = function() {
            exibirCamposAdicional()
        }

        // exibir grupo de adicional se o produto for do tipo de adicional
        document.getElementById('tipo').onchange = function() {
            exibirCamposAdicional()

            /* Redirecionar se o tipo de produto for pizza */
            var select = document.getElementById("tipo");
            var selectedOption = select.options[select.selectedIndex].value;

            if (selectedOption == 'PIZZA') {
                window.location.href = `{{ route('painel.lojista.produtos.pizza.create') }}`;
            }
        }
    </script>
    <script>
        /* Ativar popovers bootstrap */
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
    </script>
@endsection
