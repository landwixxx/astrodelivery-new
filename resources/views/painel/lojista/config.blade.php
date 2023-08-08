@extends('layouts.painel.app')
@section('title', 'Configurações')
@section('content')
    <br>

    {{-- Alertas --}}
    <x-alerts />

    <div class="container-fluid px-6 mx-auto grid">
        <br>

        @php
            if (isset(auth()->user()->store_has_user->store)) {
                $store = auth()->user()->store_has_user->store;
            }
            if (!isset(auth()->user()->store_has_user->store)) {
                $store = new \StdClass();
                $store->nome = null;
                $store->slug_url = null;
                $store->logo = null;
                $store->descricao = null;
                $store->email = null;
                $store->rua = null;
                $store->numero_end = null;
                $store->ponto_referencia = null;
                $store->complemento = null;
                $store->uf = null;
                $store->cidade = null;
                $store->bairro = null;
                $store->cep = null;
                $store->telefone = null;
                $store->whatsapp = null;
                $store->url_facebook = null;
                $store->url_twitter = null;
                $store->url_instagram = null;
                $store->empresa_aberta = null;
            }
        @endphp
        <h1 class="h4 fw-bold text-gray-600 dark:text-gray-200 mb-4">Configurações</h1>

        <!-- Token -->
        <div class="px-4 py-4 mb-4 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 dark:text-gray-200">
            <h2 class="fw-bold fs-5 mb-3">API Token</h2>
            <div class="mb-3">
                <input type="text" value="{{ $apiToken }}" id="token"
                    class="form-control block w-full mt-1 p-3 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
            </div>

            <button type="button" class="btn btn-secondary p-1 px-2 bg-secondary " onclick="copiar('token', this)">
                <span class="d-flex align-items-center gap-1">
                    <span class="material-symbols-outlined fs-14px">
                        content_copy
                    </span>
                    Copiar
                </span>
            </button>
            {{-- <button type="button" class="btn btn-secondary p-1 px-2 bg-secondary">
                <span class="d-flex align-items-center gap-1">
                    <span class="material-symbols-outlined fs-14px">
                        refresh
                    </span>
                    Gerar novo
                </span>
            </button> --}}
        </div>

        <!-- Configurações -->
        <div class="w-full overflow-hidden rounded-lg ">

            <div class="card border dark:border-none bg-white">
                <div class="card-body">

                    <!-- Formulário -->
                    <form action="{{ route('painel.lojista.configuracoes.atualizar-dados-loja') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row gy-4 dark:text-gray-200">

                            <div class="col-12">
                                <h2 class="fw-bold fs-5">Dados da loja</h2>
                                <p class="text-muted small mt-2">
                                    Campos com <span class="text-danger">*</span> são obrigatórios
                                </p>
                            </div>

                            <!-- Nome da loja -->
                            <div class="col-12 col-lg-4">
                                <label for="nome" class="form-label mb-1">
                                    Nome da loja<span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control @error('nome') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input  "
                                    name="nome" id="nome"
                                    value="{{ old('nome', $store != null ? $store->nome : '') }}" required>
                                @error('nome')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- URL -->
                            <div class="col-12 col-lg-8">
                                <label for="slug_url" class="form-label mb-1">Domínio<span
                                        class="text-danger">*</span></label>
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="w-auto">
                                        <input type="text"
                                            class="form-control @error('slug_url') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input  "
                                            name="slug_url" id="slug_url"
                                            value="{{ old('slug_url', $store != null ? $store->slug_url : '') }}"
                                            onkeyup="" required>
                                    </div>
                                    <div class="text-truncate">
                                        .{{ Str::limit(str_replace(['https://', 'http://', '/', 'www.'], [''], env('APP_URL')), 30) }}
                                    </div>
                                </div>
                                @error('slug_url')
                                    <div class="text-danger small fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Descrição -->
                            <div class="col-12 col-lg-12">
                                <label for="descricao" class="form-label mb-1">Descrição<span
                                        class="text-danger">*</span></label>
                                <textarea rows="3"
                                    class="form-control @error('descricao') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input  "
                                    name="descricao" id="descricao" required>{{ old('descricao', $store != null ? $store->descricao : '') }}</textarea>
                                @error('descricao')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- E-mail para contato -->
                            <div class="col-12 col-lg-4">
                                <label for="nome" class="form-label mb-1">
                                    E-mail para contato<span class="text-danger">*</span>
                                </label>
                                <input type="email"
                                    class="form-control @error('email') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input  "
                                    name="email" id="email"
                                    value="{{ old('email', $store != null ? $store->email : '') }}" required>
                                @error('email')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Telefone para contato -->
                            <div class="col-12 col-lg-4">
                                <label for="telefone" class="form-label mb-1">
                                    Telefone para contato<span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control @error('telefone') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input  "
                                    name="telefone" id="telefone"
                                    value="{{ old('telefone', $store != null ? $store->telefone : '') }}" required>
                                @error('telefone')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- WhatApp para contato -->
                            <div class="col-12 col-lg-4">
                                <label for="whatsapp" class="form-label mb-1">
                                    WhatsApp para contato<span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control @error('whatsapp') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input  "
                                    name="whatsapp" id="whatsapp"
                                    value="{{ old('whatsapp', $store != null ? $store->whatsapp : '') }}" required>
                                @error('whatsapp')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Endereço -->
                            <div class="col-12">
                                <h2 class="fw-bold fs-5 mt-4">Endereço</h2>
                            </div>
                            <!-- rua -->
                            <label class="block  col-12 col-lg-4">
                                <span class="text-gray-700 dark:text-gray-200 d-block mb-1">Rua<span
                                        class="text-danger">*</span></span>
                                <input name="rua" id="rua" value="{{ old('rua', $store->rua) }}"
                                    class="form-control @error('rua') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                    placeholder="">
                                @error('rua')
                                    <div class="invalid-feedback bold">{{ $message }}</div>
                                @enderror
                            </label>

                            <!-- numero_end -->
                            <label class="block  col-12 col-lg-4">
                                <span class="text-gray-700 dark:text-gray-200 d-block mb-1">Número<span
                                        class="text-danger">*</span></span>
                                <input name="numero_end" id="numero"
                                    value="{{ old('numero_end', $store->numero_end) }}"
                                    class="form-control @error('numero_end') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                    placeholder="">
                                @error('numero_end')
                                    <div class="invalid-feedback bold">{{ $message }}</div>
                                @enderror
                            </label>

                            <!-- ponto_referencia -->
                            <label class="block  col-12 col-lg-4">
                                <span class="text-gray-700 dark:text-gray-200 d-block mb-1">Ponto de referência</span>
                                <input name="ponto_referencia"
                                    value="{{ old('ponto_referencia', $store->ponto_referencia) }}"
                                    class="form-control @error('ponto_referencia') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                    placeholder="">
                                @error('ponto_referencia')
                                    <div class="invalid-feedback bold">{{ $message }}</div>
                                @enderror
                            </label>

                            <!-- complemento -->
                            <label class="block  col-12 col-lg-4">
                                <span class="text-gray-700 dark:text-gray-200 d-block mb-1">Complemento</span>
                                <input name="complemento" value="{{ old('complemento', $store->complemento) }}"
                                    class="form-control @error('complemento') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                    placeholder="">
                                @error('complemento')
                                    <div class="invalid-feedback bold">{{ $message }}</div>
                                @enderror
                            </label>

                            <!-- uf -->
                            <label class="block  col-12 col-lg-4">
                                <span class="text-gray-700 dark:text-gray-200 d-block mb-1">UF<span
                                        class="text-danger">*</span></span>
                                <input name="uf" id="uf" value="{{ old('uf', $store->uf) }}"
                                    class="form-control @error('uf') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                    placeholder="">
                                @error('uf')
                                    <div class="invalid-feedback bold">{{ $message }}</div>
                                @enderror
                            </label>

                            <!-- cidade -->
                            <label class="block  col-12 col-lg-4">
                                <span class="text-gray-700 dark:text-gray-200 d-block mb-1">Cidade<span
                                        class="text-danger">*</span></span>
                                <input name="cidade" id="cidade" value="{{ old('cidade', $store->cidade) }}"
                                    class="form-control @error('cidade') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                    placeholder="">
                                @error('cidade')
                                    <div class="invalid-feedback bold">{{ $message }}</div>
                                @enderror
                            </label>

                            <!-- bairro -->
                            <label class="block  col-12 col-lg-4">
                                <span class="text-gray-700 dark:text-gray-200 d-block mb-1">Bairro<span
                                        class="text-danger">*</span></span>
                                <input name="bairro" id="bairro" value="{{ old('bairro', $store->bairro) }}"
                                    class="form-control @error('bairro') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                    placeholder="">
                                @error('bairro')
                                    <div class="invalid-feedback bold">{{ $message }}</div>
                                @enderror
                            </label>

                            <!-- cep -->
                            <label class="block  col-12 col-lg-4">
                                <span class="text-gray-700 dark:text-gray-200 d-block mb-1">CEP<span
                                        class="text-danger">*</span></span>
                                <input id="cep" name="cep" value="{{ old('cep', $store->cep) }}"
                                    class="form-control @error('cep') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                    placeholder="">
                                @error('cep')
                                    <div class="invalid-feedback bold">{{ $message }}</div>
                                @enderror
                            </label>



                            <div class="col-12">
                                <h2 class="fw-bold fs-5 mt-4">Redes sociais</h2>
                            </div>

                            <!-- URL Facebook -->
                            <div class="col-12 col-lg-4">
                                <label for="nome" class="form-label mb-1">
                                    URL Facebook
                                </label>
                                <input type="text"
                                    class="form-control @error('url_facebook') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input  "
                                    name="url_facebook" id="url_facebook"
                                    value="{{ old('url_facebook', $store != null ? $store->url_facebook : '') }}">
                                @error('url_facebook')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- URL Twitter -->
                            <div class="col-12 col-lg-4">
                                <label for="nome" class="form-label mb-1">
                                    URL Twitter
                                </label>
                                <input type="text"
                                    class="form-control @error('url_twitter') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input  "
                                    name="url_twitter" id="url_twitter"
                                    value="{{ old('url_twitter', $store != null ? $store->url_twitter : '') }}">
                                @error('url_twitter')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- URL Instagram -->
                            <div class="col-12 col-lg-4">
                                <label for="nome" class="form-label mb-1">
                                    URL Instagram
                                </label>
                                <input type="text"
                                    class="form-control @error('url_instagram') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input  "
                                    name="url_instagram" id="url_instagram"
                                    value="{{ old('url_instagram', $store != null ? $store->url_instagram : '') }}">
                                @error('url_instagram')
                                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <!-- empresa_aberta -->
                        <div class="mt-4 ">
                            <span class="text-gray-700 dark:text-gray-200 mb-1 d-block">
                                Empresa aberta?<span class="text-danger">*</span>
                            </span>
                            <div class="text-sm text-muted dark:text-gray-400 mb-3">
                                Se estiver como NÃO, o cliente não poderá realizar pedidos, mas pode consultar
                                preços.
                            </div>
                            <div class="mt-2">
                                <label class="inline-flex items-center text-gray-600 dark:text-gray-200">
                                    <input type="radio"
                                        class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                        name="empresa_aberta" value="sim"
                                        @if (old('empresa_aberta', $store->empresa_aberta) == 'sim') checked @endif required>
                                    <span class="ml-2">Sim</span>
                                </label>
                                <label class="inline-flex items-center ml-6 text-gray-600 dark:text-gray-200">
                                    <input type="radio"
                                        class=" text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                        name="empresa_aberta" value="nao"
                                        @if (old('empresa_aberta', $store->empresa_aberta) == 'nao') checked @endif>
                                    <span class="ml-2">Não</span>
                                </label>

                                @error('empresa_aberta')
                                    <div class="small text-danger bold">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-danger bg-danger px-4 mt-3 ">
                                <div class="d-flex align-items-center gap-2">
                                    Salvar
                                </div>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>


    <div class="py-4"></div>

