@extends('layouts.front.loja.app', ['store' => $store])
@section('titulo', 'Selecione uma forma de entrega e pagamento - ' . $store->nome)
@section('head')
    <!-- Select2 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/i18n/pt-BR.js"></script>

    <style>
        .form-control {
            border-color: #e2e8f0;
        }
    </style>

@endsection
@section('content')
    <section>
        <div class="container py-5 mt-5">
            <div class="col-12 col-lg-10 mx-auto">

                {{-- Alerts --}}
                <x-alert-success />
                <x-alert-error />

                <div class="row g-4">
                    <form action="{{ route('cliente.finalizar-pedido', $store->slug_url) }}" method="post" id="form">
                        @csrf
                        <input type="hidden" name="qtd_itens" value="{{ $data['qtd_itens'] }}">
                        <input type="hidden" name="total_pedido" value="{{ $data['soma_pedido'] }}">
                        <div class="col-12 col-md-12">
                            <div class="card border">
                                <div class="p-2">

                                    <!-- Forma de entrega -->
                                    <div class="card-body p-4">
                                        <h2 class=" h6 mb-0">Forma de entrega</h2>
                                        <div class="row g-3 mt-1">

                                            <!-- Tipo entrega -->
                                            <div class="col-12 col-md-6">
                                                <div class="border p-3 p-lg-4 h-100 rounded bg-light">
                                                    <!-- Tipo -->
                                                    <div class="">
                                                        <label for="tipo" class="mb-1">Tipo</label>
                                                        <select class="selecionar-tipo w-100" name="delivery_type_id"
                                                            id="tipo" required>
                                                            <!-- options -->
                                                            @if (old('delivery_type_id'))
                                                                <option value="{{ old('delivery_type_id') }}"></option>
                                                            @endif
                                                        </select>
                                                    </div>

                                                    <!-- Endereço -->
                                                    <div class="" id="endereco"
                                                        style="display: none; @if ($errors->any()) display:block @endif">
                                                        <div class="row mt-3 g-3">
                                                            <div class="col-12">
                                                                <h3 class="h6 fw-semibold mb-0 pb-0">Endereço</h3>
                                                            </div>
                                                            <!-- estado -->
                                                            <div class="col-12 col-lg-6 col-xl-6">
                                                                <label for="estado" class="form-label mb-0">Estado<span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text"
                                                                    class=" @error('estado') is-invalid @enderror form-control input-endereco"
                                                                    name="estado" id="estado"
                                                                    value="{{ old('estado', auth()->user()->data_customer->estado) }}"
                                                                    placeholder="">
                                                                @error('estado')
                                                                    <div class="invalid-feedback fs-12px fw-semibold lh-sm">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <!-- cidade -->
                                                            <div class="col-12 col-lg-6 col-xl-6">
                                                                <label for="cidade" class="form-label mb-0">Cidade<span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text"
                                                                    class=" @error('cidade') is-invalid @enderror form-control input-endereco"
                                                                    name="cidade" id="cidade"
                                                                    value="{{ old('cidade', auth()->user()->data_customer->cidade) }}"
                                                                    placeholder="">
                                                                @error('cidade')
                                                                    <div class="invalid-feedback fs-12px fw-semibold lh-sm">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <!-- bairro -->
                                                            <div class="col-12 col-lg-6 col-xl-6">
                                                                <label for="bairro" class="form-label mb-0">Bairro<span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text"
                                                                    value="{{ old('bairro', auth()->user()->data_customer->bairro) }}"
                                                                    class=" @error('bairro') is-invalid @enderror form-control input-endereco"
                                                                    name="bairro" id="bairro" placeholder="">
                                                                @error('bairro')
                                                                    <div class="invalid-feedback fs-12px fw-semibold lh-sm">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <!-- rua -->
                                                            <div class="col-12 col-lg-6 col-xl-6">
                                                                <label for="rua" class="form-label mb-0">rua<span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text"
                                                                    value="{{ old('rua', auth()->user()->data_customer->rua) }}"
                                                                    class=" @error('rua') is-invalid @enderror form-control input-endereco"
                                                                    name="rua" id="rua" placeholder="">
                                                                @error('rua')
                                                                    <div class="invalid-feedback fs-12px fw-semibold lh-sm">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>

                                                            <!-- rua -->
                                                            <div class="col-12 col-lg-6 col-xl-6">
                                                                <label for="rua" class="form-label mb-0">Rua<span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text"
                                                                    class=" @error('rua') is-invalid @enderror form-control input-endereco"
                                                                    name="rua" id="rua"
                                                                    value="{{ old('rua', auth()->user()->data_customer->rua) }}"
                                                                    placeholder="">
                                                                @error('rua')
                                                                    <div class="invalid-feedback fs-12px fw-semibold lh-sm">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>

                                                            <!-- Número -->
                                                            <div class="col-12 col-lg-6 col-xl-6">
                                                                <label for="numero" class="form-label mb-0">N° de
                                                                    endereço<span class="text-danger">*</span></label>
                                                                <input type="text"
                                                                    class=" @error('numero') is-invalid @enderror form-control input-endereco"
                                                                    name="numero" id="numero"
                                                                    value="{{ old('numero', auth()->user()->data_customer->numero_end) }}"
                                                                    placeholder="">
                                                                @error('numero')
                                                                    <div class="invalid-feedback fs-12px fw-semibold lh-sm">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <!-- cep -->
                                                            <div class="col-12 col-lg-6 col-xl-6">
                                                                <label for="cep" class="form-label mb-0">CEP<span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text"
                                                                    class=" @error('cep') is-invalid @enderror form-control input-endereco"
                                                                    name="cep" id="cep"
                                                                    value="{{ old('cep', auth()->user()->data_customer->cep) }}"
                                                                    placeholder="">
                                                                @error('cep')
                                                                    <div class="invalid-feedback fs-12px fw-semibold lh-sm">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>

                                                            <!-- complemento -->
                                                            <div class="col-12 col-lg-6 col-xl-6">
                                                                <label for="complemento" class="form-label mb-0">
                                                                    Complemento
                                                                </label>
                                                                <input type="text"
                                                                    class=" @error('complemento') is-invalid @enderror form-control "
                                                                    name="complemento"
                                                                    value="{{ old('complemento', auth()->user()->data_customer->complemento) }}"
                                                                    id="complemento" placeholder="">
                                                                @error('complemento')
                                                                    <div class="invalid-feedback fs-12px fw-semibold lh-sm">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>


                                                        </div>
                                                    </div>

                                                    <!-- Selecionar mesa -->
                                                    <div class="" id="div-selecionar-mesa" style="display:none">
                                                        <!-- Tipo -->
                                                        <div class=" mt-3">
                                                            <label for="entrega-mesa" class="mb-1">Seleciona uma
                                                                mesa</label>
                                                            <select class="selecionar-mesa w-100" name="delivery_table_id"
                                                                id="entrega-mesa">
                                                                <!-- options -->
                                                                @if (old('delivery_table_id'))
                                                                    {{-- <option value="{{ old('delivery_table_id') }}">
                                                                    </option> --}}
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <!-- Valor e tempo -->
                                            <div class="col-12 col-md-6">
                                                <div class="border p-3 p-lg-4 h-100 rounded bg-light">

                                                    <div class="row">
                                                        <!-- valor -->
                                                        <div class="col-12 col-lg-6 col-xl-6">
                                                            <label for="valor" class="form-label mb-1">Valor<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text"
                                                                class=" @error('valor') is-invalid @enderror form-control shadow-none"
                                                                name="valor" id="valor"
                                                                value="{{ old('valor') }}" placeholder="" readonly
                                                                required>
                                                            @error('valor')
                                                                <div class="invalid-feedback fs-12px fw-semibold lh-sm">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>

                                                        <!-- tempo -->
                                                        <div class="col-12 col-lg-6 col-xl-6">
                                                            <label for="tempo" class="form-label mb-1">Tempo<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text"
                                                                class=" @error('tempo') is-invalid @enderror form-control shadow-none"
                                                                name="tempo" id="tempo"
                                                                value="{{ old('tempo') }}" placeholder="" readonly
                                                                required>
                                                            @error('tempo')
                                                                <div class="invalid-feedback fs-12px fw-semibold lh-sm">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- Forma de pagamento -->
                                    <div class="card-body p-4">
                                        <h2 class=" h6 mb-0">Forma de pagamento</h2>
                                        <div class="row g-3 mt-1">

                                            <!-- Tipo pagamento -->
                                            <div class="col-12 col-md-6">
                                                <div class="border p-3 p-lg-4 h-100 rounded bg-light">
                                                    <div class="">
                                                        <label for="tipo_pagamento" class="mb-1">Tipo</label>
                                                        <select class="selecionar-tipo-pagamento w-100"
                                                            name="payment_method_id" id="tipo_pagamento" required>
                                                            <!-- options -->
                                                            @if (old('payment_method_id'))
                                                                {{-- <option value="{{ old('payment_method_id') }}"></option> --}}
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Valor para troco -->
                                            <div class="col-12 col-md-6" id="dados-pagamento" style="display: none">
                                                <div class="border p-3 p-lg-4 h-100 rounded bg-light">

                                                    <div class="">
                                                        <h4 class="fs-5 d-flex gap-2 align-items-center"
                                                            id="nome-tipo-pagamento">
                                                            <!-- nome do tipo -->
                                                        </h4>
                                                        <p class="" id="descricao-tipo-pagamento">
                                                            <!-- descricao -->
                                                        </p>
                                                    </div>

                                                    <!-- Valor troco -->
                                                    <div class="col-12 col-lg-6 col-xl-6 mt-4" id="div-valor-troco"
                                                        style="display: ndone">
                                                        <label for="valor_troco" class="form-label mb-1">
                                                            Valor para troco
                                                            <input type="text"
                                                                class=" @error('valor_troco') is-invalid @enderror form-control"
                                                                name="valor_troco" id="valor_troco"
                                                                placeholder="R$ 0,00">
                                                            @error('valor_troco')
                                                                <div class="invalid-feedback fs-12px fw-semibold lh-sm">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>



                                    <!-- Observação -->
                                    <div class="card-body p-4">
                                        <div class="border bg-light p-4">
                                            <h2 class="h6 mb-0">Observação sobre o pedido <span
                                                    class="text-muted small fw-normal">(opcional)</span></h2>
                                            <div class="mb-3 mt-2">
                                                <textarea class="form-control" name="observacao" id="observacao" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <input type="hidden" id="troco" name="troco">
                                <input type="hidden" id="end_entrega" name="end_entrega">
                                <div class="text-end px-3 px-lg-5 lh-sm">
                                    Valor total a pagar com taxa de entrega
                                    <div class="text-end  fs-4 text-danger fw-bold">
                                        R$ <span class="fs-1"
                                            id="valor-total-pagar-com-frete">{{ currency($valor_total_pedido) }}</span>
                                    </div>
                                </div>
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-danger px-5 py-2 text-up fw-semibold"
                                        id="submit-finalizar-pedido">
                                        Finalizar Pedido
                                    </button>
                                </div>

                            </div>
                        </div>


                    </form>



                </div>
            </div>

        </div>
    </section>

