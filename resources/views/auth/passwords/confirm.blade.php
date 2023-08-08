@extends('layouts.front.app', [
    'logo' => 'assets/img/ilu-logo-food.png',
    'nome_loja' => 'Food Delivery',
])
@section('titulo', 'Confirmação de senha - ' . config('app.name', 'Web Site'))
@section('content')

<div class="container my-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-5 mx-auto pb-lg-5">
            <div class="card border bg-light my-4 mb-lg-5">

                <div class="card-body p-lg-4">

                    <h1 class="mb-3 h3">{{ __('Confirm Password') }}</h1>
                    
                    {{ __('Please confirm your password before continuing.') }}

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class=" mb-3">
                            <label for="password" class=" col-form-label ">{{ __('Password') }}</label>

                            <div class="">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class=" mb-0">
                            <div class="">
                                <button type="submit" class="btn btn-primary px-3">
                                    {{ __('Confirm Password') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link link-dark" href="{{ route('password.request') }}">
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
