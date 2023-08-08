<div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 tamanhos tipo-entrega">
    <div class="row gy-2 dark:text-gray-200">

        <h2 class="col-12 h5 mb-0 fw-semibold ">Selecione os adicionais <span class="text-muted">(Opcional)</span></h2>
        <p class=" text-muted">
            Estes são os itens que serão apresentados ao cliente ao final da montagem da pizza como opções para inclusão
            no pedido.
        </p>
        <!-- Selecionar adicional -->
        <div class="col-12 col-lg-12 mb-4 mt-4">
            {{-- <h2 class="h5 fw-bold mb-3">Adicionais</h2> --}}

            <!-- Select usando select2 -->
            <div class="mb-3  col-12 col-lg-4">
                <select id="listar-adicionais"
                    class="form-select py-2 px-3 input-light-custom rounded-pill text-muted fs-16px "
                    name="listar_adicional" style="width:100%"></select>
            </div>
            @error('adicionais_id.0')
                <div class="text-danger mb-3">{{ $message }}</div>
            @enderror

            <!-- Adicionais selecionados -->
            <div class="" id="adicionais-selecionados">
                <div class="row g-4" id="todos-adicionais-selecionado">
                    <!-- Adicionais selecionados -->

                    @foreach ($adicionais as $item)
                        @php
                            if ($item->adicional->limitar_estoque == 'S' && $item->adicional->estoque <= 0) {
                                continue;
                            }
                        @endphp
                        <div class="col-12 col-lg-4" id="adicional-{{ $item->adicional->id }}">
                            <input type="hidden" name="adicionais_id[]" value="{{ $item->adicional->id }}">
                            <div class="h-100 shadow border rounded-3 p-3 pb-2 position-relative"
                                style="border-color: rgba(150,150,150, .3) !important">
                                <button type="button" class="position-absolute text-danger" style="top:2px; right:2px"
                                    onclick="this.parentNode.parentNode.remove();document.getElementById('listar_produtos').value='';">
                                    <span class="material-symbols-outlined">
                                        close
                                    </span>
                                </button>
                                <div class="d-flex gap-1 py-2">
                                    <div class="me-2">
                                        <img class="rounded" src="{{ $item->adicional->img_destaque }}"
                                            alt="imagem_produto" width="50" style="max-width:50px; min-width: 50px">
                                    </div>
                                    <div class="w-100">
                                        <h3 class="fs-16 px fw-bold mb-0 pb-0">{{ $item->adicional->nome }}</h3>
                                        <p class="fs-13px pt-1 text-muted">
                                            {{ Str::limit($item->adicional->descricao, 70) }}</p>
                                        <div class="text-end mt-2 d-flex justify-content-between">
                                            <div class="small fw-bold text-success">
                                                <span class=""
                                                    style="font-size:18px">{{ currency_format($item->adicional->valor) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>

    </div>
</div>

<script>
    /* Add html de para add mais imagens */
    // $(document).on('ready', function() {
    //     document.getElementById('select2-listar-adicionais-container').innerText = 'Pesquisar adicional'
    // })

    /* Selecionar adicinal */
    $('#listar-adicionais').select2({
        placeholder: 'Pesquisar adicional',
        "language": "pt-BR",
        templateResult: function(d) {
            return $(d.html);
        },
        ajax: {
            url: "{{ route('painel.lojista.montar-pizza.adicionais-json') }}",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term,
                    // grupo_adicional_id: grupo_adicional_id
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
            `<div class="col-12 col-lg-4" id="adicional-${adicional.id}">
                    <input type="hidden" name="adicionais_id[]" value="${adicional.id}">
                    <div class="h-100 shadow border rounded-3 p-3 pb-2 position-relative" style="border-color: rgba(150,150,150, .3) !important">
                    <button type="button" class="position-absolute text-danger" style="top:2px; right:2px" 
                    onclick="this.parentNode.parentNode.remove();document.getElementById('listar_produtos').value='';">
                        <span class="material-symbols-outlined">
                        close
                        </span>
                    </button>
                    <div class="d-flex gap-1 py-2">
                        <div class="me-2">
                            <img class="rounded" src="${adicional.img_destaque}" alt="imagem_produto" width="50" style="max-width:50px; min-width: 50px">
                        </div>
                        <div class="w-100">
                            <h3 class="fs-16 px fw-bold mb-0 pb-0">${adicional.nome}</h3>
                            <p class="fs-13px pt-1 text-muted">${strLimit(adicional.descricao, 70)}</p>
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
</script>