@endsection
@section('scripts')
    @php
        /* organizar dados do tipo de entrega */
        $dataDeliveryTypes = [];
        $dataDeliveryTypes[] = [
            'id' => 0,
            'text' => 'Selecione uma opção',
            'html' => '<div>Selecione uma opção</div>',
        ];
        
        foreach ($deliveryTypes as $key => $type) {
            $dataDeliveryTypes[] = [
                'id' => $type->id,
                'text' => $type->nome,
                'html' => "<div><i class='{$type->icone} me-1'></i> {$type->nome}</div>",
                'data' => $type,
            ];
        }
        
        /* organizar dados do tipo de pagamento */
        $dataPaymentMethods = [];
        $dataPaymentMethods[] = [
            'id' => 0,
            'text' => 'Selecione uma opção',
            'html' => '<div>Selecione uma opção</div>',
        ];
        
        foreach ($paymentMethods as $key => $type) {
            $dataPaymentMethods[] = [
                'id' => $type->id,
                'text' => $type->nome,
                'html' => "<div><i class='{$type->icone} me-1'></i> {$type->nome}</div>",
                'data' => $type,
            ];
        }
        
    @endphp

    <script>
        var dadosTipoEntrega = null;
        var valor_entrega = null;

        $(document).ready(function() {

            /* Select2 - Selecionar tipo entrega */
            $('.selecionar-tipo').select2({
                placeholder: 'Selecione uma opção',
                "language": "pt-BR",
                templateResult: function(d) {
                    return $(d.html);
                },
                templateSelection: function(d) {
                    return $(d.html);
                },
                data: @json($dataDeliveryTypes),

            }).on("select2:select", function(e) { // Ação após seleciona item

                if (e.params.data.id == 0)
                    return;

                $("#tipo_pagamento").empty()
                setTimeout(() => {
                    document.getElementById('select2-tipo_pagamento-container').innerHTML = 'Selecione uma opção'
                    document.getElementById('dados-pagamento').style.display = 'none'
                }, 300);
                

                // adicionar id da tipo de entrega na variavel
                tipo_entrega_id = e.params.data.id

                let data = e.params.data.data;

                // console.log(data)
                dadosTipoEntrega = data

                // se for delivery ou correios
                if (data.tipo == 'Delivery' || data.tipo == 'Correios') {
                    document.getElementById('endereco').style.display = 'flex'
                    $('.input-endereco').attr('required', true)
                } else {
                    document.getElementById('endereco').style.display = 'none'
                    $('.input-endereco').attr('required', false)
                }

                // se o tipo de entrega for mesa
                if (data.tipo == 'Mesa') {
                    document.getElementById('div-selecionar-mesa').style.display = 'block'
                    $('#entrega-mesa').attr('required', true)
                    document.getElementById('select2-entrega-mesa-container').parentNode.parentNode
                        .parentNode.style.width = '100%'
                    $('#entrega-mesa').focus();
                    $('#entrega-mesa').val(0);
                    $('#entrega-mesa').html('');

                } else {
                    document.getElementById('div-selecionar-mesa').style.display = 'none'
                    $('#entrega-mesa').attr('required', false)
                    $('#entrega-mesa').focus();
                }

                $('#valor').val(moeda(data.valor))
                $('#tempo').val(data.tempo)
                valor_entrega = data.valor


                // adiciona valor da entrega baseado no cep, se existir nos registros
                verificarCEPsCadastrados()

            });

            /* Select2 - Selecionar mesa */
            var tipo_entrega_id = null;
            $('.selecionar-mesa').select2({
                placeholder: 'Pesquisar mesa',
                "language": "pt-BR",
                templateResult: function(d) {
                    return $(d.html);
                },
                ajax: {
                    url: "{{ route('cliente.formas-entrega-e-pagamento.mesas', $store->slug_url) }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                            tipo_entrega_id: tipo_entrega_id
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    nome: item.mesa,
                                    text: item.mesa,
                                    html: `<div class='d-flex gap-2 align-itedms-center'>
                                        <span class='fw-bold'>${item.mesa} </span>
                                    </div>`,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }

            });

            /* Select2 - Selecionar tipo pagamento */
            $('.selecionar-tipo-pagamento').select2({
                placeholder: 'Selecione uma opção',
                "language": "pt-BR",
                templateResult: function(d) {
                    return $(d.html);
                },
                templateSelection: function(d) {
                    return $(d.html);
                },
                // data: json(dataPaymentMethods),

                ajax: {
                    url: "{{ route('cliente.formas-entrega-e-pagamento.metodos-pagamento', $store->slug_url) }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                            tipo_entrega_id: tipo_entrega_id
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    nome: item.payment_method.nome,
                                    text: item.payment_method.nome,
                                    html: `<div class='d-flex gap-2 align-itedms-center'>
                                        <span class='fw-bold'>${item.payment_method.nome} </span>
                                    </div>`,
                                    id: item.payment_method.id,
                                    data: item.payment_method
                                }
                            })
                        };
                    },
                    cache: true
                }

            }).on("select2:select", function(e) { // Ação após seleciona item

                if (e.params.data.id == 0) {
                    document.getElementById('dados-pagamento').style.display = 'none'
                    return;
                }

                // console.log(e.params.data)
                let data = e.params.data.data;

                if (data.tipo == 'DINHEIRO') {
                    document.getElementById('div-valor-troco').style.display = 'block'
                    $('#valor_troco').attr('required', false)
                } else {
                    document.getElementById('div-valor-troco').style.display = 'none'
                    $('#valor_troco').attr('required', false)
                }

                // Dados do tipo de pagamento
                $('#nome-tipo-pagamento').html(` <i class="fa-sm ${data.icone}"></i> ${data.nome}`)
                $('#descricao-tipo-pagamento').html(data.descricao)
                document.getElementById('dados-pagamento').style.display = 'block'
            });

            

        });
    </script>

    <!-- Mascaras de input -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/imask/6.4.3/imask.min.js"></script>
    <script>
        var valor_troco = IMask(document.getElementById('valor_troco'), {
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
        });

        var cep = IMask(document.getElementById('cep'), {
            mask: [{
                    mask: '00000-000'
                },
                {
                    mask: '00.000-000'
                }
            ]
        });
        var cep = IMask(document.getElementById('numero'), {
            mask: '000000000'
        });

        // bloquear botão ao clicar em enviar
        document.querySelector('#submit-finalizar-pedido').onclick = function() {
            if (document.getElementById('tipo').value == 0) {
                document.getElementById('tipo').focus();
                return false;
            }
            if (document.getElementById('tipo_pagamento').value == 0) {
                document.getElementById('tipo_pagamento').focus();
                return false;
            }
            $('#form').submit(function() {
                document.querySelector('#submit-finalizar-pedido').disabled = true;
            })
        }
    </script>

    <!-- cdn axios -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.3/axios.min.js"></script>
    <script>
        /* verificar se o CEP informado pelo cliente consta nos registros de CEPs e adiciona o valor da entrega */
        function verificarCEPsCadastrados() {

            // dadosTipoEntrega

            // if(dadosTipoEntrega.bloqueia_sem_cep == 'S') {
            if (dadosTipoEntrega.tipo == 'Delivery' || dadosTipoEntrega.tipo == 'Correios') {
                let cep = document.getElementById('cep').value
                    .replace('.', '')
                    .replace('-', '')
                    .replace('.', '')
                    .replace('-', '')
                    .replace('.', '')
                    .replace('-', '')

                axios
                    .get(`{{ route('cliente.formas-entrega-e-pagamento.busca-cep', $store->slug_url) }}?cep=${cep}`)
                    .then(function(res) {
                        // console.log(res.data)

                        if (res.data.dados !== null) {
                            document.getElementById('valor').value = moeda(res.data.dados.valor)
                        } else {
                            document.getElementById('valor').value = moeda(valor_entrega)
                        }
                    })
            }

        }

        // para utiliza com timeout
        var timer = 0
        document.getElementById('cep').onkeyup = function() {
            clearTimeout(timer);
            if (document.getElementById('cep').value != '') {
                timer = setTimeout(() => {
                    verificarCEPsCadastrados()
                }, 700);
            } else {
                document.getElementById('valor').value = moeda(valor_entrega)
            }
        }

        setInterval(() => {
            // document
            // valor-total-pagar-com-frete
            let valor_total = {{ $valor_total_pedido }};
            let valor_frete = document.getElementById('valor').value
            if (valor_frete == '')
                return;

            valor_frete = valor_frete.replace('.', '').replace('.', '').replace('.', '').replace('.', '').replace(
                ',', '.').replace(',', '.').replace(',', '.')
            valor_frete = parseFloat(valor_frete)

            let valor_total_com_frete = valor_frete + valor_total
            document.getElementById('valor-total-pagar-com-frete').innerText = moeda(valor_total_com_frete)


        }, 300);
    </script>

@endsection
