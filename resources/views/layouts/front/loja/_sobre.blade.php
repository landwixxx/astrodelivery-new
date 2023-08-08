<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvas-sobre"
    aria-labelledby="Enable both scrolling & backdrop">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="Enable both scrolling & backdrop">Sobre</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <p class="">
            {{ $store->descricao }}
        </p>

        <div class="">
            <div class="h6 fw-700">Endereço</div>
            <p class="">
                Rua {{ $store->rua }}, {{ $store->numero_end }} - {{ $store->bairro }}<br>
                {{ $store->cidade }} - {{ $store->uf }}<br>
                CEP: {{ $store->cep }}<br>
                @if ($store->ponto_referencia)
                    Ponto de referência: {{ $store->ponto_referencia }}<br>
                @endif
                @if ($store->complemento)
                    Complemento: {{ $store->complemento }}<br>
                @endif
            </p>
        </div>
    </div>
</div>
