@extends('layouts.front.loja.app', ['store' => $store])
@section('titulo', 'Adicionais - ' . $store->nome)

@section('content')
    <div class="container py-5 mt-5 pt-4">

        <div class="col-lg-11 mx-auto">
            <x-alert-error />
            <h1 class="h4 mb-4 pb-2 text-dark pt-3">Adicionais</h1>
        </div>

        <!-- Montar pizza -->
        <div class="montar-pizza">
            <div class="">
                <form action="{{ route('loja.montar-pizza.adicionais.salvar', $store->slug_url) }}" method="post"
                    onsubmit="return submitForm(event)">
                    <input type="hidden" name="sabores_id" value="" id="sabores_id">
                    @csrf
                    <div class="row gy-4 gx-lg-5 justify-content-center">

                        <!-- Selecione os adicionais para sua Pizza -->
                        <div class="col-12 col-lg-11" id="tamanho">
                            <div class="border overflow-hidden bg-light rounded-3 p-0 h-100 d-flex flex-column">
                                <div class="p-3">
                                    <h2 class="h6 mb-3 text-center">
                                        Selecione os adicionais para sua Pizza
                                    </h2>
                                    <hr>

                                    <div class="small">
                                        *Clique em <strong>avançar</strong> se você não quiser selecionar nenhum
                                    </div>

                                    <!-- Adicionasi -->
                                    <div class="row gy-3 py-3">
                                        @if ($adicionais->count() == 0)
                                            <div class="col-12 text-center">
                                                <div class="h4 text-danger">Nenhum adicional para selecionar</div>
                                            </div>
                                        @endif
                                        @foreach ($adicionais as $key => $item)
                                            @php
                                                if ($item->adicional->limitar_estoque == 'S' && $item->adicional->estoque <= 0) {
                                                    continue;
                                                }
                                            @endphp
                                            <div class="col-12 col-lg-4 ">
                                                <div
                                                    class=" shadow-sm bg-white my-2 d-flex gap-1 p-3 align-items-center rounded">
                                                    <div class="adicionais w-100">
                                                        <input type="hidden" name="adicionais[{{ $key }}][id]"
                                                            value="{{ $item->adicional->id }}" class="additional_id">
                                                        <div class="d-flex gap-2 ">
                                                            <div class="">
                                                                <img src="{{ $item->adicional->img_destaque }}"
                                                                    alt="" class="" width="50"
                                                                    style="min-width: 50px; max-width: 50px">
                                                            </div>
                                                            <!-- Título -->
                                                            <div class="w-100">
                                                                <h3 class="fs-5 mb-1 fw-700">
                                                                    {{ $item->adicional->nome }}
                                                                </h3>
                                                                <p class="text-muted fs-14px lh-sm mb-0 pb-0">

                                                                    {{ Str::limit($item->adicional->descricao, 50) }}
                                                                </p>
                                                                <div class="d-flex justify-content-between gap-2 mt-2">
                                                                    <!-- Valor do adicional -->
                                                                    <div class="fw-bold text-danger">
                                                                        <span class="small">R$</span> <span
                                                                            class="fs-5">{{ number_format($item->adicional->valor, 2, ',', '.') }}</span>
                                                                    </div>
                                                                    <!-- Add mais -->
                                                                    <div class="">
                                                                        <div class="input-group input-group-sm item-adicionais input-group-sm"
                                                                            style="max-width: 75px">
                                                                            <!-- Subtrair -->
                                                                            <button type="button"
                                                                                onclick="subtrair_adicionar({{ $item->id }})"
                                                                                class="btn btn-light border d-flex align-items-center text-danger p-1 py-0">
                                                                                <i class="fa-solid fa-minus"></i>
                                                                            </button>
                                                                            @php
                                                                                // obter quantidade se já estivar adicionado
                                                                                $qtdAdicionada = 0;
                                                                                if (session('adicionais')) {
                                                                                    foreach (session('adicionais')['itens'] as $keyQtd => $valueQtd) {
                                                                                        if ($valueQtd['id'] == $item->adicional->id) {
                                                                                            $qtdAdicionada = $valueQtd['qtd'];
                                                                                            break;
                                                                                        }
                                                                                    }
                                                                                }
                                                                            @endphp
                                                                            <input type="text"
                                                                                data-valor="{{ $item->adicional->valor }}"
                                                                                class="form-control shadow-none text-center fs-6 py-0 qtd_adicional"
                                                                                value="{{ $qtdAdicionada }}"
                                                                                name="adicionais[{{ $key }}][qtd]"
                                                                                readonly id="qtd-id-{{ $item->id }}">
                                                                            @php
                                                                                $maxQtd = $item->adicional->estoque;
                                                                                if ($item->adicional->limitar_estoque == 'N') {
                                                                                    $maxQtd = 100000;
                                                                                }
                                                                            @endphp
                                                                            <button type="button"
                                                                                class="btn btn-light border d-flex align-items-center text-danger p-1 py-0"
                                                                                onclick="somar_adicionar({{ $item->id }}, {{ $maxQtd }})">
                                                                                <i class="fa-solid fa-plus"></i>
                                                                            </button>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                                <div class="mt-auto border-top mt-3 p-3 text-center">
                                    <a href="{{ route('loja.montar-pizza.bordas', ['slug_store' => $store->slug_url]) }}"
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
    <script>
        // var valorAdicionais= 0;
    </script>
    <script src="{{ asset('assets/js/monta-pizza.js') }}"></script>
    <script>
        // setValorTotal()

        function somar_adicionar(id, maxQtd) {
            // qtd-id-
            let el = document.getElementById('qtd-id-' + id)
            let qtd = el.value

            if (qtd >= maxQtd) {
                el.value = qtd
            } else {
                el.value = parseInt(qtd) + 1;
            }
            somarValores()
        }

        function subtrair_adicionar(id) {
            // qtd-id-
            let el = document.getElementById('qtd-id-' + id)
            let qtd = el.value

            if (qtd <= 0) {
                el.value = 0
            } else {
                el.value = parseInt(qtd) - 1;
            }

            somarValores()
        }

        var valorTotalAdicionais = 0;
        var valorTotal = {{ $valorTotal }}

        function somarValores() {
            valorTotalAdicionais = 0 + parseFloat(valorTotal)
            let inputs = document.querySelectorAll('.qtd_adicional');
            for (let i = 0; i < inputs.length; i++) {
                valorTotalAdicionais = valorTotalAdicionais + (inputs[i].value * parseFloat(inputs[i].dataset.valor))
                // console.log()
            }

            // console.log(valorTotalAdicionais);
            valorTotalAdicionais = parseFloat(valorTotalAdicionais).toFixed(2)
            document.getElementById('valor-total').innerHTML = moeda(valorTotalAdicionais)

        }

        somarValores()
    </script>
@endsection
