@extends('layouts.front.loja.app', ['store' => $store])
@section('titulo', 'Escolha os sabores - ' . $store->nome)

@section('head')
    <style>
        /* html,
                                                body {
                                                    background: #222
                                                }

                                                .bg-light {
                                                    background: #222 !important;
                                                    color: white
                                                } */

        .valor-total-pizza {
            background: white;
            box-shadow: 0 0 1.5rem rgba(0, 0, 0, .2)
        }

        @media (min-width: 992px) {
            .col-previa {
                width: 40%
            }

            .col-sabores {
                width: 30%
            }

            .col-bordas {
                width: 30%
            }
        }
    </style>
@endsection

@section('content')
    <div class="container py-5 mt-5 pt-4">

        <div class="col-lg-12 mx-auto">
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
                    <div class="row gy-4 gx-lg-3 justify-content-scenter">

                        <!-- Prévia da pizza -->
                        <div class="col-12 col-lg-4 col-previa" id="previa">
                            <div class="border overflow-hidden bg-light rounded-3 p-0  d-flex flex-column">
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
                        <div class="col-12 col-lg-4 col-sabores" id="tamanho">
                            <div class="border overflow-hidden bg-light rounded-3 p-0 h-100 d-flex flex-column">
                                <div class="p-3">
                                    <h2 class="h6 mb-3 text-center">
                                        Escolha os sabores
                                    </h2>
                                    <hr>

                                    <div class="mb-2 text-cesnter">
                                        <div class="mb-2">Total de sabores:</div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="total" id=""
                                                value="{3:option1}">
                                            <label class="form-check-label" for="">1</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="total" id=""
                                                value="option2">
                                            <label class="form-check-label" for="">2</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="total" id=""
                                                value="option3">
                                            <label class="form-check-label" for="">3</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="total" id=""
                                                value="option4" checked>
                                            <label class="form-check-label" for="">4</label>
                                        </div>
                                    </div>

                                    <ul class="list-group list-group-flush ">
                                        @foreach ([3, 3, 3, 3] as $key => $item)
                                            @if ($key == 1)
                                                <li class="list-group-item bg-light px-0 pt-3 sabores">
                                                    {{ $key + 1 }}º Sabor
                                                    <div class=" d-flex mt-2">
                                                        <div class=" w-100" for="flavor{{ $key }}">
                                                            <div class="d-flex gap-2 w-100">
                                                                <div class="">
                                                                    <img src='{{ asset($item->img ?? 'assets/img/pizza/pizza-empty.png') }}'
                                                                        alt=""
                                                                        style="width: 50px; height: 50px;border-radius: 50%">
                                                                </div>
                                                                <div class="">
                                                                    <h3 class="h6 fw-bold mb-0">Chocolate</h3>
                                                                    <p class="small lh-sm mt-1">
                                                                        Lorem ipsum dolor sit amet consectetur adipisicing
                                                                        elit.
                                                                    </p>
                                                                </div>
                                                                <div class="fw-bold ms-auto" id="v-sabor-">
                                                                    {{ number_format(20, 2, ',', '.') }}
                                                                </div>
                                                            </div>
                                                            <button type="button"
                                                                class="btn btn-sm btn-warning rounded-1 fw-semibold gap-1 d-flex align-items-center pb-0 ">
                                                                Alterar
                                                                <i class="fa-solid fa-rotate fa-sm"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </li>
                                            @else
                                                <li class="list-group-item bg-light px-0 pt-3 sabores">
                                                    {{ $key + 1 }}º Sabor
                                                    <div class="mt-2">
                                                        <button type="button"
                                                            class="btn btn-sm fw-semibold btn-outline-primary rounded-1 gap-1 d-flex align-items-center pb-0 ">
                                                            Selecionar
                                                        </button>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>

                                    <!-- Lista de sabores -->
                                    <ul class="list-group list-group-flush d-none ">
                                        @foreach ($flavors as $key => $item)
                                            @php
                                                $session_sabores = session('sabores_id') ?? [];
                                            @endphp
                                            <li class="list-group-item bg-light px-0 pt-3 sabores">
                                                <div class="form-check d-flex">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="sabores_id_nao_utilizar[]" id="flavor{{ $key }}"
                                                        value="{{ $item->id }}" data-valor="{{ $item->valor }}"
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
                            </div>
                        </div>

                        <!-- Escolha a borda -->
                        <div class="col-12 col-lg-4 col-bordas" id="borda">
                            <div class="border overflow-hidden bg-light rounded-3 p-0 h-100 d-flex flex-column">
                                <div class="p-3">
                                    <h2 class="h6 mb-3 text-center">
                                        Escolha a borda
                                    </h2>
                                    <hr>

                                    <div class="small text-muted">
                                        *Selecione pelo menos
                                        <strong>1</strong>
                                        {{ 1 > 1 ? 'bordas' : 'borda' }}
                                        @if (1 > 1)
                                            e no máximo
                                            <strong>3</strong>
                                        @endif
                                    </div>

                                    <ul class="list-group list-group-flush ">
                                        @foreach ([3, 3, 3, 3] as $key => $item)
                                            <li class="list-group-item bg-light px-0 pt-3 sabores">
                                                <div class="d-flex gap-2 ">

                                                    <div class="form-check d-flex gap-1">
                                                        <div class="pt-1">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="bordas[]" id="edge{{ $key }}">
                                                        </div>

                                                        <div class="me-2">
                                                            <label for="edge{{ $key }}">
                                                                <img src='{{ asset($item->img ?? 'assets/img/pizza/pizza-empty.png') }}'
                                                                    alt=""
                                                                    style="width: 50px; height: 50px;border-radius: 50%">
                                                            </label>
                                                        </div>

                                                        <label class="form-check-label  justify-content-between"
                                                            for="edge{{ $key }}">
                                                            <h3 class="h6 fw-bold mb-0">Borda chocolate</h3>
                                                            <p class="small lh-sm mt-1 mb-1 pb-0">
                                                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                            </p>
                                                        </label>
                                                    </div>
                                                    <div class="fw-bold ms-auto">
                                                        <label for="edge{{ $key }}" class="class-valor"
                                                            data-valor="22">{{ number_format(22, 2, ',', '.') }}</label>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <!-- Lista de sabores -->
                                    <ul class="list-group list-group-flush d-none ">
                                        @foreach ($flavors as $key => $item)
                                            @php
                                                $session_sabores = session('sabores_id') ?? [];
                                            @endphp
                                            <li class="list-group-item bg-light px-0 pt-3 sabores">
                                                <div class="form-check d-flex">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="sabores_id_nao_utilizar[]" id="flavor{{ $key }}"
                                                        value="{{ $item->id }}" data-valor="{{ $item->valor }}"
                                                        onchange="setSabor({{ $item }}, this)"
                                                        @if (in_array($item->id, $session_sabores)) checked @endif>
                                                    <label class="form-check-label w-100 "
                                                        for="flavor{{ $key }}">
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
                                                            <div class="fw-bold ms-auto"
                                                                id="v-sabor-{{ $item->id }}">
                                                                {{ number_format($item->valor, 2, ',', '.') }}
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Prévia do total do valor -->
    <div class=" lh-sm fixed-bottom valor-total-pizza" style="z-index: 1">
        <div class="container py-3">
            <div
                class="d-flex flex-column flex-lg-row gap-2 gap-lg-5 align-items-lg-end justify-content-start justify-content-lg-center ">
                <div class="text-start">
                    <div class="fw-bold text-muted  lh-1 fs-12px">Valor Total</div>
                    <div class="fs-2 fw-bold text-danger lh-1">
                        <span class="fs-16px">R$</span> <span id="valor-total">0,00</span>
                    </div>
                </div>
                <div class="">
                    <button type="submit" class="btn btn-outline-danger fw-600 pb-1">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-cart-plus fa-sm me-1"></i>
                            Adicionar ao Carrinho
                        </div>
                    </button>
                </div>
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
    <script></script>
@endsection
