@extends('layouts.front.app')
@section('titulo', 'Tenha o seu catálogo de produtos e pedidos na internet - ' . config('app.name', 'Web Site'))
@section('content')

    <!-- Conteúdo Topo -->
    <section>
        <div class="min-vh-100 conteudo-topo mb-3">
            <div class="container pt-5 mt-5">
                <div class="row justify-content-center align-items-center gx-5 text-center text-lg-start pt-3">
                    <div class="col-12 col-lg-6 sorder-2 sorder-lg-1 mb-4 mb-lg-0 order-2 order-lg-1">
                        <h1 class=" fw-bold ">
                            <span class="text-dark">
                                Tenha o seu catálogo de
                                produtos e pedidos na internet</span>
                        </h1>
                        <p class="fs-5 text-muted mb-lg-4 pb-lg-3">
                            Curabitur imperdiet varius lacus, id placerat purus vulputate non. Fusce in felis vel arcu
                            maximus
                            placerat eu ut arcu. Ut nunc ex, gravida vel porttitor et, pretium ac sapien.
                        </p>

                        <a href="{{ route('solicitar-teste-gratis') }}" class="btn btn-blue px-5 py-3 fw-bold text-uppercase">
                            Teste Grátis
                            <i class="fa-solid fa-chevron-right ms-2"></i>
                        </a>

                    </div>
                    <div class="col-12 col-lg-6 sorder-1 sorder-lg-2 pb-5 order-1 order-lg-2">
                        <img src="{{ asset('assets/img/ilustracao-shop-2.svg') }}" alt="" class="w-100">
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Onde Usar -->
    <section id="onde-usar">
        <div class="container py-5">
            <div class="row align-items-center gy-4 gx-lg-5 text-center text-lg-start">
                <div class="col-12 col-lg-6 p-lg-5">
                    <img src="{{ asset('assets/img/ilustracao-online-shop.svg') }}" alt="" class="w-100">
                </div>

                <div class="col-12 col-lg-6 p-lg-5 ">
                    <span class="fw-700 text-uppercase small text-orange" style="letter-spacing: 2px">Onde Usar</span>
                    <h2 class="fs-1 fw-bold mt-1">Praticamente em qualquer setor pode-se usar o Astro Delivery</h2>
                    <p class=" text-muted fs-5">
                        Nosso sistema pode ser utilizado em diversos tipos de negócios,
                        fizemos uma pequena lista dos principais que nossos clientes procuram.
                    </p>
                    <div class="row gy-2 fs-5 pt-2 text-muted fw-500 text-start">
                        <div class="col-6 col-lg-4">
                            <i class="fa-solid fa-circle-check fa-sm me-2 text-success"></i> Lojistas
                        </div>
                        <div class="col-6 col-lg-4">
                            <i class="fa-solid fa-circle-check fa-sm me-2 text-success"></i> Pizzarias
                        </div>
                        <div class="col-6 col-lg-4">
                            <i class="fa-solid fa-circle-check fa-sm me-2 text-success"></i> Autopeças
                        </div>
                        <div class="col-6 col-lg-4">
                            <i class="fa-solid fa-circle-check fa-sm me-2 text-success"></i> Lanches
                        </div>
                        <div class="col-6 col-lg-4">
                            <i class="fa-solid fa-circle-check fa-sm me-2 text-success"></i> Tabacarias
                        </div>
                        <div class="col-6 col-lg-4">
                            <i class="fa-solid fa-circle-check fa-sm me-2 text-success"></i> Vendas em geral
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Acompanhamento de pedidos -->
    <section>
        <div class="bg-blue-light">
            <div class="container py-5 ">
                <div class="row align-items-center gx-lg-5 gy-4">
                    <div class="col-12 col-lg-6 p-lg-5 order-2 order-lg-1 text-center text-lg-start">
                        <span class="fw-700 text-uppercase small text-orange" style="letter-spacing: 2px">
                            Acompanhamento de pedidos
                        </span>
                        <h2 class="fs-1 fw-bold mt-1">
                            Opção de acompanhamento de pedidos através do painel administrativo
                        </h2>
                        <p class=" text-muted fs-5">
                            Temos um painel administrativo super simples e agradável para você acompanhar os pedidos de
                            seus clientes em tempo real.
                        </p>
                    </div>
                    <div class="col-12 col-lg-6 p-lg-5 order-1 order-lg-2">
                        <img src="{{ asset('assets/img/ilustracao-control-panel.svg') }}" alt="" class="w-100">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Algumas caracteristicas -->
    <section id="sobre">
        <div class="container py-5 pt-5 pt-lg-4">
            <div class="row align-items-center gx-lg-5 pb-5">
                <div class="col-12 col-lg-8 mx-auto pb-lg-2 p-lg-5 text-center">
                    <span class="fw-700 text-uppercase small text-orange" style="letter-spacing: 2px">
                        Característica
                    </span>
                    <h2 class="fs-1 fw-bold mt-1">
                        Sobre o Astro Delivery
                    </h2>
                    <p class=" text-muted fs-5">
                        Listamos algumas característica do nosso sistema que achamos mais importantes e que possam utilizar
                        da melhor maneira possível, em breve vamos adicionar mais funcionalidades para atender nossos
                        clientes.
                    </p>
                </div>
                <!-- Cards -->
                <div class="col-12 col-lg-9  mx-auto">
                    <div class="row text-start gy-4 justify-content-center">
                        <!-- Card -->
                        <div class="col-12 col-lg-4 ">
                            <div class="bg-white shadow rounded-3 px-4 py-3 h-100 border-top border-danger border-2">
                                <div class="py-2">
                                    <h3 class="h5 pt-1">Design Agradável</h3>
                                    <p class=" pb-0 mb-0 text-muted">
                                        Com uma interface fácil de usar, seus clientes não terão dificuldades em usá-lo.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Card -->
                        <div class="col-12 col-lg-4 ">
                            <div class="bg-white shadow rounded-3 px-4 py-3 h-100 border-top border-danger border-2">
                                <div class="py-2">
                                    <h3 class="h5 pt-1">Produtos</h3>
                                    <p class=" pb-0 mb-0 text-muted">
                                        Separados por grupos/categorias, seus produtos podem ter várias fotos, ou vários
                                        adicionais. Tudo muito prático e dinâmico.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Card -->
                        <div class="col-12 col-lg-4 ">
                            <div class="bg-white shadow rounded-3 px-4 py-3 h-100 border-top border-danger border-2">
                                <div class="py-2">
                                    <h3 class="h5 pt-1">Entrega</h3>
                                    <p class=" pb-0 mb-0 text-muted">
                                        Balcão, delivery, correios ou mesa? Estamos preparados para essas situações.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Card -->
                        <div class="col-12 col-lg-4 ">
                            <div class="bg-white shadow rounded-3 px-4 py-3 h-100 border-top border-danger border-2">
                                <div class="py-2">
                                    <h3 class="h5 pt-1">Pagamento</h3>
                                    <p class=" pb-0 mb-0 text-muted">
                                        Cadastre quantos meios de pagamentos voce tiver disponível. Também temos integração
                                        com PICPAY, e se quiser receber um PIX, geramos um QR Code e um copia/cola.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Card -->
                        <div class="col-12 col-lg-4 ">
                            <div class="bg-white shadow rounded-3 px-4 py-3 h-100 border-top border-danger border-2">
                                <div class="py-2">
                                    <h3 class="h5 pt-1">Força de vendas?</h3>
                                    <p class=" pb-0 mb-0 text-muted">
                                        Por que não? Seja representante ou vendedor você pode realizar seus pedidos on-line
                                        e cair diretamente no escritório.
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nossos Clientes -->
    <section id="nossos-clientes">
        <div class="bg-blue-light pt-5 pt-lg-0">
            <div class="container py-5  pt-4">
                <div class="row align-items-center gx-lg-5 pb-5">
                    <div class="col-12 col-lg-8 mx-auto pb-lg-2 p-lg-5 text-center">

                        <h2 class="fs-1 fw-bold">
                            Nossos Clientes
                        </h2>
                        <p class=" text-muted fs-5">
                            Conheça alguns de nossos clientes que desejam expandir seus negócios e escolheram o Astro
                            Delivery para impulsionar suas vendas pela internet.
                        </p>
                    </div>
                    <!-- Cards -->
                    <div class="col-12 col-lg-9  mx-auto">
                        <div class="row text-start gy-4 justify-content-center ">
                            @foreach ($stores as $store)
                                <!-- Card -->
                                <div class="col-12 col-lg-3 text-center ">
                                    <a href="{{ route('loja.index', $store->slug_url) }}"
                                        class="text-decoration-none text-dark link-nossos-clientes">
                                        <div
                                            class="bg-white shadow rounded-3 px-4 py-3 h-100 border-top border-warning border-2 h-100 d-flex align-items-center justify-content-center">
                                            <div class="py-2">
                                                <div class="mb-1">
                                                    @if ($store->logo)
                                                    <img src="{{ asset('storage/' . $store->logo) }}" alt=""
                                                    class="w-75 mx-auto mb-2">
                                                    @endif
                                                </div>
                                                <h3 class="h5 pt-1 mb-0 pb-0">{{$store->nome}}</h3>
                                                <p class=" pb-0 mb-0 text-muted d-none">
                                                    <!-- categoria -->
                                                </p>
                                                <div class=" mt-2 text-muted small">
                                                    <i class="fa-solid fa-location-dot  fs-11px"></i> {{$store->cidade}} - {{$store->uf}}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contato -->
    <section id="contate-nos">
        <div class="container py-5 pt-3 pb-4">
            <div class="row align-items-center gx-lg-5 gy-4 pt-5 pt-lg-0">
                <div class="col-12 col-lg-6 p-lg-5">
                    <img src="{{ asset('assets/img/ilustracao-contato.svg') }}" alt="" class="w-100">
                </div>

                <div class="col-12 col-lg-6 pb-5 p-lg-5">
                    <h2 class="fs-1 fw-bold mt-1 text-center text-lg-start">Contate-nos</h2>
                    <p class=" text-muted fs-5 text-center text-lg-start">
                        Entre em contato com a administração para tirar suas dúvidas ou falar sobre qualquer outro
                        assunto.
                    </p>

                    @if (session('contact_success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                            <strong>Mensagem de contato enviada com sucesso.</strong>
                        </div>
                    @endif


                    <!-- Formulário -->
                    <div class="">
                        <form action="{{ route('enviar-contato') }}" method="post">
                            @csrf
                            <!-- Nome -->
                            <div class="mb-3">
                                <label for="nome" class="form-label visually-hidden">Nome</label>
                                <input type="text"
                                    class="form-control form-control-lg bg-light rounded-1 shadow-none @error('nome') is-invalid @enderror"
                                    name="nome" id="nome" value="{{ old('nome') }}" placeholder="Seu Nome"
                                    required>
                                @error('nome')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Meio de contato -->
                            <div class="mb-3">
                                <label for="meio_contato" class="form-label visually-hidden">E-mail, Telefone ou
                                    WhatsApp</label>
                                <input type="text"
                                    class="form-control form-control-lg bg-light rounded-1 shadow-none @error('meio_contato') is-invalid @enderror"
                                    name="meio_contato" value="{{ old('meio_contato') }}" id="meio_contato"
                                    placeholder="E-mail, Telefone ou WhatsApp" required>
                                @error('meio_contato')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Mensagem -->
                            <div class="mb-3">
                                <label for="msg" class="form-label visually-hidden">Mensagem</label>
                                <textarea rows="3"
                                    class="form-control form-control-lg bg-light rounded-1 shadow-none @error('msg') is-invalid @enderror"
                                    name="msg" id="msg" placeholder="Mensagem" maxlength="1000" required>{{ old('msg') }}</textarea>
                                @error('msg')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-danger px-5 py-3 fw-bold text-uppercase">
                                    <i class="fa-regular fa-paper-plane me-2"></i>
                                    Enviar
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
