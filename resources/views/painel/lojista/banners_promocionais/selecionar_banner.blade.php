@extends('layouts.painel.app')
@section('title', 'Selecionar banner')
@section('head')
@endsection
@section('content')
    <br>

    {{-- Alertas --}}
    <x-alerts />

    <div class="container-fluid px-6 mx-auto grid mb-5">
        <h1 class="my-2 fs-4 mb-3 font-semibold text-gray-700 dark:text-gray-200 ">
            Selecionar banner para:
            <div class=" mt-2">
            <span>
                <span class="fs-6 dark:text-gray-200 d-flex gap-1 align-items-center">
                    @switch(request()->get('posicao'))
                        @case(1)
                            Topo, posição 1
                            <span class="d-inline-block " tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus"
                                data-bs-content="O banner será exibido em cima do título e descrição">
                                <a href="#" class="link-warning d-flex align-items-center">
                                    <span class="visually-hidden">Informação</span>
                                    <span class="material-symbols-outlined fs-16px">
                                        help
                                    </span>
                                </a>
                            </span>
                        @break

                        @case(2)
                            Topo, posição 2
                            <span class="d-inline-block " tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus"
                                data-bs-content="O banner será exibido em baixo do título e descrição">
                                <a href="#" class="link-warning d-flex align-items-center">
                                    <span class="visually-hidden">Informação</span>
                                    <span class="material-symbols-outlined fs-16px">
                                        help
                                    </span>
                                </a>
                            </span>
                        @break

                        @case(3)
                            Rodapé, posição 3
                            <span class="d-inline-block " tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus"
                                data-bs-content="O banner será exibido em cima do rodapé">
                                <a href="#" class="link-warning d-flex align-items-center">
                                    <span class="visually-hidden">Informação</span>
                                    <span class="material-symbols-outlined fs-16px">
                                        help
                                    </span>
                                </a>
                            </span>
                        @break

                        @default
                    @endswitch
                </span>
            </span>
        </div>
        </h1>

        <!-- Banners cadastrados -->
        <div class="px-4 py-4 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h2 class="dark:text-gray-200 h5 mb-3 fw-bold">
                Banners cadastrados
            </h2>
            <!-- Formulário -->
            <form action="{{ route('painel.lojista.imagens-da-loja.selecionar-banner-save') }}" method="post">
                <input type="hidden" value="{{ request()->get('posicao') }}" name="posicao">
                @csrf
                @method('PUT')

                <div class="row g-4 ">
                    <!-- Banners -->
                    @if ($banners->count() == 0)
                        <div class="dark:text-gray-200 text-danger">
                            Nenhum banner cadastrado
                        </div>
                    @endif
                    @foreach ($banners as $key => $item)
                        <div class="col-12 col-lg-3">
                            <input type="radio" class="btn-check" name="banner_id" id="option{{ $key }}"
                                autocomplete="off" value="{{ $item->id }}" required>
                            <label class="btn btn-outline-secondary p-3 w-100" for="option{{ $key }}">

                                <img src="{{ asset($item->img) }}" alt="" class="w-100">

                                <div class="mt-2">

                                    <button type="button" class="btn btn-primary bg-primary">
                                        <span class="d-inline-block " tabindex="0" data-bs-toggle="popover"
                                            data-bs-trigger="hover focus" data-bs-placement="top"
                                            data-bs-content="{{ $item->link }}">
                                            <a href="#" class="link-warning d-flex align-items-center">
                                                Link
                                            </a>
                                        </span>

                                    </button>
                                    <a href="{{ route('painel.lojista.imagens-da-loja.excluir', $item->id) }}"
                                        onclick="return confirm('Tem certeza que deseja excluir este registro?');"
                                        class="btn btn-danger bg-danger">Excluir</a>
                                </div>

                            </label>
                        </div>
                    @endforeach

                </div>

                <div class="mt-4">
                    @if ($banners->count() > 0)
                        <button type="submit" class="btn btn-primary bg-primary px-5">
                            Salvar
                        </button>
                    @endif
                </div>

            </form>
        </div>

        <!-- Cadastrar banner -->
        <div class="px-4 py-4 mt-3 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h2 class="dark:text-gray-200 h5 mb-3 fw-bold">
                Cadastrar banner
            </h2>

            <div class="">
                <!-- Formulário -->
                <form action="{{ route('painel.lojista.imagens-da-loja.cadastrar-banner') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    <div class=" py-3 mb-0 bg-white rounded-lg  dark:bg-gray-800 dark:text-gray-200">
                        <div class="row gy-4 ">

                            <!-- foto -->
                            <div class=" col-12 col-lg-12 dark:text-gray-200 ">
                                <label for="foto">
                                    Foto<span class="text-danger">*</span>
                                </label>
                                <div class="d-flex  gap-2">
                                    <img src="{{ asset('assets/img/img-prod-vazio.png') }}" alt="" width="150"
                                        id="img-previa">
                                    <div class="">
                                        <input type="file" name="img" id="foto"
                                            accept=".jpg,.jpeg,.png,.gif,.bmp,.webp" class="w-100" required>
                                        <div class="fs-11px text-muted pt-1">
                                            Tipos suportados: jpg, jpeg, png, gif, bmp, webp
                                        </div>
                                    </div>
                                </div>
                                @error('img')
                                    <div class="text-danger bold mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- link -->
                            <label class="block col-12 col-lg-12">
                                <span class="text-gray-700 dark:text-gray-200 d-block mb-1">Link<span
                                        class="text-danger">*</span></span>
                                <input type="url" name="link" id="link" value="{{ old('link') }}"
                                    class="form-control @error('link') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                    id="link" placeholder="" required>
                                @error('link')
                                    <div class="invalid-feedback bold">{{ $message }}</div>
                                @enderror
                            </label>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary bg-primary">Cadastrar</button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection

@section('scripts')

    <script>
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
    </script>

    <!-- Prévia de imagem -->
    <script>
        function onFileChange() {
            let e = document.getElementById('foto')
            let files = e.files || e.dataTransfer.files;
            if (!files.length) {
                return
            }
            createImage(files[0])
        }

        function createImage(file) {
            let reader = new FileReader()
            reader.onload = (e) => {
                document.getElementById('img-previa').src = e.target.result
            }
            reader.readAsDataURL(file)
        }
        document.getElementById('foto').onchange = () => {
            onFileChange()
        }
    </script>

@endsection
