<div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 bordas">
    <div class="row gy-2 dark:text-gray-200">
        <div class="row gy-2">
            <h2 class="h5 mb-0 col-12 fw-semibold ">Sabores da borda</h2>
            <p class="mb-2 text-muted">
                Adicione quantos sabores de bordas desejar, a quantidade de bordas que podem ser escolhidas depende da
                quantidade de sabores selecionados na hora de montar a pizza.
            </p>
            <!-- bordas -->
            <div class="col-12" id="inputs-bordas">
                <!-- bordas -->
                @isset($product->pizza_product->bordas)
                    @foreach ($product->pizza_product->bordas as $key => $item)
                        <div class="row mb-3 border-bottom border-secondary pt-2">
                            <!-- imagem -->
                            <div class="col-6 col-lg-2 overflow-hidden "
                                style="max-width: 110px; max-height: 110px; min-height: 110px">
                                <label for="img-borda-x-xx2{{ $key }}" class="form-label position-relative  ">
                                    <span class="visually-hidden">Selecionar imagem</span>
                                    <img src="{{ asset($item['imagem'] ?? 'assets/img/pizza/pizza-empty.png') }}"
                                        alt="" id="img-borda-tag-xx2{{ $key }}"
                                        class="w-100 rounded-3 img-pizza-borda " style="max-width: 110px;">
                                    <div
                                        class="rounded-3 position-absolute top-0 add-imgs d-flex align-items-center justify-content-center">
                                        <span class="material-symbols-outlined fs-2 text-dark opacity-75">
                                            add_circle
                                        </span>
                                    </div>
                                </label>
                                <input type="file" class="d-none" name="bordas[img][]"
                                    id="img-borda-x-xx2{{ $key }}"
                                    onchange="setImgFileChange('img-borda-x-xx2{{ $key }}', 'img-borda-tag-xx2{{ $key }}')"
                                    accept="image/*">
                                <!-- Path img -->
                                <input type="hidden" name="bordas[img_edit][]" value="{{ $item['imagem'] }}">
                            </div>
                            <!-- borda -->
                            <div class="col-12 col-lg-4 col-xl-4 mb-3">
                                <input type="text"
                                    class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                    name="bordas[borda][]" value="{{ $item['borda'] }}" placeholder="Borda" maxlength="255"
                                    required>

                                <div class="mt-2">
                                    <input type="text"
                                        class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                        name="bordas[descricao][]" value="{{ $item['descricao'] }}"
                                        placeholder="Descrição (opcional)" maxlength="1000">
                                </div>
                            </div>
                            <!-- valor -->
                            <div class="col-12 col-lg-2 col-xl-2 mb-3">
                                <input type="text" id="valor-borda-abc-{{ $key }}"
                                    class="valor-borda form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                    name="bordas[valor][]" value="{{ $item['valor'] }}" placeholder="Valor" maxlength="20"
                                    required>
                            </div>
                            @if ($key != 0)
                                <!-- remover -->
                                <div class="col-12 col-lg-2 col-xl-2 mb-3" style="padding-top: 2px">
                                    <button type="button" class="btn btn-danger bg-danger btn-sm p-2 py-1 rounded-3"
                                        onclick="removerItem(this)">
                                        <div class="d-flex">
                                            <span class="material-symbols-outlined">
                                                delete
                                            </span>
                                        </div>
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endisset
            </div>
            <!-- add mais -->
            <div class="col-12 mb-3 pt-2">
                <div class="">
                    <button type="button" class="btn btn-warning bg-warning rounded-3 px-2 py-1" onclick="borda()">
                        <div class="d-flex gap-1 align-items-center text-dark">
                            <span class="material-symbols-outlined " style="font-size: 18px">
                                add_circle
                            </span>
                            Mais
                        </div>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    var count = 0;

    function borda() {
        count++;
        let div = document.createElement("div")
        div.className = 'row mb-3 border-bottom border-secondary pt-2'
        div.innerHTML = `
        <!-- imagem -->
        <div class="col-6 col-lg-2 overflow-hidden " style="max-width: 110px; max-height: 110px; min-height: 110px">
            <label for="img-borda-x-${count}"
                class="form-label position-relative overflow-hidden ">
                <span class="visually-hidden">Selecionar imagem</span>
                <img src="{{ asset('assets/img/pizza/pizza-empty.png') }}" alt=""
                    id="img-borda-tag-${count}" class="w-100 rounded-3 img-pizza-borda "
                    style="max-width: 110px;">
                <div
                    class="rounded-3 position-absolute top-0 add-imgs d-flex align-items-center justify-content-center">
                    <span class="material-symbols-outlined fs-2 text-dark opacity-75">
                        add_circle
                    </span>
                </div>
            </label>
            <input type="file" class="d-none" name="bordas[img][]"
                id="img-borda-x-${count}"
                onchange="setImgFileChange('img-borda-x-${count}', 'img-borda-tag-${count}')" accept="image/*">
        </div>
        <!-- borda -->
        <div class="col-12 col-lg-4 col-xl-4 mb-3">
            <input type="text"
                class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                name="bordas[borda][]" placeholder="Borda" maxlength="255" required>
                <div class="mt-2">
                    <input type="text"
                        class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                        name="bordas[descricao][]" placeholder="Descrição (opcional)" maxlength="1000">
                </div>
        </div>
        <!-- valor -->
        <div class="col-12 col-lg-2 col-xl-2 mb-3">
            <input type="text"
                class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                name="bordas[valor][]" placeholder="Valor" maxlength="20" id="input-${count}" required>
        </div>
        <!-- remover -->
        <div class="col-12 col-lg-2 col-xl-2 mb-3" style="padding-top: 2px">
            <button type="button" class="btn btn-danger bg-danger btn-sm p-2 py-1 rounded-3" onclick="removerItem(this)">
                <div class="d-flex">
                    <span class="material-symbols-outlined">
                        delete
                    </span>
                </div>
            </button>
        </div>
    `;

        document.getElementById('inputs-bordas').append(div)
        maskValor('input-' + count);
    }
</script>
