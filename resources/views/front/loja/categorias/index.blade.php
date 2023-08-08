@extends('layouts.front.loja.app', ['store' => $store])
@section('titulo', $category->nome . ' - ' . $store->nome)
@section('content')

    <!-- Cabeçalho -->
    <section>
        <x-loja.cabecalho :store="$store" />
    </section>

    <!-- Pesquisar -->
    <x-loja.pesquisa :store="$store" />

    <!-- Categorias -->
    <x-loja.categorias :store="$store" :categories="$categories" :category="$category" />

    <!-- Produtos -->
    <section>
        <x-loja.produtos.lista-produtos :store="$store" :products="$products" :category="$category" />
    </section>

    <!-- Modal ver imagem de produto ampliada -->
    <x-loja.produtos.modal-ver-img-ampliada />

@endsection

@section('scripts')
    <!-- scripts loja -->
    <script src="{{ asset('assets/js/loja.js') }}"></script>
@endsection
