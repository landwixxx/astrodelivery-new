@extends('layouts.front.app', [
    'logo' => 'assets/img/ilu-logo-food.png',
    'nome_loja' => 'Food Delivery',
])
@section('titulo', 'Modificar Senha - ' . config('app.name', 'Web Site'))
@section('content')


<div class="container my-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-4 mx-auto">
            <div class="card border bg-light">
                <div class="card-body p-lg-4">

                    <h1 class="mb-3 h3">{{ __('Reset Password') }}</h1>
                    
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3 col-12">
                            <label for="email" class=" col-form-label ">{{ __('Email Address') }}</label>

                            <div class="">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 col-12">
                            <label for="password" class=" col-form-label ">{{ __('Password') }}</label>

                            <div class="">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 col-12">
                            <label for="password-confirm" class=" col-form-label ">{{ __('Confirm Password') }}</label>

                            <div class="">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class=" ">
                                <button type="submit" class="btn btn-primary w-100">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
