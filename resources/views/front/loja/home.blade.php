
@extends('layouts.front.loja.appLoja', ['store' => $store])

@section('title', 'Home Catalogo')
@section('content')

    <div class="container  justify-content-end mt-4">
        <div class="row">
            <div class="col-md-3">


                <div id="accordion" class="accordion-one mg-b-10" role="tablist" aria-multiselectable="true">
                    <div class="card">
                        <div class="card-header" role="tab" id="headingOne">
                            <a class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"
                                style="color:#000000">
                                <i class="fa fa-bars mg-r-10"></i> MENU
                            </a>
                        </div>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample"
                            style="">
                            <div class="card-body">
                                <div class="card-people-list pd-5">
                                    <div class="media-list" style="margin-top:-10px">
                                        @forelse ($categorias as $categoria)
                                         {{-- @php
                                        foreach($categorias as $catt){
                                            dd(count($catt->produtos_categoria));
                                        }

                                        @endphp  --}}
                                            <div class="media d-flex ">
                                                <a href="#{{$categoria['codigo']}}">
                                                      <img src="{{ is_null($categoria['foto']) ? asset('assets/img/img-prod-vazio.png') : $categoria['foto'] }}"
                                                        alt=""  style="width:30px; height:30px; border-radius: 100%;" id="img-previa">
                                                </a>
                                                <div class="media-body">
                                                    <a href="#{{$categoria['codigo']}}" style="color:#000000">{{ $categoria['nome'] }} ( {{count($categoria->produtos_categoria)}} )</a>
                                                </div>
                                                <a href="#{{$categoria['codigo']}}" style="color:#000000"><i
                                                        class="fa fa-chevron-circle-right"></i></a>
                                            </div>
                                            @empty
                                            <p>Nenhuma categoria cadastrada</p>
                                        @endforelse

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Coluna do meio --}}
            <div class="col-md-6">
                <div class="mg-b-10 banmid">
                    <div id="carouselExample" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ is_null($banners[0]['img']) ? '' : $banners[0]['img']}} " class="d-block w-100" alt="...">
                            </div>
                            @foreach($banners as $banner)


                             <div class="carousel-item">
                                <img src="{{asset($banner->img)}}" class="d-block w-100" alt="...">
                            </div>
                            @endforeach

                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                @forelse($categorias as $catp)
                <div class="card card-people-list p-3 mt-2" id="{{$catp['codigo']}}">
                    <div class="slim-card-title"><i class="fa fa-caret-right"></i> {{$catp['nome']}}</div>
                    <div class="media-list">
                        @foreach($catp->produtos_categoria as $produto)


                        <div class="produtos">
                            {{-- @php
                                dd($produto);
                            @endphp --}}
                            @switch($produto->tipo)
                            @case('PIZZA')
                                <!-- Link montar pizza -->
                                <a href="{{ route('loja.produto.pizza', ['slug_store' => $store->slug_url, $produto->id]) }}"
                                    class="text-dark text-decoration-none">
                                @break

                                @default
                                <!-- LInk produto -->
                                <a href="{{ route('loja.produto.add', ['slug_store' => $store->slug_url, 'product' => $produto->id, 'slug_produto' => Str::slug($produto->nome)]) }}"
                                    class="text-dark text-decoration-none">

                            @endswitch



                            <div style="width:120px;text-align:center;">
                                <div style="display:block;float:left;text-align:center;">

                                        <img src='{{ $produto['img_destaque'] }}' alt="" width="100"
                                        style="width:100%;border:0;">

                                </div>
                                <div style="display:block;float:left;">

                                </div>
                            </div>
                            <div class="media-body" style="margin-left:5px !important;float:left;">


                                <span class="tx-15">
                                    <strong>{{$produto['nome']}}</strong>

                                </span>


                                <p class="tx-12 mg-r-5" style="color:#555;">{{$produto['descricao']}}</p>






                                <p class="tx-14">
                                    <small style="display:none;">
                                        <strong>R$ </strong>
                                        <del style="color:red;">{{number_format($produto['valor'],2,',','.')}}</del>
                                    </small>
                                    <strong>
                                    </strong>
                                </p>
                            </div>

                            {{-- <div align="left">
                                <button class="btn btn-danger btn-sm">
                                    <i class="fa fa-window-close"></i>
                                </button>
                            </div>--}}</a>


                            @switch($produto->tipo)
                            @case('PIZZA')
                                <!-- Link montar pizza -->
                                <a href="{{ route('loja.produto.pizza', ['slug_store' => $store->slug_url, $produto->id]) }}"
                                    class="text-dark text-decoration-none"><button type="button" onclick="submitForm()" class="btn btn-primary fw-600 pb-1"
                                    id="btn-carrinho-add">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="fas fa-plus-circle m-2"></i>
                                        Opções
                                    </div>
                                </button></a>
                                @break

                                @default
                                <!-- btn add produto -->
                                <a href="{{ route('loja.produto.add', ['slug_store' => $store->slug_url, 'product' => $produto->id, 'slug_produto' => Str::slug($produto->nome)]) }}"
                                    class="text-dark text-decoration-none">
                                <button type="button"  class="btn btn-success fw-600 pb-1"
                                id="btn-carrinho-add">
                                <div class="d-flex align-items-center justify-content-center">
                                    <i class="fas fa-cart-plus"></i>
                                    Adicionar ao Carrinho
                                </div>
                            </button></a>

                            @endswitch
                            <input type="hidden" value="{{ $produto->estoque }}"
                                                        id="limit-estoque-produto">
                        </div>


                        @endforeach



                    </div>
                </div>

               @empty
