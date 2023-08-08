@extends('layouts.front.loja.appLoja', ['store' => $store])
@section('titulo', 'Escolha os sabores - ' . $store->nome)

@section('head')
    <style>
        .pizza-produto .valor-total-pizza {
            background: white;
            -webkit-box-shadow: 0 0 1.5rem rgba(0, 0, 0, .2);
            box-shadow: 0 0 1.5rem rgba(0, 0, 0, .2)
        }

        @media (min-width: 1200px) {
            .pizza-produto .col-previa {
                width: 40%
            }

            .pizza-produto .col-sabores {
                width: 30%
            }

            .pizza-produto .col-bordas {
                width: 30%
            }

        }

        footer {
            margin-bottom: 80px
        }

        .pizza-produto .card-body-opcoes-sabores {
            background: #fef6ee !important;
            border-color: #eae8e8 !important
        }

        .pizza-produto .card-body-opcoes-sabores:hover {
            background: #f4e5d7 !important;
        }
    </style>
@endsection

@section('content')
    @php
        // Obter a lista de categorias e so sabores
        $listaCat = isset($product->pizza_product->sabores) ? $product->pizza_product->sabores : [];
    @endphp

    <div class="pizza-produto">
        <div class="container py-5 mt-1 pt-1 pb-3">

            <div class="col-lg-12 mx-auto">
                <x-alert-error />
                <h1 class="h4 text-dark pt-3">{{ $product->nome }}</h1>
                <p class="mb-4">
                    {{ $product->descricao }}
                </p>
            </div>

            <!-- Montar pizza -->
            <div class="montar-pizza">
                <div class="">
                    <form
                        action="{{ route('loja.produto.pizza.fazer-pedido', [$store->slug_url, 'product' => $product->id]) }}"
                        method="post" id="form-pizza">
                        @csrf
                        <div class="row gy-4 gx-lg-3 justify-content-scenter">

                            <!-- Prévia da pizza -->
                            <div class="col-4  col-previa" id="previa">
                                <div class="border overflow-hidden bg-light rounded-3 p-0  d-flex flex-column">
                                    <div class="p-3">
                                        <h2 class="h6 mb-3 text-center">
                                            Prévia da Pizza
                                        </h2>
                                        <hr>

                                        @include('front.loja.montar_pizza_produto._previa_pizza', [
                                            'min_sabores' => $min_sabores,
                                            'max_sabores' => $max_sabores,
                                        ])
                                    </div>
                                </div>
                            </div>

                            <!-- Escolha os sabores -->
                            @include(
                                'front.loja.montar_pizza_produto._escolha_sabores',
                                compact('product', 'max_sabores', 'min_sabores'))

                            <!-- Escolha a borda -->
                            @include(
                                'front.loja.montar_pizza_produto._escolha_borda',
                                compact('product', 'max_sabores', 'min_sabores'))

                        </div>


                        <!-- obs -->
                        <input type="hidden" name="observacao" id="input-observacao">
                    </form>
                </div>
            </div>
        </div>

        <div class="container mb-5">
            <div class="bg-light p-3 rounded-3 border" id="div-obs" style="display: none">
                <div class="text-muted mb-2">
                    Obs:
                </div>
                <p class="fw-semibold" id="texto-obs">
                </p>
            </div>
        </div>

        <!-- Prévia do total do valor -->
        <div class=" lh-sm fixed-bottom valor-total-pizza bg-white" style="z-index: 1">
            <div class="container py-3">
                <div
                    class="d-flex flex-column flex-lg-row gap-2 gap-lg-5 align-items-lg-end justify-content-start justify-content-lg-center ">
                    <div class="text-start">
                        <div class="fw-bold text-muted  lh-1 fs-12px">Valor Total</div>
                        <div class="fs-2 fw-bold text-danger lh-1">
                            <span class="fs-16px">R$</span> <span id="valor-total">0,00</span>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" onclick="submitForm()" class="btn btn-outline-danger fw-600 pb-1"
                            id="btn-carrinho-add">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-cart-plus fa-sm me-1"></i>
                                Adicionar ao Carrinho
                            </div>
                        </button>
                        <button type="button"
                            class="btn btn-outline-primary fw-bold btn-sm d-flex align-items-center gap-1 pt-2 px-2"
                            data-bs-toggle="modal" data-bs-target="#modal-obs">
                            <i class="fa-solid fa-file-pen fa-sm"></i>
                            Observação
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal selecionar categoria -->
        @include(
            'front.loja.montar_pizza_produto._modal_selecionar_categoria',
            compact('product', 'listaCat'))
        <!-- Modal selecionar sabores -->
        @include('front.loja.montar_pizza_produto._modal_selecionar_sabores')
        <!-- Modal customizado para exibir erros -->
        @include('front.loja.montar_pizza_produto._modal_erro')
        <!-- obs -->
        @include('front.loja.montar_pizza_produto._modal_obs')

    </div>
