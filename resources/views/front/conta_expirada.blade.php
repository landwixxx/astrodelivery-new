<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Conta expirada</title>
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

<body class="">

    <main>
        <div class="container mt-5">
            
            <h1 class="text-danger h1">Conta expirada</h1>
            <p class="lead">
                O período de teste para sua conta expirou, entre em contato conosco para contratar o serviço.
            </p>
            <a href="{{url('/')}}#contate-nos" class="btn btn-outline-primary rounded-pill px-4">
                Entrar em contato
            </a>
        </div>
    </main>

</body>

</html>
