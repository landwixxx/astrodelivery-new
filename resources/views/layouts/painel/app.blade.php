<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="pt-BR">

<head>
    <title>@yield('title') - Painel Astro Delivery</title>

    <!-- Meta Tags -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon/favicon-32x32.png') }}" />
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="{{ asset('assets/js/init-alpine.js') }}"></script>

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-5.2.1/css/bootstrap.min.css') }}">
    <!-- tailwindcss -->
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.4/dist/flowbite.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind.output.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/painel.css') }}">

    <!-- Extras -->
    @yield('head')

</head>

<body class="painel-admin">

    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">

        <!-- Sidebar -->
        @include('layouts.painel._sidebar')


        <div class="flex flex-col flex-1 w-full">
            <!-- Header -->
            @include('layouts.painel._header')

            <!-- Conteúdo -->
            <main class="h-full overflow-y-auto">
                @yield('content')
            </main>

        </div>
    </div>

    <!-- scrtipts -->
    <!-- flowbite para usar com Tailwind  -->
    <script src="https://unpkg.com/flowbite@1.5.4/dist/flowbite.js"></script>
    <!-- Script Bootstrap -->
    <script src="{{ asset('assets/bootstrap-5.2.1/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/painel.js') }}"></script>

    @hasanyrole('lojista|funcionario')
        @can('visualizar pedidos')
            <!-- Notificação de novos pedidos -->
            <x-notify-new-order />
        @endcan
    @endhasanyrole

    <!-- scripts incorporados -->
    @yield('scripts')

</body>

</html>
