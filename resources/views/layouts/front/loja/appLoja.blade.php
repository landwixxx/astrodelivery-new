@php
    $dias = [['dia' => 'Segunda', 'horario' => '8:00 / 23:00'], ['dia' => 'Terça-feira', 'horario' => '8:00 / 23:00'], ['dia' => 'Quarta-feira', 'horario' => '8:00 / 23:00'], ['dia' => 'Quinta-feira', 'horario' => '8:00 / 23:00'], ['dia' => 'Sexta-feira', 'horario' => '8:00 / 23:00'], ['dia' => 'Sábado', 'horario' => '8:00 / 12:00']];
    $bairros = [['nome' => 'Caixa Dágua', 'taxa' => 'R$ 12,50'], ['nome' => 'Bananeira', 'taxa' => 'R$ 15,50'], ['nome' => 'Lider', 'taxa' => 'R$ 9,90'], ['nome' => 'Catuaba', 'taxa' => 'R$ 15,50']];
    $qtd_itens = 0;
    $soma_pedido = 0;
    $items_cart = [];
    if (session('items_cart')) {
        $items_cart = session('items_cart');
        $qtd_itens = $qtd_itens + count($items_cart);
        $soma_pedido_cart = array_column($items_cart, 'vl_item');
        $soma_pedido_cart = array_sum($soma_pedido_cart);
        $soma_pedido = $soma_pedido_cart;
    }

    if (session('items_cart_pizza')) {
        $qtd_itens = $qtd_itens + count(session('items_cart_pizza'));
    }
    if (session('items_cart_pizza_produto')) {
        $qtd_itens = $qtd_itens + count(session('items_cart_pizza_produto'));
    }

@endphp