@endsection

@section('scripts')
    <!-- Mascaras de input -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/imask/6.4.3/imask.min.js"></script>
    <script>
        // var phone = IMask(document.getElementById('telefone'), {
        //     mask: [{
        //             mask: '(00)00000-0000'
        //         },
        //         {
        //             mask: '0000000000000000000000000000'
        //         }
        //     ]
        // });
        // var phone = IMask(document.getElementById('whatsapp'), {
        //     mask: [{
        //             mask: '(00)00000-0000'
        //         },
        //         {
        //             mask: '0000000000000000000000000000'
        //         }
        //     ]
        // });

        var cep = IMask(document.getElementById('cep'), {
            mask: [{
                    mask: '00000-000'
                },
                {
                    mask: '00.000-000'
                }
            ]
        });
    </script>

    <script>
        // Copiar link
        function copiar(id, target) {
            document.getElementById(id).select()
            document.execCommand('copy');
            target.innerHTML =
                '<span class="d-flex align-items-center gap-1"> <span class="material-symbols-outlined fs-14px"> content_copy </span> Copiado </span>';
            target.className = 'btn btn-success p-1 px-2 bg-success';
            setTimeout(() => {
                target.innerHTML =
                    '<span class="d-flex align-items-center gap-1"> <span class="material-symbols-outlined fs-14px"> content_copy </span> Copiar </span>';
                target.className = 'btn btn-secondary p-1 px-2 bg-secondary';
            }, 1000);
        }
    </script>

@endsection
