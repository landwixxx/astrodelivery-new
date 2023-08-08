@extends('layouts.painel.app')
@section('title', 'Cadastrar grupo de adicional')
@section('head')

    <!-- Icons FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- Select2 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/i18n/pt-BR.js"></script>

@endsection
@section('content')
    <br>
    {{-- Alertas --}}
    <x-alerts />

    <div class="container-fluid px-6 mx-auto grid tipo-entrega">
        <br>

        <!-- Cadastrar grupo de adicional -->
        <div class="w-full overflow-hidden rounded-lg ">
            <h2 class="my-2 text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-1">
                Cadastrar grupo de adicional
            </h2>
            <p class="small dark:text-gray-200 mb-3 ">
                Campos com <strong class="text-danger">*</strong> são obrigatórios
            </p>

            <div class="card border dark:border-none bg-white">
                <div class="card-body">
                    <!-- Formulário -->
                    <form action="{{ route('painel.lojista.grupo-adicional.store') }}" method="post">
                        @csrf
                        <div class="row dark:text-gray-200 gy-4">

                            <!-- Nome -->
                            <div class="col-12 col-lg-4 col-xl-3 ">
                                <label for="nome" class="form-label fw-500">
                                    Nome<span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="@error('nome') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                    name="nome" id="nome" value="{{ old('nome') }}" required>
                                @error('nome')
                                    <div class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Descrição -->
                            <div class="col-12 col-lg-8 col-xl-9">
                                <label for="descricao" class="form-label fw-500">
                                    Descrição
                                </label>
                                <input type="text"
                                    class="@error('descricao') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                    name="descricao" id="descricao" value="{{ old('descricao') }}">
                                @error('descricao')
                                    <div class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Qtd. Mínima -->
                            <div class="col-12 col-lg-4 col-xl-3">
                                <label for="adicional_qtd_min" class="form-label fw-500">
                                    Qtd. Mínima
                                </label>
                                <input type="text"
                                    class="@error('adicional_qtd_min') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                    name="adicional_qtd_min" id="adicional_qtd_min" value="{{ old('adicional_qtd_min') }}">
                                @error('adicional_qtd_min')
                                    <div class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Qtd. Máxima -->
                            <div class="col-12 col-lg-4 col-xl-3">
                                <label for="adicional_qtd_max" class="form-label fw-500">
                                    Qtd. Máxima
                                </label>
                                <input type="text"
                                    class="@error('adicional_qtd_max') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                    name="adicional_qtd_max" id="adicional_qtd_max" value="{{ old('adicional_qtd_max') }}">
                                @error('adicional_qtd_max')
                                    <div class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Tipo: -->
                            <div class="col-12 col-lg-4 col-xl-3 ">
                                <label for="adicional_juncao" class="form-label fw-500">
                                    Junção<span class="text-danger">*</span>
                                </label>
                                <div class="">
                                    <select class="selecionar-adicional-juncao w-100" name="adicional_juncao" required>
                                        <!-- options -->
                                        @if (old('adicional_juncao'))
                                            <option value="{{ old('adicional_juncao') }}">{{old('adicional_juncao')}}</option>
                                        @endif
                                    </select>
                                </div>
                                @error('adicional_juncao')
                                    <div class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Ordem -->
                            <div class="col-12 col-lg-4 col-xl-3">
                                <label for="ordem" class="form-label fw-500">
                                    Ordem
                                </label>
                                <input type="text"
                                    class="@error('ordem') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                    name="ordem" id="ordem" value="{{ old('ordem') }}">
                                @error('ordem')
                                    <div class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Ordem interna -->
                            <div class="col-12 col-lg-6 col-xl-5">
                                <label for="ordem_interna" class="form-label fw-500">
                                    Ordem interna
                                </label>
                                <select class="selecionar-ondem-interna w-100" name="ordem_interna" required>
                                    <!-- options -->
                                    @if (old('ordem_interna'))
                                        <option value="{{ old('ordem_interna') }}"></option>
                                    @endif
                                </select>
                                @error('ordem_interna')
                                    <div class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary bg-primary px-4 mt-3 ">
                                    Cadastrar
                                </button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <div class="py-4"></div>



@endsection


@section('scripts')

    <script>
        /* Ativar popovers bootstrap */
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

        /* Select2 - Selecionar junção */
        $(document).ready(function() {
            $('.selecionar-adicional-juncao').select2({
                placeholder: 'Selecione uma opção',
                "language": "pt-BR",
                data: [{
                        id: 'SOMA',
                        text: 'SOMA',
                    },
                    {
                        id: 'DIVIDIR',
                        text: 'DIVIDIR',
                    },
                    {
                        id: 'MEDIA',
                        text: 'MEDIA',
                    },
                ],
            })
        });

        /* Select2 - ondem interna */
        $(document).ready(function() {
            $('.selecionar-ondem-interna').select2({
                placeholder: 'Selecione uma opção',
                "language": "pt-BR",
                data: [{
                        id: '',
                        text: 'Selecione uma opção',
                    },
                    {
                        id: 'VLR_DECR|NOME_CRES',
                        text: 'VLR_DECR|NOME_CRES',
                    },
                    {
                        id: 'VLR_CRES|NOME_CRES',
                        text: 'VLR_CRES|NOME_CRES',
                    },
                    {
                        id: 'NOME_CRES|VLR_CRES',
                        text: 'NOME_CRES|VLR_CRES',
                    },
                    {
                        id: 'NOME_CRES|VLR_DECR',
                        text: 'NOME_CRES|VLR_DECR',
                    },
                    {
                        id: 'SUBNOME_CRES|NOME_CRES|VLR_CRES',
                        text: 'SUBNOME_CRES|NOME_CRES|VLR_CRES',
                    },
                    {
                        id: 'SUBNOME_CRES|NOME_CRES|VLR_DECR',
                        text: 'SUBNOME_CRES|NOME_CRES|VLR_DECR',
                    },
                    {
                        id: 'CHAVE_CRES|NOME_CRES|VLR_CRES',
                        text: 'CHAVE_CRES|NOME_CRES|VLR_CRES',
                    },
                    {
                        id: 'CHAVE_CRES|NOME_CRES|VLR_DECR',
                        text: 'CHAVE_CRES|NOME_CRES|VLR_DECR',
                    },
                    {
                        id: 'CHAVE_CRES|VLR_CRES|NOME_CRES',
                        text: 'CHAVE_CRES|VLR_CRES|NOME_CRES',
                    },
                    {
                        id: 'CHAVE_CRES|VLR_DECR|NOME_CRES',
                        text: 'CHAVE_CRES|VLR_DECR|NOME_CRES',
                    },
                ],
            })
        });
    </script>

    <!-- Mascaras de input -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/imask/6.4.3/imask.min.js"></script>
    <script>
        var adicional_qtd_min = IMask(document.getElementById('adicional_qtd_min'), {
            mask: '000000000'
        });
        var adicional_qtd_max = IMask(document.getElementById('adicional_qtd_max'), {
            mask: '000000000'
        });
        var ordem = IMask(document.getElementById('ordem'), {
            mask: '000000000'
        });
    </script>

@endsection
