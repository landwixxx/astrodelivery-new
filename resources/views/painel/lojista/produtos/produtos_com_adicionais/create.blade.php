@extends('layouts.painel.app')
@section('title', 'Inserir adicional em produto')
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

    <div class="container-fluid px-6 mx-auto grid mb-5 pb-5 tipo-entrega">
        <h2 class="my-2 text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-1">
            Inserir adicional em produto
        </h2>

        <div class="card border dark:border-none bg-white">
            <div class="card-body">
                <!-- Formulario -->
                <form action="{{ route('painel.lojista.produtos-com-adicionais.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row dark:text-gray-200">

                        <!-- Selecinar produto -->
                        <div class="col-12 col-lg-4 mb-4 mt-4">
                            <h2 class="h5 fw-bold mb-3">Produto</h2>

                            <!-- Select usando select2 -->
                            <div class="mb-3  col-12 div-listar-produtos">
                                <select id="listar-produtos"
                                    class="form-select py-2 px-3 input-light-custom rounded-pill text-muted fs-16px "
                                    name="product_id" style="width:100%" required></select>
                            </div>
                            @error('product_id')
                                <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror

                            <!-- Produto selecionado -->
                            <div class="" id="produto-selecionado" style="display:none">
                                <div class=" mb-2 small text-muted">Produto selecionado</div>
                                <div class="">
                                    <img src="{{ asset('assets/img/ilu-pizza.png') }}" alt="" class="w-75 rounded"
                                        id="img-produto">
                                    <h2 class="fs-5 fw-semibold mt-2" id="nome-produto">
                                        <!-- nome produtos -->
                                    </h2>
                                    <p class="" id="descricao-produto">
                                        <!-- descrião produto -->
                                    </p>
                                    <div class="fw-bold text-danger fs-5 mt-2" id="valor-produto">
                                        <!-- valor produto -->
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-12 col-lg-8">
                            <div class="row">

                                <!-- Selecionar grupo de adicional -->
                                <div class="col-12 col-lg-12 mb-4 mt-4">
                                    <h2 class="h5 fw-bold mb-3">Grupo de adicional</h2>

                                    <!-- Select usando select2 -->
                                    <div class="mb-3  col-12">
                                        <select id="listar-grupo-adicional"
                                            class="form-select py-2 px-3 input-light-custom rounded-pill text-muted fs-16px "
                                            name="listar_grupo_adicional" style="width:100%"></select>
                                    </div>
                                    @error('grupo-adicional_id.0')
                                        <div class="text-danger mb-3">{{ $message }}</div>
                                    @enderror

                                </div>

                                <!-- Selecionar adicional -->
                                <div class="col-12 col-lg-12 mb-4 mt-4">
                                    <h2 class="h5 fw-bold mb-3">Adicionais</h2>

                                    <!-- Select usando select2 -->
                                    <div class="mb-3  col-12">
                                        <select id="listar-adicionais"
                                            class="form-select py-2 px-3 input-light-custom rounded-pill text-muted fs-16px "
                                            name="listar_adicional" style="width:100%" disabled></select>
                                    </div>
                                    @error('adicionais_id.0')
                                        <div class="text-danger mb-3">{{ $message }}</div>
                                    @enderror

                                    <!-- Adicionais selecionados -->
                                    <div class="" id="adicionais-selecionados" style="display: none">
                                        <div class=" mb-2 small text-muted">Adicionais selecionados</div>
                                        <div class="row g-4" id="todos-adicionais-selecionado">
                                            <!-- Adicionais selecionados -->
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-12 mt-4 mb-3">
                            <div class="col-md-4 col-lg-2">
                                <button type="submit" class="btn btn-primary bg-primary w-100">
                                    Salvar
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

    <script>
        /* Add html de para add mais imagens */
        $(document).on('ready', function() {
            document.getElementById('select2-listar-produtos-container').innerText = 'Pesquisar produto'
            document.getElementById('select2-listar-adicionais-container').innerText = 'Pesquisar adicional'
            document.getElementById('select2-listar-grupo-adicional-container').innerText =
                'Pesquisar grupo de adicional'
        })
    </script>

    <!-- Script Select2 -->
    <script>
        /* Selecionar produto */
        $('#listar-produtos').select2({
            placeholder: 'Pesquisar produto',
            "language": "pt-BR",
            templateResult: function(d) {
                return $(d.html);
            },
            ajax: {
                url: "{{ route('painel.lojista.produtos-com-adicionais.json-produtos') }}",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                img_destaque: item.img_destaque,
                                valor: item.valor,
                                descricao: item.descricao,
                                nome: item.nome,
                                text: item.nome,
                                html: `<div class='d-flex gap-2 align-itedms-center'>
                                        <div><img src="${item.img_destaque}" class=' mt-2' style="width: 50px; min-width: 50px"></div>
                                        <span class='fw-bold'>${item.nome}
                                            <div class='text-muted small fw-normal'>
                                                ${strLimit(item.descricao)}
                                            </div>
                                        </span>
                                    </div>`,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        }).on("select2:select", function(e) { // Ação após seleciona item

            let produto = e.params.data;

            // Add text no select
            setTimeout(() => {
                document.getElementById('select2-listar-produtos-container').innerText = 'Pesquisar produto'
            }, 10);

            document.getElementById('produto-selecionado').style.display = 'block'
            document.getElementById('nome-produto').innerText = produto.nome
            document.getElementById('descricao-produto').innerText = strLimit(produto.descricao, 120)
            document.getElementById('valor-produto').innerText = moeda(produto.valor)
            document.getElementById('img-produto').src = produto.img_destaque
        });

        var ultimo_item_selecionado = null;
        var grupo_adicional_id = null;

        /* Selecionar adicinal */
        $('#listar-adicionais').select2({
            placeholder: 'Pesquisar adicional',
            "language": "pt-BR",
            templateResult: function(d) {
                return $(d.html);
            },
            ajax: {
                url: "{{ route('painel.lojista.produtos-com-adicionais.json-adicionais') }}",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        grupo_adicional_id: grupo_adicional_id
                    };
                },
                processResults: function(data) {
                    console.log(data)
                    return {
                        results: $.map(data, function(item) {
                            return {
                                img_destaque: item.img_destaque,
                                valor: item.valor,
                                descricao: item.descricao,
                                nome: item.nome,
                                text: item.nome,
                                html: `<div class='d-flex gap-2 align-itedms-center'>
                                        <div><img src="${item.img_destaque}" class=' mt-2' style="width: 50px; min-width: 50px"></div>
                                        <span class='fw-bold'>${item.nome}
                                            <div class='text-muted small fw-normal'>
                                                ${strLimit(item.descricao)}
                                            </div>
                                        </span>
                                    </div>`,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        }).on("select2:select", function(e) { // Ação após seleciona item

            let adicional = e.params.data;

            // Add text no select
            setTimeout(() => {
                document.getElementById('select2-listar-adicionais-container').innerText =
                    'Pesquisar adicional'
                document.getElementById('listar-adicionais').value = ''
            }, 10);


            // exibir text itens
            document.getElementById('adicionais-selecionados').style.display = 'block'

            // se adicional já foi selecionado
            if ($('#adicional-' + adicional.id).length) {
                alert('O adicional já foi seleciondo')
                return;
            }
            let html_adicional =
                `<div class="col-12 col-lg-6" id="adicional-${adicional.id}">
                    <input type="hidden" name="adicionais_id[]" value="${adicional.id}">
                    <div class="h-100 border rounded-3 p-3 pb-2 position-relative" style="border-color: rgba(150,150,150, .3) !important">
                    <button type="button" class="position-absolute text-danger" style="top:2px; right:2px" 
                    onclick="this.parentNode.parentNode.remove();document.getElementById('listar_produtos').value='';">
                        <span class="material-symbols-outlined">
                        close
                        </span>
                    </button>
                    <div class="d-flex gap-1 py-2">
                        <div class="me-2">
                            <img class="rounded" src="${adicional.img_destaque}" alt="imagem_produto" width="80" style="max-width:80px; min-width: 80px">
                        </div>
                        <div class="w-100">
                            <h3 class="fs-18px fw-bold mb-0 pb-0">${adicional.nome}</h3>
                            <p class="small">${strLimit(adicional.descricao, 70)}</p>
                            <div class="text-end mt-2 d-flex justify-content-between">
                                <div class="small fw-bold text-success">
                                    <span class="" style="font-size:18px">${moeda(adicional.valor)}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                </div>`

            $('#todos-adicionais-selecionado').append(html_adicional)

        });

        /* Selecionar grupo adicinal */
        $('#listar-grupo-adicional').select2({
            placeholder: 'Pesquisar grupo de adicional',
            "language": "pt-BR",
            templateResult: function(d) {
                return $(d.html);
            },
            ajax: {
                url: "{{ route('painel.lojista.produtos-com-adicionais.json-grupo-adicionais') }}",
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                nome: item.nome,
                                text: item.nome,
                                html: `<div class='d-flex gap-2 align-itedms-center'>
                                        <span class='fw-bold'>${item.nome}
                                            <div class='text-muted small fw-normal'>
                                                ${strLimit(item.descricao)}
                                            </div>
                                        </span>
                                    </div>`,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        }).on("select2:select", function(e) { // Ação após seleciona item
            document.getElementById('listar-adicionais').disabled = false
            // add id do grupo
            grupo_adicional_id = document.getElementById('listar-grupo-adicional').value
        });
    </script>
@endsection
