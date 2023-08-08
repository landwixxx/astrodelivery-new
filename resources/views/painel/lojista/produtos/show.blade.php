@extends('layouts.painel.app')
@section('title', 'Visualizar Produto')
@section('head')
    <!-- scripts necessários para a lib select2 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/i18n/pt-BR.js"></script>

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
        <h2 class="my-2 mb-3 text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-1">
            Visualizar Produto
        </h2>
        
        <div class="card border dark:border-none bg-white">
            <div class="card-body">
                <!-- Formulario -->
                <form action="{{ route('painel.lojista.produtos.update', $produto->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row dark:text-gray-200 g-4">

                        <!-- Nome -->
                        <div class="col-12 col-lg-4">
                            <div class="rounde-3 p-3 dark:bg-gray-700 dark:text-gray-200  ">
                                <div class="fw-bold small">Nome:</div>
                                <div class="">
                                    {{ $produto->nome }}
                                </div>
                            </div>
                        </div>

                        <!-- Subnome -->
                        <div class="col-12 col-lg-4">
                            <div class="rounde-3 p-3 dark:bg-gray-700 dark:text-gray-200  ">
                                <div class="fw-bold small">Subnome:</div>
                                <div class="">
                                    {{ $produto->sub_nome }}
                                </div>
                            </div>
                        </div>
                        <!-- Descrição -->
                        <div class="col-12 col-lg-4">
                            <div class="rounde-3 p-3 dark:bg-gray-700 dark:text-gray-200  ">
                                <div class="fw-bold small">Descrição:</div>
                                <div class="">
                                    {{ $produto->descricao ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <!-- Imagens -->
                        <div class="col-12 col-lg-12">
                            <div class="rounded-3 bg-gray-100 p-3 dark:bg-gray-700 dark:text-gray-200  ">
                                <div class="fw-bold small mb-1">Imagens:</div>
                                <div class="row g-3">
                                    @foreach ($produto->images as $item)
                                        <div class="col-6 col-mg-4 col-lg-3 col-xl-2">
                                            <img src="{{ $item->foto }}" alt="" class="w-100">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tipo -->
                        <div class="col-12 col-lg-4">
                            <div class="rounde-3 p-3 dark:bg-gray-700 dark:text-gray-200  ">
                                <div class="fw-bold small">Tipo:</div>
                                <div class="">
                                    {{ $produto->tipo }}
                                </div>
                            </div>
                        </div>
                        <!-- Cor Subnome -->
                        <div class="col-12 col-lg-4">
                            <div class="rounde-3 p-3 dark:bg-gray-700 dark:text-gray-200  ">
                                <div class="fw-bold small">Cor Subnome:</div>
                                <div class="d-flex gap-1 align-items-center mt-1">
                                    <div class="d-inline-block"
                                        style="background: {{ $produto->cor_sub_nome }}; width: 20px; height: 20px;"> </div>
                                    <div class="d-inline-block">
                                        {{ $produto->cor_sub_nome }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Código na Empresa -->
                        <div class="col-12 col-lg-4">
                            <div class="rounde-3 p-3 dark:bg-gray-700 dark:text-gray-200  ">
                                <div class="fw-bold small">Código na Empresa:</div>
                                <div class="">
                                    {{ $produto->codigo_empresa }}
                                </div>
                            </div>
                        </div>
                        <!-- Código de barras -->
                        <div class="col-12 col-lg-4">
                            <div class="rounde-3 p-3 dark:bg-gray-700 dark:text-gray-200  ">
                                <div class="fw-bold small">Código de barras:</div>
                                <div class="">
                                    {{ $produto->codigo_barras }}
                                </div>
                            </div>
                        </div>
                        <!-- Padrão Código Barras -->
                        <div class="col-12 col-lg-4">
                            <div class="rounde-3 p-3 dark:bg-gray-700 dark:text-gray-200  ">
                                <div class="fw-bold small">Padrão Código Barras:</div>
                                <div class="">
                                    {{ $produto->codigo_barras_padrao }}
                                </div>
                            </div>
                        </div>
                        <!-- Categoria -->
                        <div class="col-12 col-lg-4">
                            <div class="rounde-3 p-3 dark:bg-gray-700 dark:text-gray-200  ">
                                <div class="fw-bold small">Categoria:</div>
                                <div class="">
                                    {{ $produto->category->first()->nome }}
                                </div>
                            </div>
                        </div>
                        <!-- Valor Original -->
                        <div class="col-12 col-lg-4">
                            <div class="rounde-3 p-3 dark:bg-gray-700 dark:text-gray-200  ">
                                <div class="fw-bold small">Valor Original:</div>
                                <div class="">
                                    {{ currency_format($produto->valor_original) }}
                                </div>
                            </div>
                        </div>
                        <!-- Valor -->
                        <div class="col-12 col-lg-4">
                            <div class="rounde-3 p-3 dark:bg-gray-700 dark:text-gray-200  ">
                                <div class="fw-bold small">Valor:</div>
                                <div class="">
                                    {{ currency_format($produto->valor) }}
                                </div>
                            </div>
                        </div>
                        <!-- Estoque -->
                        <div class="col-12 col-lg-4">
                            <div class="rounde-3 p-3 dark:bg-gray-700 dark:text-gray-200  ">
                                <div class="fw-bold small">Estoque:</div>
                                <div class="">
                                    {{ $produto->estoque }}
                                </div>
                            </div>
                        </div>
                        <!-- Ordem -->
                        <div class="col-12 col-lg-4">
                            <div class="rounde-3 p-3 dark:bg-gray-700 dark:text-gray-200  ">
                                <div class="fw-bold small">Ordem:</div>
                                <div class="">
                                    {{ $produto->ordem }}
                                </div>
                            </div>
                        </div>
                        <!-- Limitar Estoque -->
                        <div class="col-12 col-lg-4">
                            <div class="rounde-3 p-3 dark:bg-gray-700 dark:text-gray-200  ">
                                <div class="fw-bold small">Limitar Estoque:</div>
                                <div class="">
                                    {{ $produto->limitar_estoque == 'S' ? 'Sim' : 'Não' }}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Fração -->
                        <div class="col-12 col-lg-4">
                            <div class="rounde-3 p-3 dark:bg-gray-700 dark:text-gray-200  ">
                                <div class="fw-bold small">Fração:</div>
                                <div class="">
                                    {{ $produto->fracao == 'S' ? 'Sim' : 'Não' }}
                                </div>
                            </div>
                        </div>
                        <!-- Item Adicional -->
                        <div class="col-12 col-lg-4">
                            <div class="rounde-3 p-3 dark:bg-gray-700 dark:text-gray-200  ">
                                <div class="fw-bold small">Item Adicional:</div>
                                <div class="">
                                    {{ $produto->item_adicional == 'S' ? 'Sim' : 'Não' }}
                                </div>
                            </div>
                        </div>
                        <!-- Obrigar Item Adicional -->
                        <div class="col-12 col-lg-4">
                            <div class="rounde-3 p-3 dark:bg-gray-700 dark:text-gray-200  ">
                                <div class="fw-bold small">Obrigar Item Adicional:</div>
                                <div class="">
                                    {{ $produto->item_adicional_obrigar == 'S' ? 'Sim' : 'Não' }}
                                </div>
                            </div>
                        </div>
                        <!-- Item Adicional Multi -->
                        <div class="col-12 col-lg-4">
                            <div class="rounde-3 p-3 dark:bg-gray-700 dark:text-gray-200  ">
                                <div class="fw-bold small">Item Adicional Multi:</div>
                                <div class="">
                                    {{ $produto->item_adicional_multi == 'S' ? 'Sim' : 'Não' }}
                                </div>
                            </div>
                        </div>
                        <!-- Adicional Qtd. Mínima -->
                        <div class="col-12 col-lg-4">
                            <div class="rounde-3 p-3 dark:bg-gray-700 dark:text-gray-200  ">
                                <div class="fw-bold small">Adicional Qtd. Mínima:</div>
                                <div class="">
                                    {{ $produto->adicional_qtde_min ?? '-' }}
                                </div>
                            </div>
                        </div>
                        <!-- Adicional Qtd. Máxima -->
                        <div class="col-12 col-lg-4">
                            <div class="rounde-3 p-3 dark:bg-gray-700 dark:text-gray-200  ">
                                <div class="fw-bold small">Adicional Qtd. Máxima:</div>
                                <div class="">
                                    {{ $produto->adicional_qtde_max ?? '-' }}
                                </div>
                            </div>
                        </div>
                      
                        <!-- Adicional Junção -->
                        <div class="col-12 col-lg-4">
                            <div class="rounde-3 p-3 dark:bg-gray-700 dark:text-gray-200  ">
                                <div class="fw-bold small">Adicional Junção:</div>
                                <div class="">
                                    {{ $produto->adicional_juncao }}
                                </div>
                            </div>
                        </div>

                        <!-- Grupo de Adicional -->
                        <div class="col-12 col-lg-4">
                            <div class="rounde-3 p-3 dark:bg-gray-700 dark:text-gray-200  ">
                                <div class="fw-bold small">Grupo de Adicional:</div>
                                <div class="">
                                    @php
                                        $additionalGroup = \App\Models\AdditionalGroup::find($produto->grupo_adicional_id);
                                    @endphp
                                    {{ is_null($additionalGroup) ? '-' : $additionalGroup->nome }}
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-4 mb-3">
                            <div class="col-12">
                                <a href="{{ route('painel.lojista.produtos.index') }}" class="btn btn-primary bg-primary">
                                    Fechar
                                </a>
                                <a href="{{ route('painel.lojista.produtos.edit', $produto->id) }}" class="btn btn-success bg-success">
                                    Editar
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
