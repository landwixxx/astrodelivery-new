@extends('layouts.front.loja.app', ['store' => $store])
@section('titulo', 'Escolha o tamanho - ' . $store->nome)

@section('content')
    <div class="container py-5 mt-5 pt-4">

        <div class="col-lg-10 mx-auto">
            <x-alert-error />
            <h1 class="h4 mb-4 pb-2 text-dark pt-3">Monte sua Pizza</h1>
        </div>

        <!-- Montar pizza -->
        <div class="montar-pizza">
            <div class="">
                <form action="{{ route('loja.montar-pizza.tamanhos.salvar', $store->slug_url) }}" method="post"
                    onsubmit="return submitForm(event)">
                    <input type="hidden" name="sabores_id" value="" id="sabores_id">
                    @csrf
                    <div class="row gy-4 gx-lg-5 justify-content-center">

                        <!-- Prévia da pizza -->
                        <div class="col-12 col-lg-6" id="tamanho">
                            <div class="border overflow-hidden bg-light rounded-3 p-0 h-100 d-flex flex-column">
                                <div class="p-3">
                                    <h2 class="h6 mb-3 text-center">
                                        Prévia da Pizza
                                    </h2>
                                    <hr>
                                    @include('front.loja.montar_pizza._previa_pizza', [
                                        'montarPizza' => $montarPizza,
                                        'sabores' => $flavors,
                                    ])
                                </div>
                            </div>
                        </div>

                        <!-- Escolha um tamanho -->
                        <div class="col-12 col-lg-4" id="tamanho">
                            <div class="border overflow-hidden bg-light rounded-3 p-0 h-100 d-flex flex-column">
                                <div class="p-3">
                                    <h2 class="h6 mb-3 text-center">
                                        Escolha o tamanho
                                    </h2>
                                    <hr>
                                    <!-- Lista de tamanhos -->
                                    <ul class="list-group list-group-flush ">
                                        @foreach ($sizes as $key => $item)
                                            @php
                                                $session_tamanho_id = session('tamanho_id') ?? '';
                                            @endphp
                                            <li class="list-group-item bg-light px-0 pt-3 sabores">
                                                <div class="form-check d-flex">
                                                    <input class="form-check-input" type="radio" name="tamanho"
                                                        id="flavor{{ $key }}" value="{{ $item->id }}"
                                                        onchange="setValorTamanho()"
                                                        @if ($item->id == $session_tamanho_id) checked @endif>
                                                    <label class="form-check-label w-100 " for="flavor{{ $key }}">
                                                        <div class="d-flex gap-2 w-100">
                                                            <div class="">
                                                                <h3 class="h5 pt-1 fs-16px mb-0">{{ $item->tamanho }}</h3>
                                                            </div>
                                                            <div class="fw-bold ms-auto">
                                                                {{ number_format($item->valor, 2, ',', '.') }}
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                                <div class="mt-auto border-top mt-3 p-3 text-center">
                                    <button type="submit" class="btn btn-primary px-4">
                                        Avançar
                                        <i class="fa-solid fa-angles-right fa-sm fs-12px"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <!-- Prévia do tatal do valor -->
        <div class="col-lg-10 mx-auto  py-3 lh-sm text-end">
            <div class="fw-bold text-muted  lh-sm text-upspercase">Valor Total</div>
            <div class="fs-2 fw-bold text-danger lh-sm">
                <span class="fs-16px">R$</span> <span id="valor-total">0,00</span>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <!-- scripts loja -->
    <script src="{{ asset('assets/js/loja.js') }}"></script>

    <!-- Validar envio do formulario -->
    <script>
        function submitForm() {
            let selecionado = false
            let radios = document.getElementsByName('tamanho');
            for (let i = 0; i < radios.length; i++) {
                if (radios[i].checked) {
                    selecionado = true;
                    break;
                }
            }

            if (selecionado == false) {
                alert('Selecione um tamanho')
                return false;
            }
        }
    </script>
    <!-- Variáveis -->
    @php
        $valorBordas = \App\Models\Edge::whereIn('id', session('bordas_id') ?? [])->sum('valor');
        $valorBordas = $valorBordas / count(session('bordas_id') ?? [0]);
        $valorAdicionais = 0;
        if (isset(session('adicionais')['itens'])) {
            foreach (session('adicionais')['itens'] as $key => $item) {
                // produto adicional
                $pr123 = \App\Models\Product::find($item['id']);
                if ($pr123 != null) {
                    $valorAdicionais = $valorAdicionais + $item['qtd'] * $pr123->valor;
                }
            }
        }
        
    @endphp

    <script>
        var valorBordas = {{ $valorBordas }}
        var tamanhos = [];
        var valorTamanho = 0;
        var valorAdicionais = {{ $valorAdicionais }}
    </script>
    @foreach ($sizes as $item)
        <script>
            tamanhos[{{ $item->id }}] = @json($item)
        </script>
    @endforeach

    <script src="{{ asset('assets/js/monta-pizza.js') }}"></script>
    <script>
        function setValorTamanho() {
            tamanhoSelecionada = []
            let radios = document.getElementsByName('tamanho');
            for (let i = 0; i < radios.length; i++) {
                if (radios[i].checked) {
                    valorTamanho = tamanhos[radios[i].value].valor
                    valorTamanho = parseFloat(valorTamanho)
                    break;
                }
            }
            setValorTotal()
        }
        setValorTamanho()
    </script>

@endsection
