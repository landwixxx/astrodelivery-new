@extends('layouts.front.loja.app', ['store' => $store])
@section('titulo', 'Escolha os sabores - ' . $store->nome)

@section('content')
    <div class="container py-5 mt-5 pt-4">

        <div class="col-lg-10 mx-auto">
            <x-alert-error />
            <h1 class="h4 mb-4 pb-2 text-dark pt-3">Monte sua Pizza</h1>
        </div>

        <!-- Montar pizza -->
        <div class="montar-pizza">
            <div class="">
                <form action="{{ route('loja.montar-pizza.sabores.salvar', $store->slug_url) }}" method="post"
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
                                        'min_sabores' => $min_sabores,
                                        'max_sabores' => $max_sabores,
                                        'sabores' => $flavors,
                                    ])
                                </div>
                            </div>
                        </div>

                        <!-- Escolha os sabores -->
                        <div class="col-12 col-lg-4" id="tamanho">
                            <div class="border overflow-hidden bg-light rounded-3 p-0 h-100 d-flex flex-column">
                                <div class="p-3">
                                    <h2 class="h6 mb-3 text-center">
                                        Escolha os sabores
                                    </h2>
                                    <hr>

                                    <div class="small text-muted mb-2">
                                        *Selecione pelo menos <strong>{{ $min_sabores }}</strong> sabor
                                        @if ($max_sabores > 1)
                                            e no máximo <strong>{{ $max_sabores }}</strong>
                                        @endif
                                    </div>
                                    <!-- Lista de sabores -->
                                    <ul class="list-group list-group-flush ">
                                        @foreach ($flavors as $key => $item)
                                            @php
                                                $session_sabores = session('sabores_id') ?? [];
                                            @endphp
                                            <li class="list-group-item bg-light px-0 pt-3 sabores">
                                                <div class="form-check d-flex">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="sabores_id_nao_utilizar[]" id="flavor{{ $key }}"
                                                        value="{{ $item->id }}"
                                                        data-valor="{{$item->valor}}"
                                                        onchange="setSabor({{ $item }}, this)"
                                                        @if (in_array($item->id, $session_sabores)) checked @endif>
                                                    <label class="form-check-label w-100 " for="flavor{{ $key }}">
                                                        <div class="d-flex gap-2 w-100">
                                                            <div class="">
                                                                <img src='{{ asset($item->img ?? 'assets/img/pizza/pizza-empty.png') }}'
                                                                    alt=""
                                                                    style="width: 50px; height: 50px;border-radius: 50%">
                                                            </div>
                                                            <div class="">
                                                                <h3 class="h6 fw-bold mb-0">{{ $item->sabor }}</h3>
                                                                <p class="">
                                                                    {{ $item->descricao }}
                                                                </p>
                                                            </div>
                                                            <div class="fw-bold ms-auto" id="v-sabor-{{ $item->id }}">
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
                                    <a href="{{ route('loja.montar-pizza.tamanhos', ['slug_store' => $store->slug_url]) }}"
                                        class="btn btn-danger px-4">
                                        <i class="fa-solid fa-rotate-left fa-sm fs-12px"></i>
                                        Voltar
                                    </a>
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
        <!-- Prévia do total do valor -->
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
    <!-- Validar envio do formulário -->
    <script>
        function submitForm() {
            if (saboresSelecionados.length < {{ $min_sabores }}) {
                alert(
                    'Selecione pelo menos {{ $min_sabores }} {{ $min_sabores > 1 ? 'sabores' : 'sabor' }} '
                )
                return false;
            }
        }
    </script>

    <!-- Varáveis -->
    @php
        $valorBordas = \App\Models\Edge::whereIn('id', session('bordas_id') ?? [])->sum('valor');
        $valorBordas = $valorBordas / count(session('bordas_id') ?? [0]);
        $valorTamanho = \App\Models\Size::where('id', session('tamanho_id') ?? '')->sum('valor');
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
        var valorTamanho = {{ $valorTamanho }}
        var valorAdicionais = {{ $valorAdicionais }}
    </script>
    <script src="{{ asset('assets/js/monta-pizza.js') }}"></script>
    <script>
        
    </script>
@endsection