<p>Nenhum Produto encontrado</p>

@endforelse


            </div>
            {{-- coluna contato --}}
            <div class="col-md-3">
                <div class="card card-people-list p-4 ">
                    <div class="slim-card-title"><i class="fa fa-caret-right"></i> COMPARTILHE</div>
                    <div class="media-list">
                        <!-- AddToAny BEGIN -->
                        <div style="margin: 0px auto; align-items: center; display: flex; flex-flow: row wrap; justify-content: center; line-height: 32px;" class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="http://{{$store->slug_url}}.aastrodelivery.com.br">
                            <!--                        <a class="a2a_button_facebook"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <a class="a2a_button_facebook_messenger"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
                            <a class="a2a_button_whatsapp" target="_blank" rel="nofollow noopener" href="/#whatsapp"><span class="a2a_svg a2a_s__default a2a_s_whatsapp" style="background-color: rgb(18, 175, 10);"><svg focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill-rule="evenodd" clip-rule="evenodd" fill="#FFF" d="M16.21 4.41C9.973 4.41 4.917 9.465 4.917 15.7c0 2.134.592 4.13 1.62 5.832L4.5 27.59l6.25-2.002a11.241 11.241 0 0 0 5.46 1.404c6.234 0 11.29-5.055 11.29-11.29 0-6.237-5.056-11.292-11.29-11.292zm0 20.69c-1.91 0-3.69-.57-5.173-1.553l-3.61 1.156 1.173-3.49a9.345 9.345 0 0 1-1.79-5.512c0-5.18 4.217-9.4 9.4-9.4 5.183 0 9.397 4.22 9.397 9.4 0 5.188-4.214 9.4-9.398 9.4zm5.293-6.832c-.284-.155-1.673-.906-1.934-1.012-.265-.106-.455-.16-.658.12s-.78.91-.954 1.096c-.176.186-.345.203-.628.048-.282-.154-1.2-.494-2.264-1.517-.83-.795-1.373-1.76-1.53-2.055-.158-.295 0-.445.15-.584.134-.124.3-.326.45-.488.15-.163.203-.28.306-.47.104-.19.06-.36-.005-.506-.066-.147-.59-1.587-.81-2.173-.218-.586-.46-.498-.63-.505-.168-.007-.358-.038-.55-.045-.19-.007-.51.054-.78.332-.277.274-1.05.943-1.1 2.362-.055 1.418.926 2.826 1.064 3.023.137.2 1.874 3.272 4.76 4.537 2.888 1.264 2.9.878 3.43.85.53-.027 1.734-.633 2-1.297.266-.664.287-1.24.22-1.363-.07-.123-.26-.203-.54-.357z"></path></svg></span><span class="a2a_label">WhatsApp</span></a>
                        <div style="clear: both;"></div></div>
                        <script async="" src="https://static.addtoany.com/menu/page.js"></script>
                        <!-- AddToAny END -->
                    </div>
                </div>
            </div>


        </div>





    @endsection

    @section('scripts')
    <script>
    function submitForm() {
        // event.preventDefault();

        if (document.querySelectorAll('.json-sabor').length >= maxSabores) {} else {
            // document.getElementById('btn-carrinho-add').className = 'btn btn-outline-danger fw-600 pb-1 disabled'
            showErroModal('Selecione todos os sabores')
            return;
        }

        // se tem alguma borda selecionada
        let temCheck = false
        document.querySelectorAll('.check-borda').forEach(element => {
            if (element.checked) {
                temCheck = true
            }
        });
        if (!temCheck) {
            showErroModal('Selecione a borda')
            return;
        }

        document.getElementById('form-pizza').submit()
    }
    </script>
    @endsection

