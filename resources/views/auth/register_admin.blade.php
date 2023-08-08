<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Cadastro Administrador</title>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Icons FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- Styles -->
    <link href="{{ asset('assets/bootstrap-5.2.1/css/bootstrap.min.css') }}" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-xl-4 mx-auto">
                <div class="card border">
                    <div class="card-header bg-dark text-white fw-bold fs-5 px-4">
                        Cadastro Administrador
                    </div>

                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('auth.register.admin.store') }}">
                            @csrf

                            <div class=" mb-3">
                                <label for="name"
                                    class=" col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class=" mb-3">
                                <label for="email"
                                    class=" col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class=" mb-3">
                                <label for="password"
                                    class=" col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class=" mb-3">
                                <label for="password-confirm"
                                    class=" col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="mb-0 mt-4 text-uppercase">
                                <div class="">
                                    <button type="submit" class="btn btn-warning border border-dark w-100 fw-semibold">
                                        Cadastrar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
