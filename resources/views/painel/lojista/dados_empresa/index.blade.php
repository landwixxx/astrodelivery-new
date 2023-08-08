@extends('layouts.painel.app')
@section('title', 'Editar dados da empresa')
@section('content')
    <br>

    {{-- Alertas --}}
    <x-alerts />

    <div class="container-fluid px-6 mx-auto grid">
        <br>

        <!-- Editar dados da empresa -->
        <div class="w-full overflow-hidden rounded-lg ">
            <h1 class="h4 fw-bold text-gray-600 dark:text-gray-200 mb-4">Editar dados da empresa</h1>

            <div class="card border dark:border-none bg-white">
                <div class="card-body">

                    @php
                        
                        $data_empresa = new \StdClass();
                        $data_empresa->cnpj = $user->company ? $user->company->cnpj : '';
                        $data_empresa->fantasia = $user->company ? $user->company->fantasia : '';
                        $data_empresa->razao_social = $user->company ? $user->company->razao_social : '';
                        $data_empresa->telefone = $user->company ? $user->company->telefone : '';
                        $data_empresa->whatsapp = $user->company ? $user->company->whatsapp : '';
                        $data_empresa->email = $user->company ? $user->company->email : '';
                        $data_empresa->nome_contato = $user->company ? $user->company->nome_contato : '';
                        $data_empresa->telefone_contato = $user->company ? $user->company->telefone_contato : '';
                        $data_empresa->endereco = $user->company ? $user->company->endereco : '';
                        $data_empresa->numero_end = $user->company ? $user->company->numero_end : '';
                        $data_empresa->ponto_referencia = $user->company ? $user->company->ponto_referencia : '';
                        $data_empresa->complemento = $user->company ? $user->company->complemento : '';
                        $data_empresa->uf = $user->company ? $user->company->uf : '';
                        $data_empresa->cidade = $user->company ? $user->company->cidade : '';
                        $data_empresa->bairro = $user->company ? $user->company->bairro : '';
                        $data_empresa->cep = $user->company ? $user->company->cep : '';
                        $data_empresa->sobre = $user->company ? $user->company->sobre : '';
                        
                        $data_empresa->cnae = $user->company ? $user->company->cnae : '';
                        $data_empresa->insc_estadual = $user->company ? $user->company->insc_estadual : '';
                        $data_empresa->insc_estadual_subs = $user->company ? $user->company->insc_estadual_subs : '';
                        $data_empresa->insc_municipal = $user->company ? $user->company->insc_municipal : '';
                        $data_empresa->cod_ibge = $user->company ? $user->company->cod_ibge : '';
                        $data_empresa->regime_tributario = $user->company ? $user->company->regime_tributario : '';
                        $data_empresa->empresa_aberta = $user->company ? $user->company->empresa_aberta : '';
                        $data_empresa->cor = $user->company ? $user->company->cor : '';
                        $data_empresa->ativo = $user->company ? $user->company->ativo : '';
                        
                    @endphp


                    <form action="{{ route('painel.lojista.dados-da-empresa.update') }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class=" py-3 mb-3 bg-white rounded-lg  dark:bg-gray-800">
                            <div class="row gy-4">

                                <!-- cnpj -->
                                <label class="block col-12 col-lg-4">
                                    <span class="text-gray-700 dark:text-gray-200 d-block mb-1">CNPJ<span
                                            class="text-danger">*</span></span>
                                    <input name="cnpj" id="cnpj" value="{{ old('cnpj', $data_empresa->cnpj) }}"
                                        class="form-control @error('cnpj') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        id="cnpj" placeholder="00.000.000/0000-00">
                                    @error('cnpj')
                                        <div class="invalid-feedback bold">{{ $message }}</div>
                                    @enderror
                                </label>

                                <!-- fantasia -->
                                <label class="block  col-12 col-lg-4">
                                    <span class="text-gray-700 dark:text-gray-200 d-block mb-1">Fantasia<span
                                            class="text-danger">*</span></span>
                                    <input id="fantasia" name="fantasia"
                                        value="{{ old('fantasia', $data_empresa->fantasia) }}"
                                        class="form-control @error('fantasia') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        placeholder="">
                                    @error('fantasia')
                                        <div class="invalid-feedback bold">{{ $message }}</div>
                                    @enderror
                                </label>

                                <!-- razao_social -->
                                <label class="block  col-12 col-lg-4">
                                    <span class="text-gray-700 dark:text-gray-200 d-block mb-1">Razão Social<span
                                            class="text-danger">*</span></span>
                                    <input id="razao_social" name="razao_social"
                                        value="{{ old('razao_social', $data_empresa->razao_social) }}"
                                        class="form-control @error('razao_social') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        placeholder="">
                                    @error('razao_social')
                                        <div class="invalid-feedback bold">{{ $message }}</div>
                                    @enderror
                                </label>

                                <!-- telefone -->
                                <label class="block  col-12 col-lg-4">
                                    <span class="text-gray-700 dark:text-gray-200 d-block mb-1">Telefone<span
                                            class="text-danger">*</span></span>
                                    <input id="telefone" name="telefone"
                                        value="{{ old('telefone', $data_empresa->telefone) }}"
                                        class="form-control @error('telefone') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        placeholder="">
                                    @error('telefone')
                                        <div class="invalid-feedback bold">{{ $message }}</div>
                                    @enderror
                                </label>

                                <!-- whatsapp -->
                                <label class="block  col-12 col-lg-4">
                                    <span class="text-gray-700 dark:text-gray-200 d-block mb-1">WhatsApp<span
                                            class="text-danger">*</span></span>
                                    <input maxlength="15" name="whatsapp" id="whatsapp"
                                        value="{{ old('whatsapp', $data_empresa->whatsapp) }}"
                                        class="form-control @error('whatsapp') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        placeholder="">
                                    @error('whatsapp')
                                        <div class="invalid-feedback bold">{{ $message }}</div>
                                    @enderror
                                </label>

                                <!-- email -->
                                <label class="block  col-12 col-lg-4">
                                    <span class="text-gray-700 dark:text-gray-200 d-block mb-1">E-mail<span
                                            class="text-danger">*</span></span>
                                    <input id="email" name="email" value="{{ old('email', $data_empresa->email) }}"
                                        class="form-control @error('email') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        placeholder="">
                                    @error('email')
                                        <div class="invalid-feedback bold">{{ $message }}</div>
                                    @enderror
                                </label>

                                <!-- nome_contato -->
                                <label class="block  col-12 col-lg-4">
                                    <span class="text-gray-700 dark:text-gray-200 d-block mb-1">Nome do contato</span>
                                    <input name="nome_contato"
                                        value="{{ old('nome_contato', $data_empresa->nome_contato) }}"
                                        class="form-control @error('nome_contato') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        placeholder="">
                                    @error('nome_contato')
                                        <div class="invalid-feedback bold">{{ $message }}</div>
                                    @enderror
                                </label>

                                <!-- telefone_contato -->
                                <label class="block  col-12 col-lg-4">
                                    <span class="text-gray-700 dark:text-gray-200 d-block mb-1">Telefone do contato<span
                                            class="text-danger">*</span></span>
                                    <input id="telefone-contao" name="telefone_contato"
                                        value="{{ old('telefone_contato', $data_empresa->telefone_contato) }}"
                                        class="form-control @error('telefone_contato') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        placeholder="">
                                    @error('telefone_contato')
                                        <div class="invalid-feedback bold">{{ $message }}</div>
                                    @enderror
                                </label>

                                <!-- endereco -->
                                <label class="block  col-12 col-lg-4">
                                    <span class="text-gray-700 dark:text-gray-200 d-block mb-1">Endereço<span
                                            class="text-danger">*</span></span>
                                    <input name="endereco" id="endereco"
                                        value="{{ old('endereco', $data_empresa->endereco) }}"
                                        class="form-control @error('endereco') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        placeholder="">
                                    @error('endereco')
                                        <div class="invalid-feedback bold">{{ $message }}</div>
                                    @enderror
                                </label>

                                <!-- numero_end -->
                                <label class="block  col-12 col-lg-4">
                                    <span class="text-gray-700 dark:text-gray-200 d-block mb-1">Número<span
                                            class="text-danger">*</span></span>
                                    <input name="numero_end" id="numero"
                                        value="{{ old('numero_end', $data_empresa->numero_end) }}"
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
                                        value="{{ old('ponto_referencia', $data_empresa->ponto_referencia) }}"
                                        class="form-control @error('ponto_referencia') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        placeholder="">
                                    @error('ponto_referencia')
                                        <div class="invalid-feedback bold">{{ $message }}</div>
                                    @enderror
                                </label>

                                <!-- complemento -->
                                <label class="block  col-12 col-lg-4">
                                    <span class="text-gray-700 dark:text-gray-200 d-block mb-1">Complemento</span>
                                    <input name="complemento"
                                        value="{{ old('complemento', $data_empresa->complemento) }}"
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
                                    <input name="uf" id="uf" value="{{ old('uf', $data_empresa->uf) }}"
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
                                    <input name="cidade" id="cidade"
                                        value="{{ old('cidade', $data_empresa->cidade) }}"
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
                                    <input name="bairro" id="bairro"
                                        value="{{ old('bairro', $data_empresa->bairro) }}"
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
                                    <input id="cep" name="cep" value="{{ old('cep', $data_empresa->cep) }}"
                                        class="form-control @error('cep') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        placeholder="">
                                    @error('cep')
                                        <div class="invalid-feedback bold">{{ $message }}</div>
                                    @enderror
                                </label>
                                <!-- cor -->
                                <label class="block  col-12 col-lg-2">
                                    <span class="text-gray-700 dark:text-gray-200 d-block mb-1">Cor</span>
                                    <input type="color" id="cor" name="cor"
                                        value="{{ old('cor', $data_empresa->cor) }}"
                                        class="form-control @error('cor') is-invalid @enderror w-full pl-3  pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        placeholder="">
                                    @error('cor')
                                        <div class="invalid-feedback bold">{{ $message }}</div>
                                    @enderror
                                </label>

                                <!-- Ativo: -->
                                <div class="col-12 col-lg-3 col-xl-3 mb-3">
                                    <span class="text-gray-700 dark:text-gray-200 d-block mb-1">
                                        Ativo<span class="text-danger">*</span>
                                    </span>
                                    <select
                                        class="@error('ativo') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                        name="ativo" id="ativo" required>
                                        <option value="S" selected> SIM </option>
                                        <option value="N" @if (old('ativo', $data_empresa->ativo) == 'N') selected @endif> NÂO
                                        </option>
                                    </select>
                                    @error('ativo')
                                        <div class="invalid-feedback fw-bold">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- sobre -->
                                <label class="block mt-4  col-12">
                                    <span class="text-gray-700 dark:text-gray-200 d-block mb-1">Sobre a empresa<span
                                            class="text-danger">*</span></span>
                                    <textarea name="sobre"
                                        class="form-control @error('sobre') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        rows="3" placeholder="">{{ old('sobre', $data_empresa->sobre) }}</textarea>
                                    @error('sobre')
                                        <div class="invalid-feedback bold">{{ $message }}</div>
                                    @enderror
                                </label>

                            </div>
                        </div>

                        <!-- Dados Fiscais -->
                        <h4 class=" h5 fw-bold text-lg font-semibold text-gray-600 dark:text-gray-300">
                            Dados Fiscais
                        </h4>
                        <div class=" py-3 mb-8 bg-white rounded-lg  dark:bg-gray-800">
                            <div class="row gy-4">

                                <!-- cnae -->
                                <label class="block col-12 col-lg-4">
                                    <span class="text-gray-700 dark:text-gray-200 mb-1 d-block">CNAE</span>
                                    <input name="cnae" value="{{ old('cnae', $data_empresa->cnae) }}"
                                        class="form-control @error('cnae') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        placeholder="">
                                    @error('cnae')
                                        <div class="invalid-feedback bold">{{ $message }}</div>
                                    @enderror
                                </label>

                                <!-- insc_estadual -->
                                <label class="block col-12 col-lg-4">
                                    <span class="text-gray-700 dark:text-gray-200 mb-1 d-block">Insc. Estadual</span>
                                    <input name="insc_estadual"
                                        value="{{ old('insc_estadual', $data_empresa->insc_estadual) }}"
                                        class="form-control @error('insc_estadual') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        placeholder="">
                                    @error('insc_estadual')
                                        <div class="invalid-feedback bold">{{ $message }}</div>
                                    @enderror
                                </label>

                                <!-- insc_estadual_subs -->
                                <label class="block col-12 col-lg-4">
                                    <span class="text-gray-700 dark:text-gray-200 mb-1 d-block">Insc. Estadual Subs.
                                        Trib.</span>
                                    <input name="insc_estadual_subs"
                                        value="{{ old('insc_estadual_subs', $data_empresa->insc_estadual_subs) }}"
                                        class="form-control @error('insc_estadual_subs') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        placeholder="">
                                    @error('insc_estadual_subs')
                                        <div class="invalid-feedback bold">{{ $message }}</div>
                                    @enderror
                                </label>

                                <!-- insc_municipal -->
                                <label class="block col-12 col-lg-4">
                                    <span class="text-gray-700 dark:text-gray-200 mb-1 d-block">Insc. Municipal</span>
                                    <input name="insc_municipal"
                                        value="{{ old('insc_municipal', $data_empresa->insc_municipal) }}"
                                        class="form-control @error('insc_municipal') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        placeholder="">
                                    @error('insc_municipal')
                                        <div class="invalid-feedback bold">{{ $message }}</div>
                                    @enderror
                                </label>

                                <!-- cod_ibge -->
                                <label class="block col-12 col-lg-4">
                                    <span class="text-gray-700 dark:text-gray-200 mb-1 d-block">Cód. IBGE Cidade</span>
                                    <input name="cod_ibge" value="{{ old('cod_ibge', $data_empresa->cod_ibge) }}"
                                        class="form-control @error('cod_ibge') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        placeholder="">
                                    @error('cod_ibge')
                                        <div class="invalid-feedback bold">{{ $message }}</div>
                                    @enderror
                                </label>

                                <!-- regime_tributario -->
                                <label class="block mt-4 col-12 col-lg-4">
                                    <span class="text-gray-700 dark:text-gray-200 mb-1 d-block">
                                        Regime Tributário
                                    </span>
                                    <select name="regime_tributario"
                                        class="form-control @error('regime_tributario') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input">
                                        <option name="nada" value="" selected>Nada Selecionado</option>
                                        <option name="Simples Nacional" value="simples_nacional"
                                            @if (old('regime_tributario', $data_empresa->regime_tributario) == 'simples_nacional') selected @endif>
                                            Simples Nacional
                                        </option>
                                        <option name="Lucro Presumido" value="lucro_presumido"
                                            @if (old('regime_tributario', $data_empresa->regime_tributario) == 'lucro_presumido') selected @endif>
                                            Lucro Presumido
                                        </option>
                                        <option name="Lucro Real" value="lucro_real"
                                            @if (old('regime_tributario', $data_empresa->regime_tributario) == 'lucro_real') selected @endif>
                                            Lucro Real
                                        </option>
                                    </select>
                                    @error('regime_tributario')
                                        <div class="invalid-feedback bold">{{ $message }}</div>
                                    @enderror
                                </label>

                                <!-- empresa_aberta -->
                                <div class="mt-4 ">
                                    <div class=" mt-3">
                                        <button type="submit" class="btn btn-success bg-success px-4 mt-3 ">
                                            <div class="d-flex align-items-center gap-2">
                                                Salvar
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
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
        // var whatsapp = IMask(document.getElementById('whatsapp'), {
        //     mask: [{
        //             mask: '(00)00000-0000'
        //         },
        //         {
        //             mask: '0000000000000000000000000000'
        //         }
        //     ]
        // });
        // var telefone_contao = IMask(document.getElementById('telefone-contao'), {
        //     mask: [{
        //             mask: '(00)00000-0000'
        //         },
        //         {
        //             mask: '0000000000000000000000000000'
        //         }
        //     ]
        // });
        var cnpj = IMask(document.getElementById('cnpj'), {
            mask: '00.000.000/0000-00'
        });
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

@endsection
