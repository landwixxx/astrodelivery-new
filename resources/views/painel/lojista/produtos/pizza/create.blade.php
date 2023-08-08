@extends('layouts.painel.app')
@section('title', 'Criar Pizza')
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

    <div class="container-fluid px-4">
        <div class="px-lg-3">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <div class="container-fluid px-6 mx-auto grid dark:text-gray-200 mb-5 pb-5">
        <h2 class="my-2 text-2xl font-semibold text-gray-700 dark:text-gray-200 px-lg-3">
            Criar Pizza
        </h2>
        <p class="small dark:text-gray-200 mb-3 px-lg-3">
            Campos com <strong class="text-danger">*</strong> são obrigatórios
        </p>

        <div class="w-full overflow-x-auto px-lg-3">

            <form id="form-pizza" action="{{ route('painel.lojista.produtos.pizza.store') }}" method="post"
                enctype="multipart/form-data" target="" onsubmit="return validarCampos()">
                @csrf

                <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 sabores">
                    <div class="row gy-2 dark:text-gray-200 pb-2 ">
                        <div class="col-12">
                            <h2 class=" mb-0 fw-semibold h5 mb-2">Informações</h2>
                        </div>

                        <!-- imagem -->
                        <div class="col-12 col-lg-3 mb-3 ">
                            <div class=" overflow-hidden " style="max-width: 220px; max-height: 220px; min-height: 220px;">
                                <label for="img-principal" class="form-label position-relative">
                                    <span class="visually-hidden">Selecionar imagem</span>
                                    <img src="{{ asset('assets/img/img-prod-vazio.png') }}" alt=""
                                        id="img-principal-foto" class="w-100 rounded-3 img-pizza-product-previa "
                                        style="max-width: 220px; min-width: 220px; max-height: 220px; min-height: 220px;">
                                    <div
                                        class="rounded-3 position-absolute top-0 add-imgs-pizza-produto d-flex align-items-center justify-content-center">
                                        <span class="material-symbols-outlined fs-2 text-dark opacity-75">
                                            add_circle
                                        </span>
                                    </div>
                                </label>
                                <input type="file" class="d-none" name="imagem_prod[]" id="img-principal"
                                    onchange="setImgFileChange('img-principal', 'img-principal-foto')" accept="image/*">
                            </div>
                        </div>

                        <div class="col-12 col-lg-9">
                            <div class="row gy-3">

                                <!-- Título -->
                                <div class="col-12 col-lg-6 ">
                                    <label class=" form-label">Título<span class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                        name="nome" placeholder="" value="" maxlength="255" required>
                                </div>
                                <!-- Categoria: -->
                                <div class="col-12 col-lg-3">
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
                                <!-- Valor Mínimo -->
                                <div class="col-12 col-lg-3 ">
                                    <label class=" form-label">Valor Mínimo<span class="text-danger">*</span></label>
                                    <input type="text"
                                        class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                        name="valor_minimo" id="valor-minimo" placeholder="R$ 0,00"
                                        value="{{ old('valor_minimo') }}" maxlength="20" required>
                                    @error('valor_minimo')
                                        <div class="small text-danger"> {{ $message }} </div>
                                    @enderror
                                </div>
                                <!-- Descrição -->
                                <div class="col-12 ">
                                    <label class="form-label" for="descricao">Descrição</label>
                                    <textarea
                                        class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                        name="descricao" id="descricao" rows="3">{{ old('descricao') }}</textarea>
                                    @error('descricao')
                                        <div class="small text-danger"> {{ $message }} </div>
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
                                        class=" form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                        name="ordem" value="{{ old('ordem') }}" id="ordem">
                                    @error('ordem')
                                        <div class="text-danger small">
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
                                        class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                        name="codigo_empresa" id="codigo_empresa" value="{{ old('codigo_empresa') }}"
                                        maxlength="255">
                                    @error('codigo_empresa')
                                        <div class="text-danger small">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sabores -->
                @include('painel.lojista.produtos.pizza._form_create_sabores')

                <!-- Bordas -->
                @include('painel.lojista.produtos.pizza._form_create_bordas')

                <div class="">
                    <button type="submit" class="btn btn-primary bg-primary px-5 text-uppercase ">
                        Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal alert validações campos -->
    <div class="modal fade" id="modal-alerta-validacoes" tabindex="-1" data-bs-backdrop="static"
        data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered " role="document">
            <div class="modal-content bg-white rounded-lg shadow-md dark:bg-gray-800 ">
                <div class="modal-body pb-4 py-4">
                    <div class="fs-5 text-center dark:text-gray-200" id="msg-modal-alert">
                        <!-- msg -->
                    </div>
                    <div class="text-center pt-4 pb-1">
                        <button type="button" class="btn btn-secondary bg-secondary px-4"
                            data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')

    <script>
        function removerItem(el) {
            el.parentNode.parentNode.remove()
        }

        /* visualizar imagem */
        function setImgFileChange(id_input, id_img) {
            let e = document.getElementById(id_input)
            let files = e.files || e.dataTransfer.files;
            if (!files.length) {
                return
            }

            // add img
            let file = files[0];

            let reader = new FileReader()
            reader.onload = (e) => {
                document.getElementById(id_img).src = e.target.result
            }
            reader.readAsDataURL(file)
        }
    </script>

    <!-- Mascaras de input -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/imask/6.4.3/imask.min.js"></script>
    <script>
        function maskValor(el_id) {
            if (document.getElementById(el_id))
                IMask(
                    document.getElementById(el_id), {
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
        }

        function maskNumber(id) {
            if (document.getElementById(id))
                IMask(document.getElementById(id), {
                    mask: '00000000000'
                });
        }

        maskValor('valor-minimo')
        maskNumber('qtd-min')
        maskNumber('qtd-max')

        // valor inicial para sabores se não ouver nhm registro
        maskValor('valor_inicial')

        // se n tem registros de bordas
        maskValor('valor_inicial_borda')

        // validações
        function validarCampos() {
            let modalAlerta = new bootstrap.Modal(document.getElementById('modal-alerta-validacoes'))

            // se img principal foi selecionada
            if (document.getElementById("img-principal").files.length === 0) {
                document.getElementById('msg-modal-alert').innerText = 'A imagem principal é obrigatória'
                modalAlerta.show()
                return false
            }

            if (
                document.querySelectorAll('.class-sabores') &&
                document.querySelectorAll('.class-sabores').length > 0
            ) {} else {
                document.getElementById('msg-modal-alert').innerText = 'Adicione pelo menos um sabor.'
                modalAlerta.show()
                return false
            }

            if (document.getElementById('qtd-min').className.indexOf('is-invalid') != -1 ||
                document.getElementById('qtd-max').className.indexOf('is-invalid') != -1) {
                    return false
                }

                return true

        }
    </script>
    <script>
        /* Ativar popovers bootstrap */
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
    </script>
@endsection
