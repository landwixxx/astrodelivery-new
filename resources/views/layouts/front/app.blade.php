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
</head>

<body>

    <!-- Cabeçalho -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm py-1">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}" title="AstroDelivery">
                    <img src="{{ asset('assets/img/astro-delivery-1.png') }}" alt="AstroDelivery" class="logo">
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
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 gap-lg-4">
                            <li class="nav-item">
                                <a class="nav-link fs-5 fw-700 @if (Route::is('pagina-inicial')) active @endif"
                                    href="{{ route('pagina-inicial') }}">Início</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fs-5 fw-700 link-menu" href="{{ url('/#sobre') }}">Sobre</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fs-5 fw-700 link-menu" href="{{ url('/') }}#onde-usar">Onde
                                    Usar?</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fs-5 fw-700 link-menu"
                                    href="{{ url('/') }}#nossos-clientes">Nossos
                                    Clientes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fs-5 fw-700 link-menu"
                                    href="{{ url('/') }}#contate-nos">Contate-nos</a>
                            </li>

                            @hasanyrole('admin|lojista|funcionario')
                                <li class="nav-item dropdown bg-transparent">
                                    <a class="nav-link dropdown-toggle nav-link fs-5 fw-700 d-flex align-items-center"
                                        href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="fa-regular fa-circle-user me-2"></i>
                                        {{ Auth::user()->name }}
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownId">

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
                            @else
                                <li class="nav-item">
                                    <a class="nav-link fs-5 fw-700 @if (Route::is('login')) active @endif "
                                        href="{{ route('login') }}">
                                        Entrar
                                    </a>
                                </li>
                            @endhasanyrole
                        </ul>

                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="text-white pt-5">
            <div class="container py-5 text-center">
                <img src="{{ asset('assets/img/astro-delivery-2.png') }}" alt="Astro Delivery" width="150"
                    class="logo-footer">
                <p class="text-white opacity-50 py-3 fw-light">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro repudiandae animi facere id enim.
                </p>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="#" title="Facebook" class="link-secondary"><i
                            class="fa-brands fa-facebook fa-lg"></i></a>
                    <a href="#" title="Twitter" class="link-secondary"><i
                            class="fa-brands fa-twitter fa-lg"></i></a>
                    <a href="#" title="Instagram" class="link-secondary"><i
                            class="fa-brands fa-instagram fa-lg"></i></a>
                </div>

            </div>
            <div class="border border-bottom-0 border-start-0 border-end-0 border-secondary"
                style="border-style: dashed !important">
                <div class="container py-4 opacity-75 text-center text-white">
                    &copy; {{ date('Y') }} Astro Delivery - Todos os direitos reservados
                </div>
            </div>
        </div>
    </footer>

    <x-aceitar-cookies />

    <!-- Scripts -->
    <!-- Script Bootstrap -->
    <script src="{{ asset('assets/bootstrap-5.2.1/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Script Principal -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <!-- Scripts -->
    @yield('scripts')
    <script>
        /* Para mobile */
        /* Fechar menu Offcanvas ou clicar nos links do menu */
        var bsOffcanvas = new bootstrap.Offcanvas('#offcanvasNavbar')
        for (let i in document.querySelectorAll('.link-menu')) {
            document.querySelectorAll('.link-menu')[i].onclick = function() {
                setTimeout(() => {
                    bsOffcanvas.hide()
                }, 300);
            }
        }
    </script>

</body>

</html>
