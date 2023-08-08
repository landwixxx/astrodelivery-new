@php
    if (!isset($category)) {
        $category = new \StdClass();
        $category->nome = null;
        $category->slug = null;
    }
@endphp

<div class="container py-5 pt-2">
    <div class="row">
        @if (request()->get('s') && $products->total() != 0)
            <h1 class="mb-3 h3 text-muted">
                {{ $products->total() }}
                resultados
            </h1>
        @endif

        @if ($category->nome)
            <h2 class="h5 text-uppercase fw-bold col-12">{{ $category->nome }}</h2>
        @endif

        @if ($products->total() == 0)
            @if (request()->get('s'))
                <div class="text-center fs-1 mt-3 mb-3">
                    Nenhum resultado encontrado para “{{ request()->get('s') }}”.
                </div>
                <div class="col-lg-5 mx-auto mb-5">
                    <div class="fs-5 fw-semibold mb-3">Que tal pesquisar de novo seguindo as dicas abaixo?</div>
                    <ul>
                        <ul>
                            <li class="">Confira se o termo foi digitado certinho;</li>
                            <li class="">Use menos palavras ou termos menos específicos;</li>
                            <li class="">Tente outro produto ou navegue pelas categorias para encontrar o que
                                você precisa.</li>
                        </ul>
                    </ul>
                </div>
            @else
                <div class="text-center fs-1 my-5">
                    Nenhum produto cadastrado.
                </div>
            @endif
        @endif

        <!-- Lista de produtos -->
        <div class="col-12 col-lg-12">
            <div class="row gy-4">
                @foreach ($products as $product)
                    <div class="col-12 col-lg-3">
                        @switch($product->tipo)
                            @case('PIZZA')
                                <!-- Link montar pizza -->
                                <a href="{{ route('loja.produto.pizza', ['slug_store' => $store->slug_url, $product->id]) }}"
                                    class="text-dark text-decoration-none">
                                @break

                                @default
                                    <!-- LInk produto -->
                                    <a href="{{ route('loja.produto.add', ['slug_store' => $store->slug_url, 'product' => $product->id, 'slug_produto' => Str::slug($product->nome)]) }}"
                                        class="text-dark text-decoration-none">
                                @endswitch
                                <!-- Dados produto -->
                                <div class="card border item-produto">
                                    <div class="card-body p-lg-3 py-lg-4">
                                        <div class="">
                                            <img src="{{ $product->img_destaque }}" alt="" class="w-100">
                                        </div>
                                        <div class="">
                                            <!-- img -->
                                            <h3 class="h5 mt-4">
                                                {{ $product->nome }}
                                            </h3>
                                            <!-- nome -->
                                            <p class="text-muted text-truncate @if($product->tipo == 'PIZZA') pb-0 mb-0 @endif">
                                                {{ $product->descricao }}
                                            </p>
                                            <!-- preço -->
                                            <div class="text-end font-open-sans">
                                                <span class="fw-bold text-danger">
                                                    @if ($product->tipo == 'PIZZA')
                                                        <small class="fs-11px fw-normal text-muted d-block">A partir de: </small>
                                                    @endif
                                                    R$
                                                     <span class="h5  fw-bold"> {{ number_format($product->valor, 2, ',', '.') }} </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                    </div>
                @endforeach
            </div>

            <!-- Paginação -->
            <div class="pt-4">
                {{ $products->withQueryString()->links() }}
            </div>

        </div>

    </div>
</div>