<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
        content="width=device-width, user-scalable=yes, initial-scale=1.0, maximum-scale=10, minimum-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">
    <!--Bootstrap-->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('assets/css/style_loja.css') }}">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <!-- Icons FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- Styles -->

    @yield('head')
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-black  shadow-sm header"
            style="background-image:url({{ asset('storage/' . $store->imagem_bg) }})">
            <div class="container  justify-content-end p-4">
                <div class="col-md-4">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('storage/' . $store->logo) }}" alt="Logo" class="logo">
                    </a>
                </div>
                <div class="col-md-8 d-flex flex-column align-items-center justify-content-end">
                    <div class="row">
                        <h3 class="text-light p-2">{{ $store->nome }}</h3>
                    </div>
                    <div class="col-md-2">

                        <div class="row mt-4">
                            @switch($store->empresa_aberta)
                                @case ('sim')
                                    <span class="btn  btn-success w-30"> <i class="far fa-times-circle"></i> Aberta</span>
                                @break

                                @case('nao')
                                    <span class="btn  btn-danger w-30"> <i class="far fa-times-circle"></i> Fechada</span>
                                @break
                            @endswitch

                        </div>

                    </div>



                    <div class="row">
                        <ul class="navbar-nav mt-4">
                            <li class=" nav-item ms-5 text-light">
                                <a href="#" class="text-light nav-link" data-bs-toggle="modal"
                                    data-bs-target="#infoModal">
                                    <i class="fas fa-info-circle"></i> Info. loja
                                </a>
                            </li>
                            <li class=" nav-item ms-5 text-light">
                                <a href="#" class="text-light nav-link" data-bs-toggle="modal"
                                    data-bs-target="#horariosModal">
                                    <i class="fas fa-history"></i> Ver horários
                                </a>
                            </li>
                            <li class=" nav-item ms-5 text-light">
                                <a href="#" class="text-light nav-link" data-bs-toggle="modal"
                                    data-bs-target="#bairrosModal">
                                    <i class="fas fa-map-marker-alt"></i> Ver bairros
                                </a>
                            </li>
                            @if(Auth::user() != null)
                            <li>
                            @role('cliente')
                            <a class="text-light nav-link" href="{{ route('cliente.logout', $store->slug_url) }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-right-from-bracket fa-sm me-1"></i>
                                Sair
                            </a>
                            <form id="logout-form" action="{{ route('cliente.logout', $store->slug_url) }}"
                                method="POST" class="d-none">
                                @csrf
                            </form>
                        @else
                            <a class="text-light nav-link" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-right-from-bracket fa-sm me-1"></i>
                                Sair
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                class="d-none">
                                @csrf
                            </form>
                        @endrole
                        </li>
                        @endif



                        </ul>
                    </div>
                </div>


            </div>
        </nav>
        @if (session('items_cart') || session('items_cart_pizza') || session('items_cart_pizza_produto'))
            <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="pedidos-escolhidos"
                aria-labelledby="Enable both scrolling & backdrop">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title small fw-normal" id="Enable both scrolling & backdrop">Lista de Itens
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <!-- Lista de produtos -->
                    <div class="position-relative">
                        <ul class="list-group list-group-flush">
                            @foreach ($items_cart as $item)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <div class="fw-500 fs-5">{{ $item['qtd_item'] }} x {{ $item['product_nome'] }}
                                            <p></p>
                                        </div>
                                        <div class="fw-bold d-flex align-items-baseline gap-1">R$ <span
                                                class="fs-5">{{ number_format($item['vl_item'], 2, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            {{-- montar pizza --}}
                            @foreach (session('items_cart_pizza') ?? [] as $item)
                                @php
                                    $soma_pedido = $soma_pedido + $item['valor_total'];
                                @endphp
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <div class="fw-500 fs-5">
                                            1 x Pizza
                                            <p></p>
                                        </div>
                                        <div class="fw-bold d-flex align-items-baseline gap-1">R$
                                            <span class="fs-5">
                                                {{ number_format($item['valor_total'], 2, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            {{-- Produto pizza --}}
                            @foreach (session('items_cart_pizza_produto') ?? [] as $item)
                                @php
                                    $soma_pedido = $soma_pedido + $item['valor_total'];
                                @endphp
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <div class="fw-500 fs-5">
                                            1 x {{ $item['nome'] }}
                                                span
                                            @for($i=0;$i<count($item['sabores']); $i++)
                                            <br>
                                               <span class="itsabor">{{$item['sabores'][$i]['sabor']}}
                                                 </span>
                                            @endfor
                                            {{-- <pre>@php var_dump($item['sabores']);@endphp</pre> --}}

                                           {{-- <p>{{$item['sabores']['sabor']}}</p> --}}



                                        </div>
                                        <div class="fw-bold d-flex align-items-baseline gap-1">R$
                                            <span class="fs-5">
                                                {{ number_format($item['valor_total'], 2, ',', '.') }}
                                            </span>
                                        </div>

                                    </div>
                                </li>
                            @endforeach
                            <li class="list-group-item sticky-bottom">
                                <div class="d-flex justify-content-between mt-4 align-items-center">
                                    <div class="fw-500 lh-sm">
                                        <div class=" fs-6 tdext-muted">Total do Pedido</div>
                                    </div>
                                    <div class="">
                                        <div class="fw-bold">R$ <span
                                                class="fs-4">{{ number_format($soma_pedido, 2, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <a href="{{ route('cliente.resumo-pedido', $store->slug_url) }}"
                                        class="btn btn-info w-100 small fw-500 mb-2 mt-2">
                                        Resumo do Pedido
                                    </a>
                                    <a href="{{ route('cliente.formas-entrega-e-pagamento', $store->slug_url) }}"
                                        class="btn btn-danger w-100 small fw-500">
                                        Finalizar
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @endif
        <div class="minnav sticky-top">
            <nav class="navbar bg-body-tertiary navbar-expand-md navbar-light bg-white shadow-sm">
                <form class="container-fluid justify-content-center">
                    <div class="col-md-4">
                        <a href="{{ url('/') }}" class="btn btn-md btn-outline-secondary me-2 w-100 fs-5"
                            type="button"><i class="fas fa-home"></i> Inicial</a>
                    </div>
                    <div class="col-md-4">

                        @if ($qtd_itens == 0)
                            <button class="btn btn-md btn-outline-secondary w-100 fs-5" type="button"> <i
                                    class="fas fa-shopping-basket text-danger"></i> Carrinho Vazio</button>
                        @else
                            <button class="btn btn-md btn-outline-secondary w-100 ms-2" type="button"
                                data-bs-toggle="offcanvas" data-bs-target="#pedidos-escolhidos"
                                aria-controls="pedidos-escolhidos">
                                <div class="d-flex align-items-center text-start">
                                    <div class=""><i class="fas fa-shopping-basket text-success"></i></div>
                                    <div class="valscart ms-2">{{$qtd_itens}} Itens <span class="small">R$</span> <span
                                        class="fs-5 fw-bold">{{ number_format($soma_pedido, 2, ',', '.') }}</span></div>
                                    <div class="">

                                        {{-- <div class="small">{{ $qtd_itens }} Itens <div class="font-open-sans">R$
                                                <span
                                                    class="fs-4 fw-bold">{{ number_format($soma_pedido, 2, ',', '.') }}</span>
                                            </div>
                                        </div> --}}
                                    </div>
                        @endif
                    </div>
                    </button>

                    {{-- <button class="btn btn-md btn-outline-secondary w-100" type="button"> <i class="fas fa-shopping-basket text-danger"></i> Carrinho Vazio</button> --}}
        </div>

        </form>
        </nav>
    </div>

    <main class="py-4">

        @yield('content')
    </main>

    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>

<script src="{{ asset('assets/js/main.js') }}"></script>


<!-- Script Bootstrap -->
<script src="{{ asset('assets/bootstrap-5.2.1/js/bootstrap.bundle.min.js') }}"></script>
<!-- Script Principal -->
<script src="{{ asset('assets/js/main.js') }}"></script>

@yield('scripts')
{{-- Modal Informações da loja --}}
<div class="modal fade " id="infoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h1 class="modal-title fs-5 " id="exampleModalLabel">INFORMAÇÕES DA LOJA</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column justify-contents-center align-items-center">

                <div class="row">
                    <div class="logoinfo">
                        <img src="{{ asset('storage/' . $store->logo) }}" alt="Logo" class="logo"
                            width="200px">
                    </div>
                </div>
                <h5>{{ $store->nome }}</h5>

                <p class=" text-center">{{ $store->rua }} - {{ $store->numero_end }}<br>{{ $store->bairro }} -
                    {{ $store->cidade }}/{{ $store->uf }}</p>
            </div>
            {{-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div> --}}
        </div>
    </div>
</div>

{{-- Modal Horarios --}}
<div class="modal fade " id="horariosModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">HORARIOS DE FUNCIONAMENTO</h1>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">

                @foreach ($dias as $dia)
                    <div class="funcionamento">
                        <h5>{{ $dia['dia'] }}</h5>
                        <p>{{ $dia['horario'] }}</p>
                    </div>
                @endforeach
            </div>
            {{-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div> --}}
        </div>
    </div>
</div>

{{-- Modal Bairros --}}
<div class="modal fade " id="bairrosModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h1 class="modal-title fs-5 text-white" id="exampleModalLabel">NOSSO ENDEREÇO</h1>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <H5>Bairros</H5>
                <table class="table table-hover">
                    <thead class="table-secondary">
                        <tr>
                            <th scope="col">Bairro</th>
                            <th scope="col">Taxa</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bairros as $bairro)
                            <tr>

                                <td>{{ $bairro['nome'] }}</td>
                                <td>{{ $bairro['taxa'] }}</td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            {{-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div> --}}
        </div>
    </div>
</div>

</html>
<script>
    $(document).ready(function() {
        $('.carousel').carousel({
            interval: 2000
        })

    });
</script>
