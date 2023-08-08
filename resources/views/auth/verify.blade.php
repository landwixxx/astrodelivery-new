@extends('layouts.front.loja.app', [
    'logo' => 'assets/img/ilu-logo-food.png',
    'nome_loja' => 'Food Delivery',
])
@section('titulo', 'Verifique seu endereço de e-mail - ' . config('app.name', 'Web Site'))
@section('content')

<div class="container my-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 pb-lg-5">
            <div class="card bg-light border my-lg-5">
                <div class="card-body p-lg-4">

                    <h1 class="h3 mb-3">{{ __('Verify Your Email Address') }}</h1>
                    
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
