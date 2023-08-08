<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>@yield('titulo')</title>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon/favicon-32x32.png') }}" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Icons FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- Styles -->
    <link href="{{ asset('assets/bootstrap-5.2.1/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!--  -->
    @yield('head')
</head>

<body class="loja">

    <!-- Cabeçalho -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm py-1">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ route('loja.index', $store->slug_url) }}"
                    title="{{ $store->nome }}">
                    @if ($store->logo)
                        <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->nome }}" class="logo">
                    @else
                        {{ $store->nome }}
                    @endif
                </a>
                <button class="navbar-toggler border-0 shadow-none d-flex d-lg-none align-items-center" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <i class="fa-solid fa-bars fa-lg"></i>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                    aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <span></span>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <!-- Links -->
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 gap-lg-4">
                            <li class="nav-item">
                                <a class="nav-link fs-6 fw-700 @if (Route::is('loja.index', $store->slug_url)) active @endif"
                                    href="{{ route('loja.index', $store->slug_url) }}">Home</a>
                            </li>
                            <li class="nav-item bg-transparent">
                                <a class="nav-link fs-6 fw-700 " href="#" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvas-sobre" aria-controls="offcanvas-sobre">Sobre</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fs-6 fw-700" href="#" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvas-horario" aria-controls="offcanvas-horario">Horário</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link fs-6 fw-700" href="#" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvas-contato" aria-controls="offcanvas-contato">Contato</a>
                            </li>

                            <!-- Usuário -->
                            @auth
                                <li class="nav-item dropdown bg-transparent">
                                    <a class="nav-link dropdown-toggle nav-link fs-6 fw-700" href="#" id="dropdownId"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa-regular fa-circle-user"></i>
                                        {{ Auth::user()->name }}
                                    </a>
                                    <div class="dropdown-menu links-user" aria-labelledby="dropdownId">
                                        @role('cliente')
                                            <a class="dropdown-item"
                                                href="{{ route('cliente.pedidos-recentes', $store->slug_url) }}">
                                                <i class="fa-solid fa-basket-shopping fs-sm me-1" style="margin-left: -2px"></i>
                                                Pedidos Recentes
                                            </a>
                                            <a class="dropdown-item"
                                                href="{{ route('cliente.meus-dados', $store->slug_url) }}">
                                                <i class="fa-regular fa-user fa-sm me-1"></i> Meus Dados
                                            </a>
                                        @endrole
                                        @role('admin')
                                            <a class="dropdown-item" href="{{ route('painel.admin.index') }}">
                                                <img src="{{ asset('assets/img/icons/dashboard.svg') }}" alt=""
                                                    width="18" class="me-1" style="margin-left: -2px">
                                                Painel
                                            </a>
                                            <a class="dropdown-item" href="{{ route('painel.admin.meus-dados') }}">
                                                <i class="fa-regular fa-user fa-sm me-1"></i> Meus Dados
                                            </a>
                                        @endrole
                                        @hasanyrole('lojista|funcionario')
                                            <a class="dropdown-item" href="{{ route('painel.lojista.index') }}">
                                                <img src="{{ asset('assets/img/icons/dashboard.svg') }}" alt=""
                                                    width="18" class="me-1" style="margin-left: -2px">
                                                Painel
                                            </a>
                                            <a class="dropdown-item" href="{{ route('painel.lojista.meus-dados') }}">
                                                <i class="fa-regular fa-user fa-sm me-1"></i> Meus Dados
                                            </a>
                                        @endhasanyrole

                                        @role('cliente')
                                            <a class="dropdown-item" href="{{ route('cliente.logout', $store->slug_url) }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="fa-solid fa-right-from-bracket fa-sm me-1"></i>
                                                Sair
                                            </a>
                                            <form id="logout-form" action="{{ route('cliente.logout', $store->slug_url) }}"
                                                method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        @else
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="fa-solid fa-right-from-bracket fa-sm me-1"></i>
                                                Sair
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        @endrole
                                    </div>
                                </li>
                            @endauth
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link fs-6 fw-700 @if (Route::is('cliente.login')) active @endif "
                                        href="{{ route('cliente.login', $store->slug_url) }}">
                                        Entrar
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class=" fw-700 btn btn-outline-primary"
                                        href="{{ route('cliente.cadastro', $store->slug_url) }}">
                                        Criar Conta
                                    </a>
                                </li>
                            @endguest
                        </ul>

                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- Lista de pedidos escolhidos -->
    <x-lista-pedidos :store="$store"/>

    <!-- Offcanvas Sobre -->
    @include('layouts.front.loja._sobre', ['store' => $store])
    <!-- Offcanvas Horário -->
    @include('layouts.front.loja._horario', ['store' => $store])
    <!-- Offcanvas Contato -->
    @include('layouts.front.loja._contato', ['store' => $store])

    <!-- Rodapé -->
    @include('layouts.front.loja._footer', ['store' => $store])

    <x-aceitar-cookies/>

    <!-- Scripts -->
    <!-- Script Bootstrap -->
    <script src="{{ asset('assets/bootstrap-5.2.1/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Script Principal -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <!-- Scripts Incorporados -->
    @yield('scripts')

</body>

</html>
