<!-- Escolha a borda -->
<div class="col-4 col-lg-4 col-bordas" id="borda">
    <div class="border overflow-hidden bg-light rounded-3 p-0 h-100 d-flex flex-column">
        <div class="p-3">
            <h2 class="h6 mb-3 text-center">
                Escolha a borda
            </h2>
            <hr>

            <div class="small text-muted">
                <!-- Sele -->
                *Selecione pelo menos
                <strong id="min-bordas">1</strong>
                borda <span id="texto-max-borda">
                    @if ($min_sabores > 1)
                        e no máximo <strong>{{ $min_sabores }}</strong>
                    @endif
                </span>
            </div>

            <ul class="list-group list-group-flush ">
                @foreach ($product->pizza_product->bordas as $key => $item)
                    <li class="list-group-item bg-light px-0 pt-3 sabores">
                        <div class="d-flex gap-2 ">

                            <div class="form-check d-flex gap-1">
                                <div class="pt-1">
                                    <input type="hidden" name="json_bordas[]" value='{{ str_replace("'", '', json_encode($item)) }}'>
                                    <input class="form-check-input check-borda" type="checkbox" name="bordas_key[]"
                                        id="edge{{ $key }}" data-valor="{{ $item['valor'] }}"
                                        value="{{ $key }}" onchange="selecionarBorda(this)">
                                </div>

                                <div class="me-2">
                                    <label for="edge{{ $key }}">
                                        <img src='{{ asset($item['imagem'] ?? 'assets/img/pizza/pizza-empty.png') }}'
                                            alt="" style="width: 50px; height: 50px;border-radius: 50%">
                                    </label>
                                </div>

                                <label class="form-check-label  justify-content-between" for="edge{{ $key }}">
                                    <h3 class="h6 fw-bold mb-0">{{ $item['borda'] }}</h3>
                                    <p class="small lh-sm mt-1 mb-1 pb-0">
                                        {{ Str::limit($item['descricao'], 50) }}
                                    </p>
                                </label>
                            </div>
                            <div class="fw-bold ms-auto">
                                <label for="edge{{ $key }}" class="class-valor valor-borda-dividido"
                                    data-valor-original="{{ $item['valor'] }}"
                                    data-valor-dividido="{{ $item['valor'] }}"
                                    data-valor="">{{ number_format($item['valor'], 2, ',', '.') }}</label>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
