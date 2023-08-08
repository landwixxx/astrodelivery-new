@extends('layouts.front.app', [
    'logo' => 'assets/img/ilu-logo-food.png',
    'nome_loja' => 'Food Delivery',
])
@section('titulo', 'Modificar Senha - ' . config('app.name', 'Web Site'))
@section('content')

<div class="container my-5 pt-5">
    <div class="row justify-content-center pb-5 pt-4">
        <div class="col-md-8">
            <div class="card border bg-light">

                <div class="card-body p-lg-4">
                    <h1 class="h3">{{ __('Reset Password') }}</h1>
                    
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class=" mb-3">
                            <label for="email" class=" col-form-label">{{ __('Email Address') }}</label>

                            <div class="">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class=" mb-0">
                            <div class="">
                                <button type="submit" class="btn btn-primary px-4">
                                    {{ __('Send Password Reset Link') }}
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
