<div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 sabores">
    <div class="row gy-2 dark:text-gray-200">
        <div class="row gy-2">
            <h2 class="col-12 mb-0 fw-semibold h5">Sabores</h2>
            <p class="mb-4 text-muted ">
                Insira a quantidade permitida de sabores e adicione quantos sabores desejar em cada categoria.
            </p>

            <div class="row">
                <div class="mb-3 col-12 col-lg-4">

                    <label for="qtd-min" class="form-label">Qtd. Mínima de sabores<span class="text-danger">*</span>
                    </label>
                    <input type="text"
                        class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                        name="qtd_min_sabores" id="qtd-min" placeholder="0" maxlength="255"
                        value="{{ old('qtd_min_sabores', $product->pizza_product == null ? '' : $product->pizza_product->qtd_min_sabores) }}"
                        required>
                    <div class="invalid-feedback" id="invalid-feedback-min">
                        <!-- text -->
                    </div>
                </div>
                <div class="mb-3 col-12 col-lg-4">
                    <label for="qtd-max" class="form-label">Qtd. Máxima de sabores<span class="text-danger">*</span>
                    </label>
                    <input type="text"
                        class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                        name="qtd_max_sabores" id="qtd-max" placeholder="0"
                        value="{{ old('qtd_max_sabores', $product->pizza_product == null ? '' : $product->pizza_product->qtd_max_sabores) }}"
                        maxlength="255" required>
                    <div class="invalid-feedback" id="invalid-feedback-max">
                        <!-- text -->
                    </div>
                </div>
            </div>

            <div class="col-12">
                <hr class="mb-3" style="">
            </div>


            <!-- Categorias -->
            <div id="lista-categorias">
                @isset($product->pizza_product->sabores)
                    @foreach ($product->pizza_product->sabores as $key => $item)
                        <div class="class-sabores">
                            <input name="sabores[{{ time() + $key }}][categoria]" type="hidden"
                                value="{{ $item['categoria'] }}" required>
                            <h3 class="h3">
                                {{ $item['categoria'] }}
                                <button type="button" class="btn btn-none p-0" onclick="removerCategoriaConfirm(this)"
                                    title="Remover categoria" data-bs-toggle="modal" data-bs-target="#modal-remover-cat">
                                    <div class="d-flex">
                                        <span class="material-symbols-outlined text-danger">
                                            delete
                                        </span>
                                    </div>
                                </button>
                            </h3>
                            <!-- Sabores -->
                            <div class="col-12" id="inputs-sabores-{{ time() + $key }}">
                                @foreach ($item['itens'] as $keyItemSabor => $itemSabor)
                                    <div class="row mb-3  pt-2">
                                        <!-- imagem -->
                                        <div class="col-6 col-lg-2 overflow-hidden "
                                            style="max-width: 110px; max-height: 110px; min-height: 110px">
                                            <label for="img-sabor-x-{{ time() + $key + ($keyItemSabor + 1) * 2 }}"
                                                class="form-label position-relative  ">
                                                <span class="visually-hidden">Selecionar imagem</span>
                                                <img src="{{ asset($itemSabor['imagem'] ?? 'assets/img/pizza/pizza-empty.png') }}"
                                                    alt=""
                                                    id="img-sabor-tag-{{ time() + $key + ($keyItemSabor + 1) * 2 }}"
                                                    class="w-100 rounded-3 img-pizza-sabor " style="max-width: 110px;">
                                                <div
                                                    class="rounded-3 position-absolute top-0 add-imgs d-flex align-items-center justify-content-center">
                                                    <span class="material-symbols-outlined fs-2 text-dark opacity-75">
                                                        add_circle
                                                    </span>
                                                </div>
                                            </label>
                                            <input type="file" class="d-none"
                                                name="sabores[{{ time() + $key }}][itens][img][]"
                                                id="img-sabor-x-{{ time() + $key + ($keyItemSabor + 1) * 2 }}"
                                                onchange="setImgFileChange('img-sabor-x-{{ time() + $key + ($keyItemSabor + 1) * 2 }}', 'img-sabor-tag-{{ time() + $key + ($keyItemSabor + 1) * 2 }}')"
                                                accept="image/*">
                                            <!-- path da img ser for editar -->
                                            <input type="hidden" name="sabores[{{ time() + $key }}][itens][img_edit][]"
                                                value="{{ $itemSabor['imagem'] }}">

                                        </div>
                                        <div class="col-12 col-lg-4 col-xl-4 mb-3">

                                            <!-- sabor -->
                                            <input type="text" value="{{ $itemSabor['sabor'] }}"
                                                class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                                name="sabores[{{ time() + $key }}][itens][sabor][]" placeholder="Sabor"
                                                maxlength="255" required>
                                            <!-- Descrição -->
                                            <div class="mt-2">
                                                <input type="text" value="{{ $itemSabor['descricao'] }}"
                                                    class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                                    name="sabores[{{ time() + $key }}][itens][descricao][]"
                                                    placeholder="Descrição (opcional)" maxlength="1000">
                                            </div>
                                        </div>
                                        <!-- valor -->
                                        <div class="col-12 col-lg-2 col-xl-2 mb-3">
                                            <input type="text" value="{{ $itemSabor['valor'] }}"
                                                class="valor-sabor form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                                name="sabores[{{ time() + $key }}][itens][valor][]" placeholder="Valor"
                                                id="valor-inicial-{{ time() + $key + ($keyItemSabor + 1) * 2 }}"
                                                maxlength="20" required>
                                        </div>
                                        @if ($keyItemSabor != 0)
                                            <!-- remover -->
                                            <div class="col-12 col-lg-2 col-xl-2 mb-3" style="padding-top: 2px">
                                                <button type="button"
                                                    class="btn btn-sm btn-danger bg-danger btn-sm p-1 py-1 rounded-3"
                                                    onclick="removerItem(this); addImgParaDeletar(`{{ $itemSabor['imagem'] }}`)"
                                                    title="Remover">
                                                    <div class="d-flex">
                                                        <span class="material-symbols-outlined">
                                                            delete
                                                        </span>
                                                    </div>
                                                </button>
                                            </div>
                                        @endif
                                        <div class="col-12">
                                            <hr>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- add mais -->
                            <div class="col-12 mb-3 pt-2">
                                <div class="">
                                    <button type="button" class="btn btn-secondary bg-secondary rounded-3 px-2 py-1"
                                        onclick="addSabor('{{ time() + $key }}')">
                                        <div class="d-flex gap-1 align-items-center text-white">
                                            <span class="material-symbols-outlined " style="font-size: 18px">
                                                add_circle
                                            </span>
                                            Mais
                                        </div>
                                    </button>
                                </div>
                            </div>
                            <hr class="mb-3 mt-3" style="border-width: 5px ">
                        </div>
                    @endforeach
                @endisset
            </div>


            <!-- Adicionar categoria -->
            <div class="col-12 text-center py-4">
                <button type="button"
                    class="btn btn-danger bg-danger d-flex flex-column flex-lg-row align-items-center mx-auto"
                    data-bs-toggle="modal" data-bs-target="#modal-categoria">
                    <span class="material-symbols-outlined fs-6">
                        add
                    </span>
                    Adicionar categoria de sabores
                </button>
            </div>

            <!-- Imagens para deletar -->
            <div id="imgs-para-deletar">
                <!--  -->
            </div>


        </div>

    </div>