@endsection

@section('scripts')
    <!-- scripts loja -->
    <script src="{{ asset('assets/js/loja.js') }}"></script>
    <!-- Validar envio do formulário -->
    <script>
        function addObs() {
            let texto = document.getElementById('observacao').value
            document.getElementById('input-observacao').value = texto
            if (texto == '') {
                document.getElementById('div-obs').style.display = 'none'
            } else {
                document.getElementById('div-obs').style.display = 'block'
                document.getElementById('texto-obs').innerHTML = texto
            }

        }

        function submitForm() {
            // event.preventDefault();

            if (document.querySelectorAll('.json-sabor').length >= maxSabores) {} else {
                // document.getElementById('btn-carrinho-add').className = 'btn btn-outline-danger fw-600 pb-1 disabled'
                showErroModal('Selecione todos os sabores')
                return;
            }

            // se tem alguma borda selecionada
            let temCheck = false
            document.querySelectorAll('.check-borda').forEach(element => {
                if (element.checked) {
                    temCheck = true
                }
            });
            if (!temCheck) {
                showErroModal('Selecione a borda')
                return;
            }

            document.getElementById('form-pizza').submit()
        }
    </script>

    <script>
        const modalSelecionarCategoria = new bootstrap.Modal(document.getElementById('modal-selecionar-categoria'))
        // modalSelecionarCategoria.show()
        const modalSelecionarSabor = new bootstrap.Modal(document.getElementById('modal-selecionar-sabores'))

        const modalErro = new bootstrap.Modal(document.getElementById('modal-erro-alert'))

        function showErroModal(msg) {
            document.getElementById('text-msg-erro').innerHTML = msg
            modalErro.show()
        }


        /* Selecionar categoria */
        var categoriaSelecionada = {}

        let categoriasSabores = @json($listaCat);

        function setCategoriaSelecionada(key) {
            categoriaSelecionada = categoriasSabores[key]
            modalSelecionarCategoria.hide()
            modalSelecionarSabor.show()
            setDadosSaboresModal()
        }

        function setDadosSaboresModal() {
            // categoriaSelecionada
            console.log(categoriaSelecionada);
            // titulo
            document.getElementById('text-nome-categoria').innerText = categoriaSelecionada.categoria
            document.getElementById('itens-sabores-categoria').innerHTML = ''

            // sabores
            categoriaSelecionada.itens.forEach((item, key) => {

                let div = document.createElement('div')
                div.className = 'col-12 col-lg-6'
                div.innerHTML = `
                <div class="card card-body-opcoes-sabores overflow-hidden border-0 shadow">
                    <a href="#" class="text-decoration-none text-dark" data-bs-dismiss="modal" onclick="adicionarSabor(${key})">
                        <div class="card-body position-relative">
                            <div class="d-flex gap-1">
                                <div class="">
                                    <img src="${item.imagem == null ? "{{ asset('assets/img/pizza/pizza-empty.png') }}": "{{ asset('/') }}"+item.imagem}" alt="" class="rounded-circle"
                                    style="width: 50px; height: 50px;border-radius: 50%">
                                </div>
                                <div class="w-100 ps-2">
                                    <!-- Sabore -->
                                    <h5 class="card-title pt-1 mb-1 pb-0">
                                        ${item.sabor}
                                    </h5>
                                    <p class="card-text mb-0 pb-0 small lh-sm ">
                                        ${item.descricao.substr(0, 100)} ${item.descricao.length > 100 ? '...' : ''}
                                    </p>

                                </div>

                                <div class="">
                                    <span class="text-danger fs-5 fw-semibold">
                                        ${moeda(item.valor)}
                                    </span>
                                </div>

                            </div>
                        </div>
                    </a>
                </div>`

                document.getElementById('itens-sabores-categoria').append(div)
            });
        }

        /* Adicionar o total de sabores */
        var maxSabores = {{ $min_sabores }}

        function setTotaSabores(total) {

            // limpar bordas selecionadas
            let elBordas = document.querySelectorAll('.check-borda')
            for (let index = 0; index < elBordas.length; index++) {
                elBordas[index].checked = false
            }
            dividirValoresBordas()

            // lista-sabores-previa
            maxSabores = total
            let html = ''
            for (let index = 1; index <= total; index++) {
                html += `
                <li class="list-group-item bg-light px-0 pt-3 sabores" id="li-sabor-${index}">
                    ${index}º Sabor
                    <div class="mt-2">
                        <button type="button"
                            class="btn btn-sm fw-semibold btn-outline-success rounded-1 gap-1 d-flex align-items-center pb-0 "
                            onclick="exibirModal(${index})">
                            Selecionar
                        </button>
                    </div>
                </li>
                `
            }
            document.getElementById('lista-sabores-previa').innerHTML = html
            organizarPreviaPizza()
            setValorTotalPizza()
        }
        // Exibir modal de categorias
        var posicaoSaborSelecionado = 0

        function exibirModal(posicaoSabor = 0) {
            posicaoSaborSelecionado = posicaoSabor
            document.getElementById('text-modal-categoria').innerHTML = posicaoSabor
            modalSelecionarCategoria.show()
        }

        // o 'keySaborSelecionado' vai ser do array 'categoriaSelecionada.itens' da cat q foi selecionada
        function adicionarSabor(keySaborSelecionado) {

            let saborSelecionado = categoriaSelecionada.itens[keySaborSelecionado]

            // Add html na lista de sabor
            document.getElementById('li-sabor-' + posicaoSaborSelecionado).innerHTML = `
                <input type="hidden" name="json_sabores[]" id="json-sabor-${posicaoSaborSelecionado}"
                    class="json-sabor">
                    ${posicaoSaborSelecionado}º Sabor
                    <div class=" d-flex mt-2">
                        <div class=" w-100" for="flavor-${posicaoSaborSelecionado}">
                            <div class="d-flex gap-2 w-100">
                                <div class="">
                                    <img src='${saborSelecionado.imagem == null ? '/assets/img/pizza/pizza-empty.png': '/'+saborSelecionado.imagem}'
                                        alt=""
                                        style="width: 50px; height: 50px;border-radius: 50%">
                                </div>
                                <div class="">
                                    <h3 class="h6 fw-bold mb-0">${saborSelecionado.sabor}</h3>
                                    <p class="small lh-sm mt-1">
                                        ${saborSelecionado.descricao.substr(0, 100)} ${saborSelecionado.descricao.length > 100 ? '...' : ''}
                                    </p>
                                </div>
                                <div class="fw-bold ms-auto valor-sabor-dividido"
                                    data-valor-original="${saborSelecionado.valor}"
                                    data-valor-dividido="${saborSelecionado.valor}">
                                    ${moeda(saborSelecionado.valor)}
                                    <span>50%<span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button"
                                    class="btn btn-sm btn-secondary rounded-1 fw-semibold gap-1 d-flex align-items-center p-2 py-2 "
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Alterar"
                                    onclick="exibirModal(${posicaoSaborSelecionado})" >
                                    <i class="fa-solid fa-rotate fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `
            document.getElementById(`json-sabor-${posicaoSaborSelecionado}`).value = JSON.stringify(saborSelecionado)
            organizarPreviaPizza();
            dividirValoresSabores();
        }

        function dividirValoresSabores() {
            let totalSabores = saboresSelecionados.length
            if (totalSabores == 0)
                return;

            let divValoresSabor = document.querySelectorAll('.valor-sabor-dividido')

            divValoresSabor.forEach((element, key) => {
                console.log();
                let valorDivididoOri = Number(element.dataset.valorOriginal) / totalSabores;

                valorDividido = parseFloat(valorDivididoOri.toFixed(2));
                let porcentagem = parseInt((100 / totalSabores) * 1)
                let textPorcentagem = totalSabores > 1 ? ` - ${porcentagem}%` : ''
                let vFormatSabor = parseFloat(valorDividido).toLocaleString('pt-br', {
                    minimumFractionDigits: 2
                });
                document.querySelectorAll('.valor-sabor-dividido')[key].innerText = vFormatSabor;
                document.querySelectorAll('.valor-sabor-dividido')[key].dataset.valorDividido = valorDivididoOri
            });

            setValorTotalPizza()
        }

        function dividirValoresBordas() {

            let elBordas = document.querySelectorAll('.check-borda')
            let totalBordasSelecionadas = 0
            elBordas.forEach(element => {
                if (element.checked)
                    totalBordasSelecionadas += 1;
            });

            if (totalBordasSelecionadas == 0)
                totalBordasSelecionadas = 1

            let totalBordas = totalBordasSelecionadas

            let divValoresSabor = document.querySelectorAll('.valor-borda-dividido')

            divValoresSabor.forEach((element, key) => {
                console.log();
                let valorDivididoOri = Number(element.dataset.valorOriginal) / totalBordas;

                valorDividido = parseFloat(valorDivididoOri.toFixed(2));
                let porcentagem = parseInt((100 / totalBordas) * 1)
                let textPorcentagem = totalBordas > 1 ? ` - ${porcentagem}%` : ''
                let vFormatSabor = parseFloat(valorDividido).toLocaleString('pt-br', {
                    minimumFractionDigits: 2
                });
                document.querySelectorAll('.valor-borda-dividido')[key].innerText = vFormatSabor;
                document.querySelectorAll('.valor-borda-dividido')[key].dataset.valorDividido = valorDivididoOri
            });

            setValorTotalPizza()
        }

        /* oranizar imagens na previa da pizza */
        var saboresSelecionados = []

        function organizarPreviaPizza() {

            saboresSelecionados = []
            // organizar sabores selecionados
            document.querySelectorAll('.json-sabor').forEach(element => {
                let d_json = element.value
                saboresSelecionados.push(JSON.parse(d_json))
            });

            let totalSelecionados = saboresSelecionados.length

            let totalFatias = 12 / totalSelecionados
            totalFatias = parseInt(totalFatias)

            // hiden pizza
            document.getElementById('local-pizza-overflow-1').classList.add('hidden')

            // inserir texto em total de bordas
            if (maxSabores > 1) {
                document.getElementById('texto-max-borda').innerHTML = ` e no máximo <strong>${maxSabores}</strong> `
            } else {
                document.getElementById('texto-max-borda').innerHTML = ''
            }

            let inicioLoop = 1;

            // show pizza
            setTimeout(() => {

                // remover as imgs de sabores em prévisualizar
                for (let i = 1; i <= 12; i++) {
                    document.getElementById('sabor-' + i).style.background = "transparent"
                }

                for (let i in saboresSelecionados) {

                    let b_ini = 1;
                    let b_fim = totalFatias;
                    let img = null
                    for (let b in saboresSelecionados) {

                        for (let x = b_ini; x <= 12; x++) {
                            let dataItem = saboresSelecionados[b]

                            if (dataItem.imagem == null) {
                                img = "{{ asset('assets/img/pizza/pizza-empty.png') }}";
                            } else {
                                img = "{{ asset('/') }}" + dataItem.imagem;
                            }
                            document.getElementById('sabor-' + x).style.background = `url(${img})`
                        }

                        b_ini = b_fim + 1;
                        b_fim = b_fim + totalFatias
                    }
                }
                document.getElementById('local-pizza-overflow-1').classList.remove('hidden')
                // setValorTotal()
            }, 200);
        }

        function selecionarBorda(el) {
            // let totalSabores = saboresSelecionados.length
            // if (totalSabores == 0)
            //     totalSabores = 1

            let elBordas = document.querySelectorAll('.check-borda')
            let totalBordasSelecionadas = 0;
            for (let index = 0; index < elBordas.length; index++) {
                if (elBordas[index].checked)
                    totalBordasSelecionadas += 1;
            }

            if (totalBordasSelecionadas > maxSabores) {
                el.checked = false
                showErroModal(
                    `Você pode selecionar no máximo <strong>${maxSabores}</strong> ${maxSabores > 1 ? 'bordas diferentes' : 'borda'}`
                )
            }

            dividirValoresBordas()
        }

        function setValorTotalPizza() {
            let valor = {{ $product->valor }}; // valor min da pizza

            let divValoresSabor = document.querySelectorAll('.valor-sabor-dividido')
            divValoresSabor.forEach((element, key) => {
                valorSabor = document.querySelectorAll('.valor-sabor-dividido')[key].dataset.valorDividido
                valor += Number(valorSabor)
            });
            let divValoresBorda = document.querySelectorAll('.valor-borda-dividido')
            divValoresBorda.forEach((element, key) => {
                if (document.getElementById('edge' + key).checked) {
                    valorBorda = document.querySelectorAll('.valor-borda-dividido')[key].dataset.valorDividido
                    valor += Number(valorBorda)
                }
            });

            valor = Number(valor.toFixed(2))
            valor = parseFloat(valor).toLocaleString('pt-br', {
                minimumFractionDigits: 2
            });

            document.getElementById('valor-total').innerHTML = valor
        }
        setValorTotalPizza()

        /* tooltips */
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
@endsection
