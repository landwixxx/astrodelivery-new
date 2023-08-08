@php
    if (!isset($category)) {
        $category = new \StdClass();
        $category->nome = null;
        $category->slug = null;
    }
@endphp
<div class="mt-4 mt-lg-5 categorias mb-4">
    <nav class="navbar navbar-expand-md navbar-dark bg-primary ">
        <div class="container ">
            <!-- btn menu -->
            <div class="d-lg-none">
                <a class="nav-link p-2 py-1 btn btn-outline-light border-0 dropdown-toggle d-flex align-items-center"
                    href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Categorias
                </a>
                <div class="dropdown-menu lh-sm" aria-labelledby="dropdownId">
                    <div class="d-flex flex-wrap">
                        @foreach ($categories as $key => $cate)
                            <a class="categoria-dropdown-link col-12 col-md-3 col-lg-4"
                                href="{{ route('loja.categoria.index', ['slug_store' => $store->slug_url, 'slug_category' => $cate['slug']]) }}">
                                <i class="fa-solid fa-chevron-right fs-11px me-2"></i>
                                {{ $cate['nome'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="collapse navbar-collapse " id="collapsibleNavId">
                <ul class="navbar-nav  me-auto mt-2 mt-lg-0 align-items-center">

                    <!-- Dropdown com categorias -->
                    <li class="nav-item dropdown me-lg-2">
                        <a class="nav-link p-2 py-1 btn btn-outline-light dropdown-toggle d-flex align-items-center rounded-0 px-3 fw-500"
                            href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            Categorias
                        </a>
                        <div class="dropdown-menu lh-sm" aria-labelledby="dropdownId">
                            <div class="d-flex flex-wrap">
                                @foreach ($categories as $key => $cate)
                                    <a class="categoria-dropdown-link col-12 col-md-3 col-lg-4  @if ($cate['slug'] == $category->slug) active @endif"
                                        href="{{ route('loja.categoria.index', ['slug_store' => $store->slug_url, 'slug_category' => $cate['slug']]) }}">
                                        <i class="fa-solid fa-chevron-right fs-11px me-2"></i>
                                        {{ $cate['nome'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </li>

                    @foreach ($categories as $key => $cate)
                        @php
                            if ($key > 6) {
                                continue;
                            }
                        @endphp
                        <li class="nav-item mx-2">
                            <a class="nav-link link-light fw-500 @if ($cate['slug'] == $category->slug) active @endif"
                                href="{{ route('loja.categoria.index', ['slug_store' => $store->slug_url, 'slug_category' => $cate['slug']]) }}">
                                {{ $cate['nome'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>


            @php
                $mPizza = \App\Models\MontarPizza::where('store_id', $store->id)->first();
            @endphp
            @if ($mPizza != null && $mPizza->status == 'ativo')
                <ul class="navbar-nav  ms-auto mt-md-2 mt-lg-0 align-items-center">
                    <li class="nav-item mx-2 ">
                        <a href="{{ route('loja.montar-pizza.tamanhos', ['slug_store' => $store->slug_url]) }}"
                            class="btn btn-outline-warning d-flex align-items-center fw-semibold rounded-0 ">
                                <i class="fa-solid fa-pizza-slice fs-12px me-2"></i>
                                Monte Sua Pizza
                        </a>
                    </li>
                </ul>
            @endif

        </div>
    </nav>

</div>
