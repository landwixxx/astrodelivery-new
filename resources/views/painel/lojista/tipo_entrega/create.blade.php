@extends('layouts.painel.app')
@section('title', 'Cadastrar tipo de entrega')
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

        <!-- Cadastrar tipo de entrega -->
        <div class="w-full overflow-hidden rounded-lg ">
            <h2 class="my-2 text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-1">
                Cadastrar tipo de entrega
            </h2>
            <p class="small dark:text-gray-200 mb-3 ">
                Campos com <strong class="text-danger">*</strong> são obrigatórios
            </p>

            <div class="card border dark:border-none bg-white">
                <div class="card-body">
                    <!-- Formulário -->
                    <form action="{{ route('painel.lojista.tipo-de-entrega.store') }}" method="post">
                        @csrf
                        <div class="row dark:text-gray-200 gy-4">
                            <!-- Nome -->
                            <div class="col-12 col-lg-4 col-xl-4 ">
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

                            <!-- Descrição: -->
                            <div class="col-12 col-lg-4 col-xl-8 ">
                                <label for="descricao" class="form-label fw-500">
                                    Descrição
                                </label>
                                <input type="text"
                                    class="@error('descricao') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                    name="descricao" id="descricao" value="{{ old('descricao') }}" maxlength="500">
                                @error('descricao')
                                    <div class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Tipo: -->
                            <div class="col-12 col-lg-4 col-xl-3 ">
                                <label for="tipo" class="form-label fw-500">
                                    Tipo<span class="text-danger">*</span>
                                </label>
                                <div class="">
                                    <select class="selecionar-tipo w-100" name="tipo" required>
                                        <!-- options -->
                                        @if (old('tipo'))
                                            <option value="{{ old('tipo') }}"></option>
                                        @endif
                                    </select>
                                </div>
                                @error('tipo')
                                    <div class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!--Ícone: -->
                            <div class="col-12 col-lg-4 col-xl-3 ">
                                <label for="icone" class="form-label fw-500">
                                    Ícone<span class="text-danger">*</span>
                                </label>
                                <div class="">
                                    <select class="selecionar-icon w-100" name="icone" required>
                                        <!-- options -->
                                        @if (old('icone'))
                                            <option value="{{ old('icone') }}"></option>
                                        @endif
                                    </select>
                                </div>
                                @error('icone')
                                    <div class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <!--Esquema: -->
                            <div class="col-12 col-lg-4 col-xl-3 ">
                                <label for="classe" class="form-label fw-500">
                                    Esquema<span class="text-danger">*</span>
                                </label>
                                <div class="">
                                    <select class="selecionar-esquema w-100" name="classe" required>
                                        <!-- options -->
                                        @if (old('classe'))
                                            <option value="{{ old('classe') }}"></option>
                                        @endif
                                    </select>
                                </div>
                                @error('classe')
                                    <div class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <!-- Valor mínimo de pedido -->
                            <div class="col-12 col-lg-4 col-xl-3 ">
                                <label for="valor" class="form-label fw-500 d-flex gap-1 align-items-center">
                                    <div class="">
                                        Valor padrão para entrega<span class="text-danger">*</span>
                                    </div>
                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="popover"
                                        data-bs-trigger="hover focus"
                                        data-bs-content="Esse valor será inserido caso o CEP informado pelo cliente não seja encontrado nos registros de CEPs de entrega">
                                        <a href="#!"
                                            class="text-decoration-none link-primary d-flex align-items-center">
                                            <span class="material-symbols-outlined h6 m-0 p-0">
                                                help
                                            </span>
                                        </a>
                                    </span>

                                </label>
                                <input type="text"
                                    class="@error('valor') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                    name="valor" id="valor" placeholder="R$ 0,00" value="{{ session('valor') }}"
                                    required>
                                @error('valor')
                                    <div class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Valor mínimo de pedido -->
                            <div class="col-12 col-lg-4 col-xl-3 ">
                                <label for="valor_minimo" class="form-label fw-500 d-flex gap-1 align-items-center">
                                    <div class="">
                                        Valor mínimo de pedido<span class="text-danger">*</span>
                                    </div>
                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="popover"
                                        data-bs-trigger="hover focus"
                                        data-bs-content="Valor mínimo do pedido permitido para envio">
                                        <a href="#!"
                                            class="text-decoration-none link-primary d-flex align-items-center">
                                            <span class="material-symbols-outlined h6 m-0 p-0">
                                                help
                                            </span>
                                        </a>
                                    </span>

                                </label>
                                <input type="text"
                                    class="@error('valor_minimo') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                    name="valor_minimo" id="valor_minimo" placeholder="R$ 0,00"
                                    value="{{ session('valor_minimo') }}" required>
                                @error('valor_minimo')
                                    <div class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Prazo de entrega -->
                            <div class="col-12 col-lg-4 col-xl-3 ">
                                <label for="tempo" class="form-label fw-500 d-flex gap-1 align-items-center">
                                    Prazo de entrega
                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="popover"
                                        data-bs-trigger="hover focus"
                                        data-bs-content="Caso tenha um prazo para entrega, informa no formato hh:mm:ss">
                                        <a href="#!"
                                            class="text-decoration-none link-primary d-flex align-items-center">
                                            <span class="material-symbols-outlined h6 m-0 p-0">
                                                help
                                            </span>
                                        </a>
                                    </span>
                                </label>
                                <input type="text"
                                    class="@error('tempo') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                    name="tempo" id="tempo" placeholder="00:00:00"
                                    value="{{ old('tempo', '00:00:00') }}">
                                @error('tempo')
                                    <div class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!--Ativo: -->
                            <div class="col-12 col-lg-4 col-xl-3 ">
                                <label for="ativo" class="form-label fw-500">
                                    Ativo
                                </label>
                                <div class="">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="ativo" id="ativo-sim"
                                            value="S" required @if (old('ativo', 'S') == 'S') checked @endif>
                                        <label class="form-check-label" for="ativo-sim">Sim</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="ativo" id="ativo-nao"
                                            value="N" @if (old('ativo') == 'N') checked @endif>
                                        <label class="form-check-label" for="ativo-nao">Não</label>
                                    </div>
                                </div>
                                @error('ativo')
                                    <div class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Bloquear sem CEP -->
                            <div class="col-12 col-lg-4 col-xl-3 ">
                                <label for="bloquear-em-cep" class="form-label fw-500 d-flex gap-1 align-items-center">
                                    Bloquear sem CEP
                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="popover"
                                        data-bs-trigger="hover focus"
                                        data-bs-content="Somente para entrega envolvendo CEP. Se bloqueado, o pedido não pode ser feito se o CEP não for encontrado">
                                        <a href="#!"
                                            class="text-decoration-none link-primary d-flex align-items-center">
                                            <span class="material-symbols-outlined h6 m-0 p-0">
                                                help
                                            </span>
                                        </a>
                                    </span>
                                </label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="bloqueia_sem_cep"
                                            id="bloquear-sim" value="S" required
                                            @if (old('bloqueia_sem_cep') == 'S') checked @endif>
                                        <label class="form-check-label" for="bloquear-sim">Sim</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="bloqueia_sem_cep"
                                            id="bloquear-nao" value="N"
                                            @if (old('bloqueia_sem_cep', 'N') == 'N') checked @endif>
                                        <label class="form-check-label" for="bloquear-nao">Não</label>
                                    </div>
                                </div>
                                @error('tempo')
                                    <div class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Selecionar tipos de pagamento -->
                            <div class="col-12  ">
                                <label for="bloquear-em-cep" class="form-label fw-500 d-flex gap-1 align-items-center">
                                    Tipos de pagamento
                                </label>

                                <!-- métodos de pagamento -->
                                <div class="ps-3">
                                    @if ($paymentMethods->count() == 0)
                                        <a href="{{ route('painel.lojista.forma-de-pagamento.create') }}" class="text-primary text-decoration-underline">
                                            Cadastre um método de pagamento
                                        </a>
                                    @endif
                                    @foreach ($paymentMethods as $item)
                                        <label class="list-group-item my-1">
                                            <input class=" me-1" type="checkbox" name="metodos_pagamento[]"
                                                value="{{ $item->id }}">
                                            {{ $item->nome }}
                                        </label>
                                    @endforeach
                                    @error('metodos_pagamento.0')
                                        <div class="text-danger">
                                            Tipo de pagamento é obrigatório
                                        </div>
                                    @enderror
                                </div>

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


        /* Select2 - Selecionar icon */
        $(document).ready(function() {
            $('.selecionar-icon').select2({
                placeholder: 'Selecione uma opção',
                "language": "pt-BR",
                templateResult: function(d) {
                    return $(d.html);
                },
                templateSelection: function(d) {
                    return $(d.html);
                },
                data: [{
                        id: 'fas fa-motorcycle',
                        text: 'Moto',
                        html: `<div class=''><i class="fas fa-motorcycle me-1"></i> Moto</div>`
                    },
                    {
                        id: 'fas fa-truck',
                        text: 'Caminhão',
                        html: `<div class=''><i class="fas fa-truck me-1"></i> Caminhão</div>`
                    },
                    {
                        id: 'fas fa-truck-loading',
                        text: 'Caminhão',
                        html: `<div class=''><i class="fas fa-truck-loading me-1"></i> Caminhão</div>`
                    },
                    {
                        id: 'fas fa-car-side',
                        text: 'Carro',
                        html: `<div class=''><i class="fas fa-car-side me-1"></i> Carro</div>`
                    },
                    {
                        id: 'fas fa-truck-pickup',
                        text: 'Pickup',
                        html: `<div class=''><i class="fas fa-truck-pickup me-1"></i> Pickup</div>`
                    },
                    {
                        id: 'fab fa-bootstrap',
                        text: 'Balcão',
                        html: `<div class=''><i class="fab fa-bootstrap me-1"></i> Balcão</div>`
                    },
                ],
            })
        });

        /* Select2 - Selecionar tipo */
        $(document).ready(function() {
            $('.selecionar-tipo').select2({
                placeholder: 'Selecione uma opção',
                "language": "pt-BR",
                templateResult: function(d) {
                    return $(d.html);
                },
                templateSelection: function(d) {
                    return $(d.html);
                },
                data: [{
                        id: 'Balcão',
                        text: 'Balcão',
                        html: `<span>Balcão</span>`
                    },
                    {
                        id: 'Delivery',
                        text: 'Delivery',
                        html: `<span>Delivery</span>`
                    },
                    {
                        id: 'Mesa',
                        text: 'Mesa',
                        html: `<span>Mesa</span>`
                    },
                    {
                        id: 'Correios',
                        text: 'Correios',
                        html: `<span>Correios</span>`
                    },
                ],
            })
        });

        /* Select2 - Selecionar esquema */
        $(document).ready(function() {
            $('.selecionar-esquema').select2({
                placeholder: 'Selecione uma opção',
                "language": "pt-BR",
                templateResult: function(d) {
                    return $(d.html);
                },
                templateSelection: function(d) {
                    return $(d.html);
                },
                data: [{
                        id: 'primary',
                        text: 'primary',
                        html: `<div class='badge bg-primary badge-primary'>Primary</div>`
                    },
                    {
                        id: 'secondary',
                        text: 'secondary',
                        html: `<div class='badge bg-secondary badge-secondary'>Secondary</div>`
                    },
                    {
                        id: 'warning',
                        text: 'warning',
                        html: `<div class='badge bg-warning badge-warning'>Warning</div>`
                    },
                    {
                        id: 'danger',
                        text: 'danger',
                        html: `<div class='badge bg-danger badge-danger'>Danger</div>`
                    },
                    {
                        id: 'dark',
                        text: 'dark',
                        html: `<div class='badge bg-dark badge-dark'>Dark</div>`
                    },
                ],
            })
        });
    </script>

    <!-- Mascaras de input -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/imask/6.4.3/imask.min.js"></script>
    <script>
        var tempo = IMask(document.getElementById('tempo'), {
            mask: '00:00:00'
        });

        var valor = IMask(document.getElementById('valor'), {
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
        });

        var valor_minimo = IMask(document.getElementById('valor_minimo'), {
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
        });

        var cep_origem = IMask(document.getElementById('cep_origem'), {
            mask: [{
                    mask: '00000-000'
                },
                {
                    mask: '00.000-000'
                }
            ]
        });

        document.querySelector('#tempo').onblur = function() {
            if (this.value == '') {
                this.value = '00:00:00'
            }
            let len = this.value.length
            if (len < 8)
                this.value += '00:00:00'.substr(len, 10)
        }
    </script>

@endsection
