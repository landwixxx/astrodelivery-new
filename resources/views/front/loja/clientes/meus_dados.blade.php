@extends('layouts.front.loja.app', ['store' => $store])
@section('titulo', 'Meus Dados - ' . $store->nome)
@section('content')

    <section>
        <div class="container py-5 mt-5">
            <div class="col-12 col-lg-9 mx-auto">

                {{-- Alerta sucesso --}}
                <x-alert-success />

                <h1 class="h3">Meus Dados</h1>
                <p class="small">
                    Campos com <strong class="text-danger">*</strong> são obrigatórios
                </p>

                <div class="card bg-light">
                    <div class="card-body p-lg-4">
                        <!-- Formulário dados pessoais -->
                        <form
                            action="{{ route('cliente.meus-dados.up-pessoal', ['slug_store' => $store->slug_url, $store->id]) }}"
                            method="post">
                            @method('PUT')
                            @csrf
                            <div class="row dark:text-gray-200">
                                <div class="col-12">
                                    <h2 class="h5 fw-700"> Dados Pessoais</h2>
                                </div>
                                @php
                                    /* Add dados a variáveis se existir */
                                    $user = Auth::user();
                                    $cpf = $user->data_customer ? $user->data_customer->cpf : null;
                                    $telefone = $user->data_customer ? $user->data_customer->telefone : null;
                                    $whatsapp = $user->data_customer ? $user->data_customer->whatsapp : null;
                                    $dt_nascimento = $user->data_customer ? $user->data_customer->dt_nascimento : null;
                                    $endereco = $user->data_customer ? $user->data_customer->endereco : null;
                                    $numero_end = $user->data_customer ? $user->data_customer->numero_end : null;
                                    $ponto_referencia = $user->data_customer ? $user->data_customer->ponto_referencia : null;
                                    $complemento = $user->data_customer ? $user->data_customer->complemento : null;
                                    $estado = $user->data_customer ? $user->data_customer->estado : null;
                                    $cidade = $user->data_customer ? $user->data_customer->cidade : null;
                                    $bairro = $user->data_customer ? $user->data_customer->bairro : null;
                                    $rua = $user->data_customer ? $user->data_customer->rua : null;
                                    $cep = $user->data_customer ? $user->data_customer->cep : null;
                                @endphp
                                <!-- Nome -->
                                <div class="col-12 col-lg-4 col-xl-4 mb-3">
                                    <label for="name" class="form-label fw-500">
                                        Nome<span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        class="@error('name') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                        name="name" id="name" value="{{ old('name', auth()->user()->name) }}"
                                        required>
                                    @error('name')
                                        <div class="invalid-feedback fw-bold">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- CPF -->
                                <div class="col-12 col-lg-4 col-xl-4 mb-3">
                                    <label for="cpf" class="form-label fw-500">
                                        CPF
                                    </label>
                                    <input type="text"
                                        class="form-control @error('cpf') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="cpf" id="cpf" value="{{ old('cpf', $cpf) }}"
                                        placeholder="000.000.000-00">
                                    @error('cpf')
                                        <div class="invalid-feedback fw-bold">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Telefone -->
                                <div class="col-12 col-lg-4 col-xl-4 mb-3">
                                    <label for="telefone" class="form-label fw-500">
                                        Telefone<span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control @error('telefone') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="telefone" id="telefone" value="{{ old('telefone', $telefone) }}"
                                        placeholder="(00) 00000-0000" required>
                                    @error('telefone')
                                        <div class="invalid-feedback fw-bold">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- whatsapp -->
                                <div class="col-12 col-lg-4 col-xl-4 mb-3">
                                    <label for="whatsapp" class="form-label fw-500">
                                        WhatsApp<span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control @error('whatsapp') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="whatsapp" id="whatsapp" value="{{ old('whatsapp', $whatsapp) }}"
                                        placeholder="(00) 00000-0000" required>
                                    @error('whatsapp')
                                        <div class="invalid-feedback fw-bold">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Dt Nascimento -->
                                <div class="col-12 col-lg-4 col-xl-4 mb-3">
                                    <label for="dt_nascimento" class="form-label fw-500">
                                        Data de nascimento
                                    </label>
                                    <input type="date"
                                        class="form-control @error('dt_nascimento') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="dt_nascimento" id="dt_nascimento"
                                        value="{{ old('dt_nascimento', $dt_nascimento) }}" placeholder="">
                                    @error('dt_nascimento')
                                        <div class="invalid-feedback fw-bold">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- ========== Início Endereço ========== -->
                                <div class="col-12 mt-4">
                                    <h2 class="h5 fw-700">Dados de Endereço</h2>
                                </div>

                                <!-- Endereço -->
                                <div class="col-12 col-lg-4 col-xl-4 mb-3">
                                    <label for="endereco" class="form-label fw-500">
                                        Endereço<span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control @error('endereco') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="endereco" id="endereco" value="{{ old('endereco', $endereco) }}"
                                        placeholder="" required>
                                    @error('endereco')
                                        <div class="invalid-feedback fw-bold">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Estado -->
                                <div class="col-12 col-lg-4 col-xl-4 mb-3">
                                    <label for="estado" class="form-label fw-500">
                                        Estado<span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control @error('estado') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="estado" id="estado" value="{{ old('estado', $estado) }}"
                                        placeholder="São Paulo, Rio de Janeiro, Goiás ..." required>
                                    @error('estado')
                                        <div class="invalid-feedback fw-bold">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- cidade -->
                                <div class="col-12 col-lg-4 col-xl-4 mb-3">
                                    <label for="cidade" class="form-label fw-500">
                                        Cidade<span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control @error('cidade') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="cidade" id="cidade" value="{{ old('cidade', $cidade) }}" placeholder=""
                                        required>
                                    @error('cidade')
                                        <div class="invalid-feedback fw-bold">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- bairro -->
                                <div class="col-12 col-lg-4 col-xl-4 mb-3">
                                    <label for="bairro" class="form-label fw-500">
                                        Bairro<span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control @error('bairro') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="bairro" id="bairro" value="{{ old('bairro', $bairro) }}"
                                        placeholder="" required>
                                    @error('bairro')
                                        <div class="invalid-feedback fw-bold">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- rua -->
                                <div class="col-12 col-lg-4 col-xl-4 mb-3">
                                    <label for="rua" class="form-label fw-500">
                                        Rua<span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control @error('rua') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="rua" id="rua" value="{{ old('rua', $rua) }}" placeholder=""
                                        required>
                                    @error('rua')
                                        <div class="invalid-feedback fw-bold">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- Número -->
                                <div class="col-12 col-lg-4 col-xl-4 mb-3">
                                    <label for="numero_end" class="form-label fw-500">
                                        Número de endereço<span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control @error('numero_end') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="numero_end" id="numero_end" value="{{ old('numero_end', $numero_end) }}"
                                        placeholder="" required>
                                    @error('numero_end')
                                        <div class="invalid-feedback fw-bold">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- Ponto de referência -->
                                <div class="col-12 col-lg-4 col-xl-4 mb-3">
                                    <label for="ponto_referencia" class="form-label fw-500">
                                        Ponto de referência
                                    </label>
                                    <input type="text"
                                        class="form-control @error('ponto_referencia') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="ponto_referencia" id="ponto_referencia"
                                        value="{{ old('ponto_referencia', $ponto_referencia) }}" placeholder="">
                                    @error('ponto_referencia')
                                        <div class="invalid-feedback fw-bold">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- Complemento -->
                                <div class="col-12 col-lg-4 col-xl-4 mb-3">
                                    <label for="complemento" class="form-label fw-500">
                                        Complemento
                                    </label>
                                    <input type="text"
                                        class="form-control @error('complemento') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="complemento" id="complemento"
                                        value="{{ old('complemento', $complemento) }}" placeholder="">
                                    @error('complemento')
                                        <div class="invalid-feedback fw-bold">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- cep -->
                                <div class="col-12 col-lg-4 col-xl-4 mb-3">
                                    <label for="cep" class="form-label fw-500">
                                        CEP<span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control @error('cep') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="cep" id="cep" value="{{ old('cep', $cep) }}"
                                        placeholder="00000-000" required>
                                    @error('cep')
                                        <div class="invalid-feedback fw-bold">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- ========== Fim Endereço ========== -->

                                <div class="col-12 mb-4">
                                    <button type="submit"
                                        class="btn btn-primary px-4 mt-2 d-flex align-items-center gap-2 fw-semibold">
                                        <i class="fa-regular fa-floppy-disk fa-sm"></i>
                                        Salvar
                                    </button>
                                </div>

                            </div>
                        </form>

                        <!-- Formulário credenciais -->
                        <form action="{{ route('cliente.meus-dados.up-credenciais', ['slug_store' => $store->slug_url, $store->id]) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row dark:text-gray-200">

                                <!-- Credenciaris de acesso -->
                                <div class="col-12">
                                    <h2 class="h5 fw-700 pt-2">Credenciais de acesso</h2>
                                </div>

                                <!-- Email -->
                                <div class="col-12 col-lg-4 col-xl-3 mb-3 ">
                                    <label for="email" class="form-label">
                                        E-mail<span class="text-danger">*</span>
                                    </label>
                                    <input type="email"
                                        class="form-control @error('email') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="email" value="{{ old('email', Auth::user()->email) }}" id="email">
                                    @error('email')
                                        <div class="invalid-feedback fw-bold">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Senha atual -->
                                <div class="col-12 col-lg-4 col-xl-3 mb-3">
                                    <label for="current_password" class="form-label">
                                        Senha atual<span class="text-danger">*</span>
                                    </label>

                                    <input id="current_password" type="password"
                                        class="form-control @error('current_password') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="current_password" required autocomplete="new-password">

                                    @error('current_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Nova senha -->
                                <div class="col-12 col-lg-4 col-xl-3 mb-3">
                                    <label for="password" class="form-label">
                                        Nova senha<span class="text-danger">*</span>
                                    </label>

                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Repetir senha -->
                                <div class="col-12 col-lg-4 col-xl-3 mb-3">
                                    <label for="password-confirm" class="form-label">
                                        Confirmar nova senha<span class="text-danger">*</span>
                                    </label>
                                    <div class="">
                                        <input id="password-confirm" type="password"
                                            class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                            name="password_confirmation" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-warning px-4 mt-3 bg-warning">
                                        <div class="d-flex align-items-center gap-2">
                                            Salvar
                                        </div>
                                    </button>

                                </div>

                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <!-- Mascaras de input -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/imask/6.4.3/imask.min.js"></script>
    <script>
        var telefone = IMask(document.getElementById('telefone'), {
            mask: '(00) 00000-0000'
        });
        var cpf = IMask(document.getElementById('cpf'), {
            mask: '000.000.000-00'
        });
        var whatsapp = IMask(document.getElementById('whatsapp'), {
            mask: '(00) 00000-0000'
        });
        var numero_end = IMask(document.getElementById('numero_end'), {
            mask: '000000000'
        });
        var numero_end = IMask(document.getElementById('cep'), {
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
