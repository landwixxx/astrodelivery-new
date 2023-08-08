@extends('layouts.front.loja.app', ['store' => $store])
@if (request()->get('s'))
    @section('titulo', request()->get('s') . ' - ' . $store->nome)
@else
    @section('titulo', $store->nome)
@endif

@section('content')
    <!-- Cabeçalho -->
    <section>
        <x-loja.cabecalho :store="$store" />
    </section>

    @if (session('error'))
        <div class="container mt-3">
            <x-alert-error />
        </div>
    @endif

    <!-- Pesquisar -->
    <x-loja.pesquisa :store="$store" />

    <!-- Categorias -->
    <x-loja.categorias :store="$store" :categories="$categories" />

    <!-- Produtos -->
    <section>
        <x-loja.produtos.lista-produtos :store="$store" :products="$products" />
    </section>

    <!-- Modal ver imagem de produto ampliada -->
    <x-loja.produtos.modal-ver-img-ampliada />

    <!-- Banner 3 -->
    <x-loja.banner_3 :store="$store" />




@endsection

@section('scripts')

    <!-- Modal loja fechada -->
    <x-loja.loja_fechada :store="$store" />

    <!-- scripts loja -->
    <script src="{{ asset('assets/js/loja.js') }}"></script>

@endsection
