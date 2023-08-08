<div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 sabores">
    <div class="row gy-2 dark:text-gray-200">
        <div class="row gy-2">
            <h2 class="col-12 mb-0 fw-semibold h5">Sabores</h2>
            <p class="mb-2 text-muted">
                Adicione quantos sabores quiser e com uma imagem que se encaixe bem para visualizar na montagem da
                pizza.
            </p>
            <!-- Sabores -->
            <div class="col-12" id="inputs-sabores">
                <!-- sabores já cadastrados -->
                @foreach ($sabores as $key => $sabor)
                    <!-- sabor -->
                    <div class="row row mb-3 border-bottom border-secondary pt-2">
                        <input type="hidden" class="bg-dark" name="sabores[id][]" value="{{ $sabor->id }}">
                        <!-- imagem -->
                        <div class="col-6 col-lg-2 overflow-hidden "
                            style="max-width: 110px; max-height: 110px; min-height: 110px">
                            <label for="img-sabor-x-y{{ $key }}"
                                class="form-label position-relative overflow-hidden ">
                                <span class="visually-hidden">Selecionar imagem</span>
                                <img src="{{ asset($sabor->img ?? 'assets/img/pizza/pizza-empty.png') }}" alt=""
                                    id="img-sabor-tag-y{{ $key }}" class="w-100 rounded-3 img-pizza-sabor "
                                    style="max-width: 110px;">
                                <div
                                    class="rounded-3 position-absolute top-0 add-imgs d-flex align-items-center justify-content-center">
                                    <span class="material-symbols-outlined fs-2 text-dark opacity-75">
                                        add_circle
                                    </span>
                                </div>
                            </label>
                            <input type="file" class="d-none" name="sabores[img][]"
                                id="img-sabor-x-y{{ $key }}"
                                onchange="setImgFileChange('img-sabor-x-y{{ $key }}', 'img-sabor-tag-y{{ $key }}')"
                                accept="image/*">
                        </div>
                        <div class="col-12 col-lg-4 col-xl-4 mb-3">
                            <input type="text"
                                class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="sabores[sabor][]" placeholder="Sabor" value="{{ $sabor->sabor }}" maxlength="255"
                                required>
                            <div class="mt-2">
                                <input type="text"
                                    class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                    name="sabores[descricao][]" placeholder="Descrição (opcional)"
                                    value="{{ $sabor->descricao }}" maxlength="1000">
                            </div>
                        </div>
                        <!-- valor -->
                        <div class="col-12 col-lg-2 col-xl-2 mb-3">
                            <input type="text"
                                class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="sabores[valor][]" placeholder="Valor" value="{{ $sabor->valor }}" maxlength="20"
                                id="input-sabor-x{{ $sabor->id }}" required>
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
                @if ($sabores->count() == 0)
                    <div class="row mb-3 border-bottom border-secondary pt-2">
                        <!-- imagem -->
                        <div class="col-6 col-lg-2 overflow-hidden "
                            style="max-width: 110px; max-height: 110px; min-height: 110px">
                            <label for="img-sabor-x-xx2" class="form-label position-relative  ">
                                <span class="visually-hidden">Selecionar imagem</span>
                                <img src="{{ asset('assets/img/pizza/pizza-empty.png') }}" alt=""
                                    id="img-sabor-tag-xx2" class="w-100 rounded-3 img-pizza-sabor "
                                    style="max-width: 110px;">
                                <div
                                    class="rounded-3 position-absolute top-0 add-imgs d-flex align-items-center justify-content-center">
                                    <span class="material-symbols-outlined fs-2 text-dark opacity-75">
                                        add_circle
                                    </span>
                                </div>
                            </label>
                            <input type="file" class="d-none" name="sabores[img][]" id="img-sabor-x-xx2"
                                onchange="setImgFileChange('img-sabor-x-xx2', 'img-sabor-tag-xx2')" accept="image/*">
                        </div>
                        <!-- sabor -->
                        <div class="col-12 col-lg-4 col-xl-4 mb-3">
                            <input type="text"
                                class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="sabores[sabor][]" placeholder="Sabor" maxlength="255" required>

                            <div class="mt-2">
                                <input type="text"
                                    class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                    name="sabores[descricao][]" placeholder="Descrição (opcional)" maxlength="1000">
                            </div>
                        </div>
                        <!-- valor -->
                        <div class="col-12 col-lg-2 col-xl-2 mb-3">
                            <input type="text"
                                class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                name="sabores[valor][]" placeholder="Valor" id="valor_inicial" maxlength="20" required>
                        </div>


                    </div>
                @endif
            </div>
            <!-- add mais -->
            <div class="col-12 mb-3 pt-2">
                <div class="">
                    <button type="button" class="btn btn-warning bg-warning rounded-3 px-2 py-1"
                        onclick="addSabor()">
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

    function addSabor() {
        count++;
        let div = document.createElement("div")
        div.className = 'row mb-3 border-bottom border-secondary pt-2'
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
            <input type="file" class="d-none" name="sabores[img][]"
                id="img-sabor-x-${count}"
                onchange="setImgFileChange('img-sabor-x-${count}', 'img-sabor-tag-${count}')" accept="image/*">
        </div>
        <!-- sabor -->
        <div class="col-12 col-lg-4 col-xl-4 mb-3">
            <input type="text"
                class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                name="sabores[sabor][]" placeholder="Sabor" maxlength="255" required>
                <div class="mt-2">
                    <input type="text"
                        class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                        name="sabores[descricao][]" placeholder="Descrição (opcional)" maxlength="1000">
                </div>
        </div>
        <!-- valor -->
        <div class="col-12 col-lg-2 col-xl-2 mb-3">
            <input type="text"
                class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                name="sabores[valor][]" placeholder="Valor" maxlength="20" id="input-${count}" required>
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

        document.getElementById('inputs-sabores').append(div)
        maskValor('input-' + count);
    }
</script>
