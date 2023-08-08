@extends('layouts.painel.app')
@section('title', 'Editar forma de pagamento')
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

        <!-- Editar forma de pagamento -->
        <div class="w-full overflow-hidden rounded-lg ">
            <h2 class="my-2 text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-1">
                Editar forma de pagamento
            </h2>
            <p class="small dark:text-gray-200 mb-3 ">
                Campos com <strong class="text-danger">*</strong> são obrigatórios
            </p>

            <div class="card border dark:border-none bg-white">
                <div class="card-body">
                    <!-- Formulário -->
                    <form action="{{ route('painel.lojista.forma-de-pagamento.update', $paymentMethod->id) }}"
                        method="post">
                        @csrf
                        @method('PUT')
                        <div class="row dark:text-gray-200 gy-4">
                            <!-- Nome -->
                            <div class="col-12 col-lg-4 col-xl-4 ">
                                <label for="nome" class="form-label fw-500">
                                    Nome<span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="@error('nome') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                    name="nome" id="nome" value="{{ old('nome', $paymentMethod->nome) }}" required>
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
                                    name="descricao" id="descricao"
                                    value="{{ old('descricao', $paymentMethod->descricao) }}" maxlength="500">
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
                                        @if (old('tipo', $paymentMethod->tipo))
                                            <option value="{{ old('tipo', $paymentMethod->tipo) }}"></option>
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
                                    Ícone
                                </label>
                                <div class="">
                                    <select class="selecionar-icon w-100" name="icone" required>
                                        <!-- options -->
                                        @if (old('icone', $paymentMethod->icone))
                                            <option value="{{ old('icone', $paymentMethod->icone) }}"></option>
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
                                        @if (old('classe', $paymentMethod->classe))
                                            <option value="{{ old('classe', $paymentMethod->classe) }}"></option>
                                        @endif
                                    </select>
                                </div>
                                @error('classe')
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
                                            value="S" required @if (old('ativo', $paymentMethod->ativo) == 'S') checked @endif>
                                        <label class="form-check-label" for="ativo-sim">Sim</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="ativo" id="ativo-nao"
                                            value="N" @if (old('ativo', $paymentMethod->ativo) == 'N') checked @endif>
                                        <label class="form-check-label" for="ativo-nao">Não</label>
                                    </div>
                                </div>
                                @error('ativo')
                                    <div class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary bg-primary px-4 mt-3 ">
                                    Atualizar
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
                        id: 'far fa-money-bill-alt',
                        text: 'Dinheiro',
                        html: `<div class=''><i class="far fa-money-bill-alt me-1"></i> Dinheiro</div>`
                    },
                    {
                        id: 'fas fa-money-bill-alt',
                        text: 'Caminhão',
                        html: `<div class=''><i class="fas fa-money-bill-alt me-1"></i> Dinheiro</div>`
                    },
                    {
                        id: 'fas fa-credit-card',
                        text: 'Cartão',
                        html: `<div class=''><i class="fas fa-credit-card me-1"></i> Cartão</div>`
                    },
                    {
                        id: 'fab fa-cc-mastercard',
                        text: 'Cartão',
                        html: `<div class=''><i class="fab fa-cc-mastercard me-1"></i> Cartão</div>`
                    },
                    {
                        id: 'fab fa-cc-visa',
                        text: 'Cartão',
                        html: `<div class=''><i class="fab fa-cc-visa me-1"></i> Cartão</div>`
                    },
                    {
                        id: 'fas fa-hand-holding-usd',
                        text: 'Cartão',
                        html: `<div class=''><i class="fas fa-hand-holding-usd me-1"></i> Cartão</div>`
                    },
                    {
                        id: 'fas fa-barcode',
                        text: 'Boleto',
                        html: `<div class=''><i class="fas fa-barcode me-1"></i> Boleto</div>`
                    },
                    {
                        id: 'fas fa-cash-register',
                        text: 'Caixa',
                        html: `<div class=''><i class="fas fa-cash-register me-1"></i> Caixa</div>`
                    },
                    {
                        id: 'fab fa-pied-piper-pp',
                        text: 'Pp',
                        html: `<div class=''><i class="fab fa-pied-piper-pp me-1"></i> Pp</div>`
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
                        id: 'DINHEIRO',
                        text: 'DINHEIRO',
                        html: `<span>DINHEIRO</span>`
                    },
                    {
                        id: 'CARTAO',
                        text: 'CARTÂO',
                        html: `<span>CARTÂO</span>`
                    },
                    {
                        id: 'GATEWAY',
                        text: 'GATEWAY',
                        html: `<span>GATEWAY</span>`
                    },
                    {
                        id: 'BOLETO',
                        text: 'BOLETO',
                        html: `<span>BOLETO</span>`
                    },
                    {
                        id: 'OUTROS',
                        text: 'OUTROS',
                        html: `<span>OUTROS</span>`
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
                    {
                        id: 'success',
                        text: 'success',
                        html: `<div class='badge bg-success badge-success'>Success</div>`
                    },
                ],
            })
        });
    </script>

@endsection
