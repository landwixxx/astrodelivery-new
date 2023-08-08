@extends('layouts.front.loja.app', ['store' => $store])
@section('titulo', 'Revisão da Pizza - ' . $store->nome)

@section('content')
    <div class="container py-5 mt-5 pt-4">

        <div class=" mx-auto">
            <x-alert-error />
            <h1 class="h4 mb-4 pb-2 text-dark pt-3">Revisão da Pizza</h1>
        </div>

        <!-- Revisão -->
        <div class="montar-pizza">
            <div class="">
                <div class="row gy-4 gx-lg-4 justify-content-center">

                    <!-- Tamanho -->
                    <div class="col-12 col-lg-4">
                        <div class="border overflow-hidden bg-light rounded-3 p-0 h-100 d-flex flex-column">
                            <div class="p-3">
                                <h2 class="h5 mb-3 fw-normal fs-16px text-uppercase text-center">
                                    Tamanho
                                </h2>
                                <hr>
                                <div class="h4">
                                    <img src="{{ asset('assets/img/icons/check-png.png') }}" alt="" width="20">
                                    {{ $tamanho->tamanho }}
                                </div>
                                <div class="lh-sm mt-4">
                                    <div class="fs-11px text-uppercase" style="margin-bottom: -2px">Valor:</div>
                                    <div class="fw-bold small">R$ <span
                                            class="fs-5 fw-bold">{{ number_format($tamanho->valor, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-auto border-top mt-3 p-3 text-center">

                                <a href="{{ route('loja.montar-pizza.tamanhos', $store->slug_url) }}"
                                    class="btn rounded-1 btn-primary px-4">
                                    <i class="fa-regular fa-pen-to-square fa-ms fs-12px"></i>
                                    Alterar
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Sabores -->
                    <div class="col-12 col-lg-4">
                        <div class="border overflow-hidden bg-light rounded-3 p-0 h-100 d-flex flex-column">
                            <div class="p-3">
                                <h2 class="h5 mb-3 fw-normal fs-16px text-uppercase text-center">
                                    {{ $sabores->count() > 1 ? 'Sabores' : 'Sabor' }}
                                </h2>
                                <hr>

                                <!-- Lista de sabores -->
                                <ul class="list-group list-group-flush ">
                                    @foreach ($sabores as $key => $item)
                                        @php
                                            $session_sabores = session('sabores_id') ?? [];
                                        @endphp
                                        <li class="list-group-item bg-light px-0 py-1 pt-4">
                                            <div class="d-flex gap-2">

                                                <div class="d-flex gap-1 ">
                                                    <div class="pt-3 pe-2">
                                                        <img src="{{ asset('assets/img/icons/check-png.png') }}"
                                                            alt="" width="20">
                                                    </div>

                                                    <div class="me-2">
                                                        <label for="sabor{{ $key }}">
                                                            <img src='{{ asset($item->img ?? 'assets/img/pizza/pizza-empty.png') }}'
                                                                alt=""
                                                                style="width: 70px; height: 70px;border-radius: 50%">
                                                        </label>
                                                    </div>

                                                    <label class="form-check-label  justify-content-between"
                                                        for="sabor{{ $key }}">
                                                        <h3 class="h6 fw-bold mb-0">{{ $item->sabor }}</h3>
                                                        <p class="">
                                                            {{ $item->descricao }}
                                                        </p>
                                                    </label>
                                                </div>
                                                <div class="fw-bold ms-auto">
                                                    <label
                                                        for="sabor{{ $key }}">{{ number_format($item->valor / count(session('sabores_id') ?? [1]), 2, ',', '.') }}</label>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="lh-sm mt-4">
                                    <div class="fs-11px text-uppercase" style="margin-bottom: -2px">Valor:</div>
                                    <div class="fw-bold small">
                                        R$ <span class="fs-5 fw-bold">
                                            {{ number_format($valorSabores, 2, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-auto border-top mt-3 p-3 text-center">
                                <a href="{{ route('loja.montar-pizza.sabores', $store->slug_url) }}"
                                    class="btn rounded-1 btn-primary px-4">
                                    <i class="fa-regular fa-pen-to-square fa-ms fs-12px"></i>
                                    Alterar
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Bordas(s) -->
                    <div class="col-12 col-lg-4">
                        <div class="border overflow-hidden bg-light rounded-3 p-0 h-100 d-flex flex-column">
                            <div class="p-3">
                                <h2 class="h5 mb-3 fw-normal fs-16px text-uppercase text-center">
                                    {{ $bordas->count() > 1 ? 'Bordas' : 'Borda' }}
                                </h2>
                                <hr>

                                <!-- Lista de bordas -->
                                <ul class="list-group list-group-flush ">
                                    @foreach ($bordas as $key => $item)
                                        @php
                                            $session_bordas = session('bordas_id') ?? [];
                                        @endphp
                                        <li class="list-group-item bg-light px-0 py-1 pt-4">
                                            <div class="d-flex gap-2">

                                                <div class="d-flex gap-1 ">
                                                    <div class="pt-3 pe-2">
                                                        <img src="{{ asset('assets/img/icons/check-png.png') }}"
                                                            alt="" width="20">
                                                    </div>

                                                    <div class="me-2">
                                                        <label for="edge{{ $key }}">
                                                            <img src='{{ asset($item->img ?? 'assets/img/pizza/pizza-empty.png') }}'
                                                                alt=""
                                                                style="width: 70px; height: 70px;border-radius: 50%">
                                                        </label>
                                                    </div>

                                                    <label class="form-check-label  justify-content-between"
                                                        for="edge{{ $key }}">
                                                        <h3 class="h6 fw-bold mb-0">{{ $item->borda }}</h3>
                                                        <p class="">
                                                            {{ $item->descricao }}
                                                        </p>
                                                    </label>
                                                </div>
                                                <div class="fw-bold ms-auto">
                                                    <label
                                                        for="edge{{ $key }}">{{ number_format($item->valor / count(session('bordas_id')), 2, ',', '.') }}</label>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="lh-sm mt-4">
                                    <div class="fs-11px text-uppercase" style="margin-bottom: -2px">Valor:</div>
                                    <div class="fw-bold small">
                                        R$ <span class="fs-5 fw-bold">
                                            {{ number_format($valorBordas, 2, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-auto border-top mt-3 p-3 text-center">
                                <a href="{{ route('loja.montar-pizza.bordas', $store->slug_url) }}"
                                    class="btn rounded-1 btn-primary px-4">
                                    <i class="fa-regular fa-pen-to-square fa-ms fs-12px"></i>
                                    Alterar
                                </a>
                            </div>
                        </div>
                    </div>

                    @if (count($adicionais) > 0)
                        <!-- Adicionais -->
                        <div class="col-12">
                            <div class="border overflow-hidden bg-light rounded-3 p-0 h-100 d-flex flex-column">
                                <div class="p-3">
                                    <h2 class="h5 mb-3 fw-normal fs-16px text-uppercase ">
                                        Adicionais
                                    </h2>
                                    <hr>

                                    <div class="row">
                                        <!-- Lista de adicionais -->
                                        @foreach ($adicionais as $item)
                                            <div class="col-12 col-lg-4">
                                                <div
                                                    class=" shadow-sm bg-white my-2 d-flex gap-1 p-3 align-items-center rounded">
                                                    <div class="adicionais w-100">
                                                        <div class="d-flex gap-2 ">
                                                            <div class="">
                                                                <img src="{{ $item['produto']->img_destaque }}"
                                                                    alt="" class="" width="70"
                                                                    style="min-width: 70px">
                                                            </div>
                                                            <!-- Título -->
                                                            <div class="w-100">
                                                                <h3 class="fs-5 mb-1 fw-500">
                                                                    {{ $item['qtd'] }}x {{ $item['produto']->nome }}
                                                                </h3>
                                                                <p class="text-muted fs-14px lh-sm mb-0 pb-0">
                                                                    {{ Str::limit($item['produto']->descricao, 80) }}
                                                                </p>
                                                                <div class="d-flex justify-content-between gap-2 mt-2">
                                                                    <!-- Valor do adicional -->
                                                                    <div class="fw-bold text-danger">
                                                                        <span class="small">R$</span> <span
                                                                            class="fs-5">{{ number_format($item['produto']->valor, 2, ',', '.') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="lh-sm mt-4">
                                        <div class="fs-11px text-uppercase" style="margin-bottom: -2px">Subtotal:</div>
                                        <div class="fw-bold small">
                                            R$ <span class="fs-5 fw-bold">
                                                {{ number_format($totalValorAdicionais, 2, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>

                                </div>
                                <div class="mt-auto border-top mt-3 p-3 text-center">

                                    <a href="{{ route('loja.montar-pizza.adicionais', $store->slug_url) }}"
                                        class="btn rounded-1 btn-primary px-4">
                                        <i class="fa-regular fa-pen-to-square fa-ms fs-12px"></i>
                                        Alterar
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-12 text-end">
                            <a href="{{ route('loja.montar-pizza.adicionais', $store->slug_url) }}"
                                class="btn rounded-1 btn-warning px-4">
                                <i class="fa-solid fa-arrow-rotate-left fa-sm fs-12px "></i>
                                Selecionar Adicionais
                            </a>
                        </div>
                    @endif


                </div>
            </div>
        </div>
        <!-- Prévia do tatal do valor -->
        <div class="col-lg-12   py-3 lh-sm py-4 mt-3">
            <div class="fw-bold text-muted  lh-sm text-upspercase">Valor Total</div>
            <div class="fs-2 fw-bold text-danger lh-sm mb-3">
                <span class="fs-16px">R$</span> <span id="valor-total" class="fw-700">
                    {{ number_format($valorTotalPizza, 2, ',', '.') }}
                </span>
            </div>

            <form action="{{ route('loja.montar-pizza.salvar-pedido', $store->slug_url) }}" method="post">
                @csrf
                <button type="submit" class="btn rounded-pill btn-danger px-4 py-2 fw-bold text-uppercase">
                    <div class="px-2 py-1">
                        <i class="fa-solid fa-cart-plus fa-sm fs-13px me-2"></i>
                        Adicionar ao carrinho
                    </div>
                </button>
            </form>
        </div>
    </div>

@endsection
