@extends('layouts.painel.app')
@section('title', 'Montar Pizza')
@section('head')
    <!-- scripts necessários para a lib select2 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/i18n/pt-BR.js"></script>
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
            Montar Pizza
        </h2>

        <div class="w-full overflow-x-auto px-lg-3">

            <form action="{{ route('painel.lojista.montar-pizza.salvar') }}" method="post" enctype="multipart/form-data">
                @csrf
                <!-- status -->
                <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="h5 fw-semibold">Status</h2>
                            <p class="mb-3 text-muted">
                                Altere o status para habilitar ou desabilitar opção para clientes montarem sua pizza
                            </p>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="ativo" value="ativo"
                                    @if (!is_null($montarPizza) && $montarPizza->status == 'ativo') checked @endif required>
                                <label class="form-check-label" for="ativo">
                                    Ativo
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" value="desativado"
                                    id="desativado" @if (!is_null($montarPizza) && $montarPizza->status == 'desativado') checked @endif>
                                <label class="form-check-label" for="desativado">
                                    Desativado
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Moontagem -->
                <div class="col-12 pb-0 mb-3 pt-2">
                    <div class="h6 fw-semibold py-0 pb-0 mb-0">Configurações</div>
                </div>

                <!-- Tamanhos -->
                @include('painel.lojista.montar_pizza._form_tamanhos', compact('tamanhos', 'montarPizza'))

                <!-- Sabores -->
                @include('painel.lojista.montar_pizza._form_sabores', compact('sabores', 'montarPizza'))

                <!-- Bordas -->
                @include('painel.lojista.montar_pizza._form_bordas', compact('bordas', 'montarPizza'))

                <!-- Adicionais -->
                @include(
                    'painel.lojista.montar_pizza._form_adicionais',
                    compact('tamanhos', 'montarPizza', 'adicionais'))

                <div class="">
                    <button type="submit" class="btn btn-primary bg-primary px-5 text-uppercase ">
                        Salvar
                    </button>
                </div>
            </form>
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
            IMask(document.getElementById(id), {
                mask: '00000000'
            });
        }
    </script>
    {{-- Macara para sabores --}}
    @if ($sabores->count() == 0)
        <script>
            // valor inicial para sabores se não ouver nhm registro
            maskValor('valor_inicial')
        </script>
    @endif

    @foreach ($sabores as $sabor)
        <script>
            maskValor("input-sabor-x{{ $sabor->id }}")
        </script>
    @endforeach

    {{-- Macara para bordas --}}
    @if ($bordas->count() == 0)
        <script>
            // se n tem registros de bordas
            maskValor('valor_inicial_borda')
        </script>
    @endif
    @foreach ($bordas as $borda)
        <script>
            maskValor("input-borda-x{{ $borda->id }}")
        </script>
    @endforeach

    {{-- Macara para tamanhos --}}
    @if ($tamanhos->count() == 0)
        <script>
            // se n tem registros de tamanhos
            maskValor('valor_inicial_tamanho')
            IMask(document.getElementById('tamanho-1'), {
                mask: '00000000'
            });
        </script>
    @endif
    @foreach ($tamanhos as $tamanho)
        <script>
            maskValor("input-tamanho-x{{ $tamanho->id }}")
            maskNumber("input-tamanho-qtd-x{{ $tamanho->id }}")
        </script>
    @endforeach
@endsection
