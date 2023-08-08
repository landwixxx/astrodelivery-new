@extends('layouts.front.loja.app', ['store' => $store])
@section('titulo', 'Escolha a borda - ' . $store->nome)

@section('content')
    <div class="container py-5 mt-5 pt-4">

        <div class="col-lg-10 mx-auto">
            <x-alert-error />
            <h1 class="h4 mb-4 pb-2 text-dark pt-3">Monte sua Pizza</h1>
        </div>

        <!-- Montar pizza -->
        <div class="montar-pizza">
            <div class="">
                <form action="{{ route('loja.montar-pizza.bordas.salvar', $store->slug_url) }}" method="post"
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

                        <!-- Escolha a borda -->
                        <div class="col-12 col-lg-4" id="bordas">
                            <div class="border overflow-hidden bg-light rounded-3 p-0 h-100 d-flex flex-column">
                                <div class="p-3">
                                    <h2 class="h6 mb-3 text-center">
                                        Escolha a borda
                                    </h2>
                                    <hr>

                                    <div class="small text-muted mb-2">
                                        *Selecione pelo menos
                                        <strong>{{ $min_bordas }}</strong>
                                        {{ $min_bordas > 1 ? 'bordas' : 'borda' }}
                                        @if ($max_bordas > 1)
                                            e no máximo
                                            <strong>{{ $max_bordas }}</strong>
                                        @endif
                                    </div>

                                    <!-- Lista de bordas -->
                                    <ul class="list-group list-group-flush ">
                                        @foreach ($edges as $key => $item)
                                            @php
                                                $session_bordas = session('bordas_id') ?? [];
                                            @endphp
                                            <li class="list-group-item bg-light px-0 py-2">
                                                <div class="d-flex gap-2">

                                                    <div class="form-check d-flex gap-1">
                                                        <div class="pt-1">
                                                            <input class="form-check-input" type="checkbox" name="bordas[]"
                                                                id="edge{{ $key }}" value="{{ $item->id }}"
                                                                onchange="getValorBorda(this)"
                                                                @if (in_array($item->id, $session_bordas)) checked @endif>
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
                                                            <h3 class="h6 fw-bold mb-0">{{ $item->borda }}</h3>
                                                            <p class="">
                                                                {{ $item->descricao }}
                                                            </p>
                                                        </label>
                                                    </div>
                                                    <div class="fw-bold ms-auto">
                                                        <label for="edge{{ $key }}" class="class-valor"
                                                            data-valor="{{ $item->valor }}">{{ number_format($item->valor, 2, ',', '.') }}</label>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="mt-auto border-top mt-3 p-3 text-center">
                                    <a href="{{ route('loja.montar-pizza.sabores', ['slug_store' => $store->slug_url]) }}"
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
        <!-- Prévia do valor total -->
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
    <!-- Variáveis -->
    <script>
        var bordas = [];
        var bordasSelecionadas = [];
        var valorBordas = 0;
        var idBordaSelecionada = null
    </script>
    @php
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
        var valorTamanho = {{ $valorTamanho }}
        var valorAdicionais = {{ $valorAdicionais }}
    </script>

    @foreach ($edges as $item)
        <script>
            bordas[{{ $item->id }}] = @json($item)
        </script>
    @endforeach

    @if (session('bordas_id'))
        <script>
            bordasSelecionadas = @json(session('bordas_id') ?? [])
        </script>
    @endif

    <!-- Validar enviar de formulário -->
    <script>
        function submitForm() {
            if (bordasSelecionadas.length < {{ $min_bordas }}) {
                alert(
                    'Selecione pelo menos {{ $min_bordas }} {{ $min_bordas > 1 ? 'bordas' : 'borda' }} '
                )
                return false;
            }
        }
    </script>
    <script src="{{ asset('assets/js/monta-pizza.js') }}"></script>
    <script>
        /* dividir os valores das bordas deacordo com o total selecionado */
        function atuzlizarValoresDivididos(totalSelecionados) {
            // class-valor
            let el_valores = document.querySelectorAll('.class-valor')

            totalSelecionados = totalSelecionados == 0 ? 1 : totalSelecionados;

            let porcentagem = parseInt((100 / totalSelecionados) * 1)
            // alert(porcentagem)

            for (let i = 0; i < el_valores.length; i++) {

                // el_valores[i].innerHTML= novo_valor;
                let valor_original = el_valores[i].dataset.valor
                let novo_valor = parseFloat(el_valores[i].dataset.valor) / totalSelecionados;
                novo_valor= parseFloat(novo_valor.toFixed(2))
                let textPorcentagem = totalSelecionados > 1 ? ` - ${porcentagem}%` : ''
                console.log(novo_valor);
                let novo_valor_text = parseFloat(novo_valor).toLocaleString('pt-br', {
                    minimumFractionDigits: 2
                });
                el_valores[i].innerHTML = novo_valor_text + textPorcentagem
                // console.log(el_valores[i].dataset.valor);
            }
        }

        // Ober valor da borda selecionada
        function getValorBorda(el_checkbox = null) {

            if (el_checkbox != null && el_checkbox.checked == true && bordasSelecionadas.length >=
                {{ $max_bordas }}) {
                el_checkbox.checked = false
                alert(
                    'Você pode selecionar no máximo {{ $max_bordas }} {{ $max_bordas > 1 ? 'bordas' : 'borda' }} '
                )
                return;
            }

            bordasSelecionadas = []
            let totalCheckboxSelecionados = 0
            let radios = document.getElementsByName('bordas[]');
            for (let i = 0; i < radios.length; i++) {
                if (radios[i].checked) {
                    bordasSelecionadas.push(radios[i].value)
                    totalCheckboxSelecionados++
                }
            }

            valorBordas = 0
            bordasSelecionadas.forEach(idBorda => {
                let bordaValor = parseFloat(bordas[idBorda].valor) / totalCheckboxSelecionados
                valorBordas = valorBordas + bordaValor
            });
            atuzlizarValoresDivididos(totalCheckboxSelecionados)
            setValorTotal()
        }
        getValorBorda()
    </script>

@endsection
