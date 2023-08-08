<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Loja desativada</title>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Icons FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- Styles -->
    <link href="{{ asset('assets/bootstrap-5.2.1/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>

<body class="">

    <main>
        <div class="container mt-5 text-center">
            
            <h1 class="pt-4">Loja desativada</h1>
            <p class="lead">
                Se você acha que isso foi um
                erro, por favor entre em contato com o suporte para mais informações.
            </p>
            <a href="{{url('/')}}#contate-nos" class="btn btn-primary rounded-0 px-4">Entre em contato com o suporte</a>
        </div>
    </main>

</body>

</html>
