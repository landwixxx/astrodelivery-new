<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>O usuário foi desativado</title>
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
            <div class="alert alert-danger">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>
                O usuário foi desativado.
            </div>
            <h1>Desculpe</h1>
            <p>
                Infelizmente, a sua conta de usuário foi desativada. Se você acha que isso foi um
                erro, por favor entre em contato com o suporte para mais informações.
            </p>
            <a href="{{url('/')}}#contate-nos" class="btn btn-primary rounded-0 px-4">Entre em contato com o suporte</a>
        </div>
    </main>

</body>

</html>
