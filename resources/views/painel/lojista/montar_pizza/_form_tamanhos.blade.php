<div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 tamanhos">
    <div class="row gy-2 dark:text-gray-200">
        <div class="row gy-2">
            <h2 class="h5 mb-0 fw-semibold ">Tamanhos</h2>
            <p class="mb-2 text-muted">
                Adicione tamanhos de pizza e a quantidade de bordas permitidas para cada tamanho.
            </p>
            <!-- tamanhos -->
            <div class="col-12" id="inputs-tamanhos">
                <!-- tamanhos já cadastrados -->
                @foreach ($tamanhos as $key => $tamanho)
                    <!-- tamanho -->
                    <div class="row row mb-3 border-bottom border-secondary pt-2">
                        <input type="hidden" class="bg-dark" name="tamanhos[id][]" value="{{ $tamanho->id }}">
                        <!-- imagem -->
                        <div class="col-6 col-lg-2 d-none overflow-hidden "
                            style="max-width: 110px; max-height: 110px; min-height: 110px">
                            <label for="img-tamanho-x-y{{ $key }}"
                                class="form-label position-relative overflow-hidden ">
                                <span class="visually-hidden">Selecionar imagem</span>
                                <img src="{{ asset($tamanho->img ?? 'assets/img/img-prod-vazio.png') }}" alt=""
                                    id="img-tamanho-tag-y{{ $key }}" class="w-100 rounded-3 "
                                    style="max-width: 110px;">
                                <div
                                    class="rounded-3 position-absolute top-0 add-imgs d-flex align-items-center justify-content-center">
                                    <span class="material-symbols-outlined fs-2 text-dark opacity-75">
                                        add_circle
                                    </span>
                                </div>
                            </label>
                            <input type="file" class="d-none" name="tamanhos[img][]"
                                id="img-tamanho-x-y{{ $key }}"
                                onchange="setImgFileChange('img-tamanho-x-y{{ $key }}', 'img-tamanho-tag-y{{ $key }}')"
                                accept="image/*">
                        </div>
                        <div class="col-12 col-lg-4 col-xl-4 mb-3">
                            <input type="text"
                                class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="tamanhos[tamanho][]" placeholder="Nome do tamanho" value="{{ $tamanho->tamanho }}"
                                maxlength="255" required>
                        </div>
                        <!-- qtq max sabores -->
                        <div class="col-12 col-lg-4 col-xl-3 mb-3">
                            <input type="text"
                                class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="tamanhos[max_sabores][]" id="input-tamanho-qtd-x{{ $tamanho->id }}"
                                value="{{ $tamanho->max_sabores }}" placeholder="Qtd. Máximo de sabores" maxlength="255"
                                required>
                        </div>
                        <!-- valor -->
                        <div class="col-12 col-lg-2 col-xl-2 mb-3">
                            <input type="text"
                                class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="tamanhos[valor][]" placeholder="Valor" value="{{ $tamanho->valor }}"
                                maxlength="20" id="input-tamanho-x{{ $tamanho->id }}" required>
                        </div>
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
                    </div>
                @endforeach
                @if ($tamanhos->count() == 0)
                    <div class="row mb-3 border-bottom border-secondary pt-2">
                        <!-- imagem -->
                        <div class="col-6 col-lg-2 d-none overflow-hidden "
                            style="max-width: 110px; max-height: 110px; min-height: 110px">
                            <label for="img-tamanho-x-xx2" class="form-label position-relative  ">
                                <span class="visually-hidden">Selecionar imagem</span>
                                <img src="{{ asset('assets/img/img-prod-vazio.png') }}" alt=""
                                    id="img-tamanho-tag-xx2" class="w-100 rounded-3 " style="max-width: 110px;">
                                <div
                                    class="rounded-3 position-absolute top-0 add-imgs d-flex align-items-center justify-content-center">
                                    <span class="material-symbols-outlined fs-2 text-dark opacity-75">
                                        add_circle
                                    </span>
                                </div>
                            </label>
                            <input type="file" class="d-none" name="tamanhos[img][]" id="img-tamanho-x-xx2"
                                onchange="setImgFileChange('img-tamanho-x-xx2', 'img-tamanho-tag-xx2')"
                                accept="image/*">
                        </div>
                        <!-- tamanho -->
                        <div class="col-12 col-lg-4 col-xl-4 mb-3">
                            <input type="text"
                                class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="tamanhos[tamanho][]" placeholder="Nome do tamanho" maxlength="255" required>
                        </div>
                        <div class="col-12 col-lg-4 col-xl-3 mb-3">
                            <input type="text"
                                class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="tamanhos[max_sabores][]" id="tamanho-1" placeholder="Qtd. Máximo de sabores"
                                maxlength="255" required>
                        </div>
                        <!-- valor -->
                        <div class="col-12 col-lg-2 col-xl-2 mb-3">
                            <input type="text"
                                class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="tamanhos[valor][]" placeholder="Valor" id="valor_inicial_tamanho" maxlength="20"
                                required>
                        </div>
                    </div>
                @endif
            </div>
            <!-- add mais -->
            <div class="col-12 mb-3 pt-2">
                <div class="">
                    <button type="button" class="btn btn-warning bg-warning rounded-3 px-2 py-1"
                        onclick="tamanho()">
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

    function tamanho() {
        count++;
        let div = document.createElement("div")
        div.className = 'row mb-3 border-bottom border-secondary pt-2'
        div.innerHTML = `
        <!-- imagem -->
        <div class="col-6 col-lg-2 d-none overflow-hidden " style="max-width: 110px; max-height: 110px; min-height: 110px">
            <label for="img-tamanho-x-${count}"
                class="form-label position-relative overflow-hidden ">
                <span class="visually-hidden">Selecionar imagem</span>
                <img src="{{ asset('assets/img/img-prod-vazio.png') }}" alt=""
                    id="img-tamanho-tag-${count}" class="w-100 rounded-3 "
                    style="max-width: 110px;">
                <div
                    class="rounded-3 position-absolute top-0 add-imgs d-flex align-items-center justify-content-center">
                    <span class="material-symbols-outlined fs-2 text-dark opacity-75">
                        add_circle
                    </span>
                </div>
            </label>
            <input type="file" class="d-none" name="tamanhos[img][]"
                id="img-tamanho-x-${count}"
                onchange="setImgFileChange('img-tamanho-x-${count}', 'img-tamanho-tag-${count}')" accept="image/*">
        </div>
        <!-- tamanho -->
        <div class="col-12 col-lg-4 col-xl-4 mb-3">
            <input type="text"
                class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                name="tamanhos[tamanho][]" placeholder="Nome do tamanho" maxlength="255" required>
        </div>
        <div class="col-12 col-lg-4 col-xl-3 mb-3">
            <input type="text"
                class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                name="tamanhos[max_sabores][]" id="input-tamanho-qtd-${count}" placeholder="Qtd. Máximo de sabores" maxlength="255" required>
        </div>
        <!-- valor -->
        <div class="col-12 col-lg-2 col-xl-2 mb-3">
            <input type="text"
                class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                name="tamanhos[valor][]" placeholder="Valor" maxlength="20" id="input-${count}" required>
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

        document.getElementById('inputs-tamanhos').append(div)
        maskValor('input-' + count);
        maskNumber('input-tamanho-qtd-' + count);
    }
</script>
