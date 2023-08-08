@extends('layouts.front.app', [
    'logo' => 'assets/img/ilu-logo-food.png',
    'nome_loja' => 'Food Delivery',
])
@section('titulo', 'Entrar - ' . config('app.name', 'Web Site'))
@section('content')

    <div class="container my-5 pt-5">
        <div class="row justify-content-center pb-lg-5 my-lg-5">
            <div class="col-md-4 mx-auto">
                <div class="card bg-light border">
                    <div class="card-body p-lg-4">

                        <div class="alert alert-warning" role="alert">
                            <strong>Usuários para testes</strong><br>
                            email: admin@teste.com<br>
                            email: lojista@teste.com<br>
                            senha: password
                        </div>


                        <h1 class="mb-3 h3">Entrar</h1>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class=" col-form-label ">{{ __('Email Address') }}</label>

                                <div class="">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class=" col-form-label ">{{ __('Password') }}</label>

                                <div class="">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class=" ">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="">
                                    <button type="submit" class="btn btn-primary w-100">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link link-dark w-100 mt-2 small"
                                            href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