</div>


<!-- Modal Categoria -->
<div class="modal fade" id="modal-categoria" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
        <div class="modal-content bg-white rounded-lg shadow-md dark:bg-gray-800 ">
            <div class="modal-body pb-3">

                <div class="alert alert-warning py-2" role="alert" id='alert-categoria-erro' style="display:none">
                    <div class="d-flex align-items-center gap-1">
                        <span class="material-symbols-outlined fs-5"> error </span>
                        Insira o nome da categoria
                    </div>
                </div>

                <!-- Categoria -->
                <div class="mb-2">
                    <label for="add-categoria" class="form-label">Categoria</label>
                    <input type="text" id="add-categoria"
                        class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                        maxlength="255">
                </div>

                <div class="text-center pt-4 pb-1">
                    <button type="button" class="btn btn-secondary bg-secondary" data-bs-dismiss="modal"
                        id="btn-cancelar-modal">Cancelar</button>
                    <button type="button" class="btn btn-primary bg-primary" onclick="salvarCategoria()">
                        Adicionar
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>


<!-- Modal remover categoria -->
<div class="modal fade" id="modal-remover-cat" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
        <div class="modal-content bg-white rounded-lg shadow-md dark:bg-gray-800 ">
            <div class="modal-body pb-4 py-4">

                <div class="fs-5 text-center">
                    Tem certeza de que deseja remover esta categoria?
                </div>


                <div class="text-center pt-4 pb-1">
                    <button type="button" class="btn btn-secondary bg-secondary px-4" data-bs-dismiss="modal"
                        id="btn-remove-cate">Não</button>
                    <button type="button" class="btn btn-danger bg-danger px-4" onclick="removerCategoria()">
                        Sim
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    /* Adicionar sabor */
    var count = 100;

    function addSabor(timestamp) {
        count++;
        let div = document.createElement("div")
        div.className = 'row mb-3 pt-2'
        div.innerHTML = `
        <!-- imagem -->
        <div class="col-6 col-lg-2 overflow-hidden " style="max-width: 110px; max-height: 110px; min-height: 110px">
            <label for="img-sabor-x-${count}"
                class="form-label position-relative overflow-hidden ">
                <span class="visually-hidden">Selecionar imagem</span>
                <img src="{{ asset('assets/img/pizza/pizza-empty.png') }}" alt=""
                    id="img-sabor-tag-${count}" class="w-100 rounded-3 img-pizza-sabor "
                    style="max-width: 110px;">
                <div
                    class="rounded-3 position-absolute top-0 add-imgs d-flex align-items-center justify-content-center">
                    <span class="material-symbols-outlined fs-2 text-dark opacity-75">
                        add_circle
                    </span>
                </div>
            </label>
            <input type="file" class="d-none" name="sabores[${timestamp}][itens][img][]"
                id="img-sabor-x-${count}"
                onchange="setImgFileChange('img-sabor-x-${count}', 'img-sabor-tag-${count}')" accept="image/*">
        </div>
        <!-- sabor -->
        <div class="col-12 col-lg-4 col-xl-4 mb-3">
            <input type="text"
                class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                name="sabores[${timestamp}][itens][sabor][]" placeholder="Sabor" maxlength="255" required>
                <div class="mt-2">
                    <input type="text"
                        class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                        name="sabores[${timestamp}][itens][descricao][]" placeholder="Descrição (opcional)" maxlength="1000">
                </div>
        </div>
        <!-- valor -->
        <div class="col-12 col-lg-2 col-xl-2 mb-3">
            <input type="text"
                class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                name="sabores[${timestamp}][itens][valor][]" placeholder="Valor" maxlength="20" id="input-${count}" required>
        </div>
        <!-- remover -->
        <div class="col-12 col-lg-2 col-xl-2 mb-3" style="padding-top: 2px">
            <button type="button" class="btn btn-sm btn-danger bg-danger btn-sm p-1 py-1 rounded-3" onclick="removerItem(this)" title="Remover">
                <div class="d-flex">
                    <span class="material-symbols-outlined">
                        delete
                    </span>
                </div>
            </button>
        </div>
        <div class="col-12"> <hr> </div>
    `;

        document.getElementById('inputs-sabores-' + timestamp).append(div)
        maskValor('input-' + count);
    }

    /* adicionar categoria de sabores */
    function salvarCategoria() {
        let categoria = document.getElementById('add-categoria').value
        if (categoria != '') {
            document.getElementById('btn-cancelar-modal').click()
            document.getElementById('alert-categoria-erro').style.display = 'none'
            document.getElementById('add-categoria').value = ''

            addNovaCategoriaHtml(categoria)
        } else {
            document.getElementById('alert-categoria-erro').style.display = 'block'
        }
    }

    /* remover categoria */
    var catRemover = null

    function removerCategoriaConfirm(el) {
        catRemover = el
    }

    function removerCategoria() {
        if (catRemover)
            catRemover.parentNode.parentNode.remove()
        document.getElementById('btn-remove-cate').click()
    }


    function addNovaCategoriaHtml(nomeCategoria) {
        let timestamp = new Date().getTime();
        let html = `
        <div class="class-sabores">
                <input name="sabores[${timestamp}][categoria]" type="hidden" value="${nomeCategoria}" required>
                    <h3 class="h3">
                        ${nomeCategoria}
                        <button type="button" class="btn btn-none p-0" onclick="removerCategoriaConfirm(this)"
                            title="Remover categoria" data-bs-toggle="modal" data-bs-target="#modal-remover-cat">
                            <div class="d-flex">
                                <span class="material-symbols-outlined text-danger">
                                    delete
                                </span>
                            </div>
                        </button>
                    </h3>
                    <!-- Sabores -->
                    <div class="col-12" id="inputs-sabores-${timestamp}">
                        <div class="row mb-3  pt-2">
                            <!-- imagem -->
                            <div class="col-6 col-lg-2 overflow-hidden "
                                style="max-width: 110px; max-height: 110px; min-height: 110px">
                                <label for="img-sabor-x-${timestamp}" class="form-label position-relative  ">
                                    <span class="visually-hidden">Selecionar imagem</span>
                                    <img src="{{ asset('assets/img/pizza/pizza-empty.png') }}" alt=""
                                        id="img-sabor-tag-${timestamp}" class="w-100 rounded-3 img-pizza-sabor "
                                        style="max-width: 110px;">
                                    <div
                                        class="rounded-3 position-absolute top-0 add-imgs d-flex align-items-center justify-content-center">
                                        <span class="material-symbols-outlined fs-2 text-dark opacity-75">
                                            add_circle
                                        </span>
                                    </div>
                                </label>
                                <input type="file" class="d-none" name="sabores[${timestamp}][itens][img][]" id="img-sabor-x-${timestamp}"
                                    onchange="setImgFileChange('img-sabor-x-${timestamp}', 'img-sabor-tag-${timestamp}')"
                                    accept="image/*">
                            </div>
                            <!-- sabor -->
                            <div class="col-12 col-lg-4 col-xl-4 mb-3">
                                <input type="text"
                                    class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                    name="sabores[${timestamp}][itens][sabor][]" placeholder="Sabor" maxlength="255" required>

                                <div class="mt-2">
                                    <input type="text"
                                        class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                        name="sabores[${timestamp}][itens][descricao][]" placeholder="Descrição (opcional)" maxlength="1000">
                                </div>
                            </div>
                            <!-- valor -->
                            <div class="col-12 col-lg-2 col-xl-2 mb-3">
                                <input type="text"
                                    class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                    name="sabores[${timestamp}][itens][valor][]" placeholder="Valor" id="valor-inicial-${timestamp}" maxlength="20"
                                    required>
                            </div>
                            <div class="col-12">
                                <hr>
                            </div>
                        </div>
                    </div>
                    <!-- add mais -->
                    <div class="col-12 mb-3 pt-2">
                        <div class="">
                            <button type="button" class="btn btn-secondary bg-secondary rounded-3 px-2 py-1"
                                onclick="addSabor('${timestamp}')">
                                <div class="d-flex gap-1 align-items-center text-white">
                                    <span class="material-symbols-outlined " style="font-size: 18px">
                                        add_circle
                                    </span>
                                    Mais
                                </div>
                            </button>
                        </div>
                    </div>
                    <hr class="mb-3 mt-3" style="border-width: 5px ">
                </div> `


        let div = document.createElement("div")
        div.innerHTML = html

        let listaCat = document.getElementById('lista-categorias')
        listaCat.append(div)

        maskValor(`valor-inicial-${timestamp}`);

    }

    //validar comapos min e max qtd
    function validMaxMin() {
        let valorMin = document.getElementById('qtd-min').value
        valorMin = valorMin == '' ? 0 : parseInt(valorMin);

        let valorMax = document.getElementById('qtd-max').value
        valorMax = valorMax == '' ? 0 : parseInt(valorMax);

        if (document.getElementById('qtd-max').value != '' && valorMax < valorMin) {
            document.getElementById('qtd-max').classList.add('is-invalid')
            document.getElementById('invalid-feedback-max').innerHTML = `
            A qtd. máxima não poder ser menor que a quantidade mínima
            `

        } else {
            document.getElementById('qtd-max').classList.remove('is-invalid')
        }

        if (document.getElementById('qtd-min').value != '' && valorMin == 0) {
            document.getElementById('qtd-min').classList.add('is-invalid')
            document.getElementById('invalid-feedback-min').innerHTML = ` A qtd. mínima não pode ser 0 `
        } else {
            document.getElementById('qtd-min').classList.remove('is-invalid')
        }
    }

    document.getElementById('qtd-min').onkeyup = function() {
        validMaxMin()
    }
    document.getElementById('qtd-max').onkeyup = function() {
        validMaxMin()
    }

    /* add imagens para deletar */
    function addImgParaDeletar(path = '') {
        let input = document.createElement('input')
        input.value = path
        input.type = 'hidden'
        input.name = 'imgs_deletar[]'
        if (path != '') {
            let elDiv = document.getElementById('imgs-para-deletar')
            elDiv.append(input)
        }

    }
</script>
