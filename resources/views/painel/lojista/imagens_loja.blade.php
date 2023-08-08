@extends('layouts.painel.app')
@section('title', 'Imagens da loja')
@section('head')
    <style>
        @media (min-width: 992px) {
            body,
            html {
                overflow: hidden;
            }
        }
    </style>
@endsection
@section('content')
    <br>

    {{-- Alertas --}}
    <x-alerts />

    <div class="container-fluid px-6 mx-auto grid mb-5">
        <h1 class="my-2 fs-4 mb-3 font-semibold text-gray-700 dark:text-gray-200">
            Imagens da loja
        </h1>

        <!-- Cadastrar imagens -->
        <div class="px-4 py-4 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h2 class="dark:text-gray-200 h5 mb-3 fw-bold">Cadastrar imagens</h2>
            <!-- Formulário -->
            <form action="{{ route('painel.lojista.imagens-da-loja.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Logomarca -->
                    <div class="mb-3 col-12 col-lg-6">
                        <label for="logo" class="form-label dark:text-gray-200 ">Logomarca</label>
                        <div class="d-flex gap-2 flex-column flex-lg-row flex-wrap flex-lg-nowrap align-items-start">
                            <div class="">
                                <img src="{{ asset(is_null($store) || is_null($store->logo) ? 'assets/img/img-exemplo.png' : 'storage/' . $store->logo) }}"
                                    id="img-previa" class="img-thumbnail" alt="" class="w-100"
                                    style="max-width: 140px">
                            </div>
                            <div class="w-100">

                                <button type="button"
                                    class="btn btn-warning bg-warning d-flex gap-1 align-items-center px-4 rounded-pill"
                                    onclick="document.getElementById('logo').click()">
                                    <span class="material-symbols-outlined fs-5">
                                        add_photo_alternate
                                    </span>
                                    Selecionar
                                </button>

                                <input type="file"
                                    class="form-control d-none @error('logo') is-invalid @enderror block w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    accept="image/*" name="logo" id="logo" onchange="onFileChange()">
                                @error('logo')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- imagem de fundo -->
                    <div class="mb-3 col-12 col-lg-6">
                        <label for="imagem_bg" class="form-label dark:text-gray-200 ">Imagem de fundo</label>
                        <div class="d-flex gap-2 flex-column flex-lg-row flex-wrap flex-lg-nowrap align-items-start">
                            <div class="">
                                <img src="{{ asset(is_null($store) || is_null($store->imagem_bg) ? 'assets/img/img-exemplo.png' : 'storage/' . $store->imagem_bg) }}"
                                    id="img-bg-previa" class="img-thumbnail" alt="" class="w-100"
                                    style="max-width: 140px">
                            </div>
                            <div class="w-100">
                                <button type="button"
                                    class="btn btn-warning bg-warning d-flex gap-1 align-items-center px-4 rounded-pill"
                                    onclick="document.getElementById('imagem_bg').click()">
                                    <span class="material-symbols-outlined fs-5">
                                        add_photo_alternate
                                    </span>
                                    Selecionar
                                </button>
                                <input type="file"
                                    class="form-control d-none @error('imagem_bg') is-invalid @enderror block w-full text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    accept="image/*" name="imagem_bg" id="imagem_bg" onchange="onFileChangeImgBG()">
                                @error('imagem_bg')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary bg-primary px-5">
                        Salvar
                    </button>
                </div>

            </form>
        </div>

        <!-- Banners promocionais -->
        <div class="px-4 py-4 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <h2 class="dark:text-gray-200 h5 mb-3 fw-bold">Banners promocionais</h2>

            <div class="row">

                <!-- Banner 1 -->
                <div class="mb-3 col-12 col-lg-12">
                    <label for="" class="form-label dark:text-gray-200 d-flex gap-1 align-items-center">
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
                    </label>
                    <div
                        class="d-flex justify-content-center justify-content-lg-start gap-3 flex-column flex-lg-row flex-wrap flex-lg-nowrap align-items-start dark:text-gray-200">
                        <div class="">
                            <a target="_blank"
                                href="{{ isset($banners['banner_posicao1']->link) ? $banners['banner_posicao1']->link : '' }}"
                                class="">
                                <img src="{{ asset($banners['banner_posicao1'] != null ? $banners['banner_posicao1']->img : 'assets/img/img-exemplo.png') }}"
                                    id="img-previa-banner" class="img-thumbnail" alt="" class="w-100"
                                    style="max-width: 140px; min-width: 140px">
                            </a>
                        </div>
                        <div class="w-100">

                            <!-- Selecionar -->
                            <a href="{{ route('painel.lojista.imagens-da-loja.selecionar-banner', ['posicao' => 1]) }}"
                                class="btn btn-warning bg-warning  px-4 rounded-pill mb-1">
                                <div class="d-flex gap-1 align-items-center">
                                    <span class="material-symbols-outlined fs-5">
                                        photo
                                    </span>
                                    Selecionar imagem
                                </div>
                            </a>

                            @if ($banners['banner_posicao1'] != null)
                                @if ($banners['banner_posicao1']->status == 'desativado')
                                    <!-- Ativar -->
                                    <a href="{{ route('painel.lojista.imagens-da-loja.ativar-banner', $banners['banner_posicao1']->id) }}"
                                        class="btn btn-success bg-success px-4 rounded-pill mb-1">
                                        <div class="d-flex gap-1 align-items-center">
                                            <span class="material-symbols-outlined fs-5">
                                                check_circle
                                            </span>
                                            Ativar
                                        </div>
                                    </a>
                                @else
                                    <!-- Desativar -->
                                    <a href="{{ route('painel.lojista.imagens-da-loja.desativar-banner', $banners['banner_posicao1']->id) }}"
                                        class="btn btn-danger bg-danger px-4 rounded-pill mb-1">
                                        <div class="d-flex gap-1 align-items-center">
                                            <span class="material-symbols-outlined fs-5">
                                                visibility_off
                                            </span>
                                            Desativar
                                        </div>
                                    </a>
                                @endif
                            @endif

                            @if ($banners['banner_posicao1'] != null)
                                @if ($banners['banner_posicao1']->status == 'ativo')
                                    <div class="mt-2 pt-2">
                                        Status: <span class="badge rounded-pill text-bg-success">Ativado</span>
                                    </div>
                                @else
                                    <div class="mt-2 pt-2">
                                        Status: <span class="badge rounded-pill text-bg-danger">Dasativado</span>
                                    </div>
                                @endif
                            @endif

                        </div>
                    </div>
                </div>

                <!-- Banner 2 -->
                <div class="mb-3 col-12 col-lg-12">
                    <label for="" class="form-label dark:text-gray-200 d-flex gap-1 align-items-center">
                        Topo, posição 2
                        <span class="d-inline-block " tabindex="0" data-bs-toggle="popover"
                            data-bs-trigger="hover focus"
                            data-bs-content="O banner será exibido em baixo do título e descrição">
                            <a href="#" class="link-warning d-flex align-items-center">
                                <span class="visually-hidden">Informação</span>
                                <span class="material-symbols-outlined fs-16px">
                                    help
                                </span>
                            </a>
                        </span>
                    </label>
                    <div
                        class="d-flex justify-content-center justify-content-lg-start gap-3 flex-column flex-lg-row flex-wrap flex-lg-nowrap align-items-start dark:text-gray-200">
                        <div class="">
                            <a target="_blank"
                                href="{{ isset($banners['banner_posicao2']->link) ? $banners['banner_posicao2']->link : '' }}"
                                class="">
                                <img src="{{ asset($banners['banner_posicao2'] != null ? $banners['banner_posicao2']->img : 'assets/img/img-exemplo.png') }}"
                                    id="img-previa-banner" class="img-thumbnail" alt="" class="w-100"
                                    style="max-width: 140px; min-width: 140px">
                            </a>
                        </div>
                        <div class="w-100">

                            <!-- Selecionar -->
                            <a href="{{ route('painel.lojista.imagens-da-loja.selecionar-banner', ['posicao' => 2]) }}"
                                class="btn btn-warning bg-warning  px-4 rounded-pill mb-1">
                                <div class="d-flex gap-1 align-items-center">
                                    <span class="material-symbols-outlined fs-5">
                                        photo
                                    </span>
                                    Selecionar imagem
                                </div>
                            </a>

                            @if ($banners['banner_posicao2'] != null)
                                @if ($banners['banner_posicao2']->status == 'desativado')
                                    <!-- Ativar -->
                                    <a href="{{ route('painel.lojista.imagens-da-loja.ativar-banner', $banners['banner_posicao2']->id) }}"
                                        class="btn btn-success bg-success px-4 rounded-pill mb-1">
                                        <div class="d-flex gap-1 align-items-center">
                                            <span class="material-symbols-outlined fs-5">
                                                check_circle
                                            </span>
                                            Ativar
                                        </div>
                                    </a>
                                @else
                                    <!-- Desativar -->
                                    <a href="{{ route('painel.lojista.imagens-da-loja.desativar-banner', $banners['banner_posicao2']->id) }}"
                                        class="btn btn-danger bg-danger px-4 rounded-pill mb-1">
                                        <div class="d-flex gap-1 align-items-center">
                                            <span class="material-symbols-outlined fs-5">
                                                visibility_off
                                            </span>
                                            Desativar
                                        </div>
                                    </a>
                                @endif
                            @endif

                            @if ($banners['banner_posicao2'] != null)
                                @if ($banners['banner_posicao2']->status == 'ativo')
                                    <div class="mt-2 pt-2">
                                        Status: <span class="badge rounded-pill text-bg-success">Ativado</span>
                                    </div>
                                @else
                                    <div class="mt-2 pt-2">
                                        Status: <span class="badge rounded-pill text-bg-danger">Dasativado</span>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Banner 3 -->
                <div class="mb-3 col-12 col-lg-12">
                    <label for="" class="form-label dark:text-gray-200 d-flex gap-1 align-items-center">
                        Rodapé, posição 3
                        <span class="d-inline-block " tabindex="0" data-bs-toggle="popover"
                            data-bs-trigger="hover focus" data-bs-content="O banner será exibido em cima do rodapé">
                            <a href="#" class="link-warning d-flex align-items-center">
                                <span class="visually-hidden">Informação</span>
                                <span class="material-symbols-outlined fs-16px">
                                    help
                                </span>
                            </a>
                        </span>
                    </label>
                    <div
                        class="d-flex justify-content-center justify-content-lg-start gap-3 flex-column flex-lg-row flex-wrap flex-lg-nowrap align-items-start dark:text-gray-200">
                        <div class="">
                            <a target="_blank"
                                href="{{ isset($banners['banner_posicao3']->link) ? $banners['banner_posicao3']->link : '' }}"
                                class="">
                                <img src="{{ asset($banners['banner_posicao3'] != null ? $banners['banner_posicao3']->img : 'assets/img/img-exemplo.png') }}"
                                    id="img-previa-banner" class="img-thumbnail" alt="" class="w-100"
                                    style="max-width: 140px; min-width: 140px">
                            </a>
                        </div>
                        <div class="w-100">

                            <!-- Selecionar -->
                            <a href="{{ route('painel.lojista.imagens-da-loja.selecionar-banner', ['posicao' => 3]) }}"
                                class="btn btn-warning bg-warning  px-4 rounded-pill mb-1">
                                <div class="d-flex gap-1 align-items-center">
                                    <span class="material-symbols-outlined fs-5">
                                        photo
                                    </span>
                                    Selecionar imagem
                                </div>
                            </a>

                            @if ($banners['banner_posicao3'] != null)
                                @if ($banners['banner_posicao3']->status == 'desativado')
                                    <!-- Ativar -->
                                    <a href="{{ route('painel.lojista.imagens-da-loja.ativar-banner', $banners['banner_posicao3']->id) }}"
                                        class="btn btn-success bg-success px-4 rounded-pill mb-1">
                                        <div class="d-flex gap-1 align-items-center">
                                            <span class="material-symbols-outlined fs-5">
                                                check_circle
                                            </span>
                                            Ativar
                                        </div>
                                    </a>
                                @else
                                    <!-- Desativar -->
                                    <a href="{{ route('painel.lojista.imagens-da-loja.desativar-banner', $banners['banner_posicao3']->id) }}"
                                        class="btn btn-danger bg-danger px-4 rounded-pill mb-1">
                                        <div class="d-flex gap-1 align-items-center">
                                            <span class="material-symbols-outlined fs-5">
                                                visibility_off
                                            </span>
                                            Desativar
                                        </div>
                                    </a>
                                @endif
                            @endif

                            @if ($banners['banner_posicao3'] != null)
                                @if ($banners['banner_posicao3']->status == 'ativo')
                                    <div class="mt-2 pt-2">
                                        Status: <span class="badge rounded-pill text-bg-success">Ativado</span>
                                    </div>
                                @else
                                    <div class="mt-2 pt-2">
                                        Status: <span class="badge rounded-pill text-bg-danger">Dasativado</span>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>


            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary bg-primary px-5">
                    Salvar
                </button>
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
            let e = document.getElementById('logo')
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
        document.getElementById('logo').onchange = () => {
            onFileChange()
        }
    </script>

    <!-- Prévia baner -->
    <script>
        function onFileChangeBanner() {
            let e = document.getElementById('banner_promocional')
            let files = e.files || e.dataTransfer.files;
            if (!files.length) {
                return
            }
            createImageBanner(files[0])
        }

        function createImageBanner(file) {
            let reader = new FileReader()
            reader.onload = (e) => {
                document.getElementById('img-previa-banner').src = e.target.result
            }
            reader.readAsDataURL(file)
        }
        document.getElementById('banner_promocional').onchange = () => {
            onFileChangeBanner()
        }
    </script>
    <!-- img bg -->
    <script>
        function onFileChangeImgBG() {
            let e = document.getElementById('imagem_bg')
            let files = e.files || e.dataTransfer.files;
            if (!files.length) {
                return
            }
            createImageBG(files[0])
        }

        function createImageBG(file) {
            let reader = new FileReader()
            reader.onload = (e) => {
                document.getElementById('img-bg-previa').src = e.target.result
            }
            reader.readAsDataURL(file)
        }
        document.getElementById('imagem_bg').onchange = () => {
            onFileChangeImgBG()
        }
    </script>
@endsection
