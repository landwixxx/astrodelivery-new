@extends('layouts.painel.app')
@section('title', 'Editar Lojista')
@section('content')
    <br>

    {{-- Alertas --}}
    <x-alerts />

    <div class="container-fluid px-6 mx-auto grid">
        <br>

        <!-- Editar Lojista -->
        <div class="w-full overflow-hidden rounded-lg ">
            <h1 class="h4 fw-bold text-gray-600 dark:text-gray-200 mb-4">Editar Lojista</h1>


            <div class="card border dark:border-none bg-white">
                <div class="card-body">
                    <!-- Formulário dados pessoais -->
                    <form action="{{ route('painel.admin.lojistas.update', $user->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row dark:text-gray-200">
                            <div class="col-12">
                                <h2 class="h5 fw-700 mb-3"> Dados Pessoais</h2>
                            </div>
                            <!-- Nome -->
                            <div class="col-12 col-lg-4 col-xl-4 mb-3">
                                <label for="name" class="form-label fw-500">
                                    Nome<span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="@error('name') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                    name="name" id="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback fw-bold">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Telefone -->
                            <div class="col-12 col-lg-4 col-xl-4 mb-3">
                                <label for="phone" class="form-label fw-500">
                                    Telefone<span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control @error('phone') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                    name="phone" id="phone" placeholder="(00) 00000-0000"
                                    value="{{ old('phone', $user->phone) }}" required>
                                @error('phone')
                                    <div class="invalid-feedback fw-bold">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary bg-primary px-4 mt-3 ">
                                    <div class="d-flex align-items-center gap-2">
                                        Salvar
                                    </div>
                                </button>

                            </div>

                        </div>
                    </form>

                    <hr class="mt-5 mb-4 pb-2">

                    <!-- Formulário credenciais -->
                    <form action="{{ route('painel.admin.lojistas.atualizar-credenciais', $user->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row dark:text-gray-200">
                            <!-- Credenciaris de acesso -->
                            <div class="col-12">
                                <h2 class="h5 fw-700 pt-2 mb-3">Credenciais de acesso</h2>
                            </div>

                            <!-- Email -->
                            <div class="col-12 col-lg-4 col-xl-4 mb-3 ">
                                <label for="email" class="form-label">
                                    E-mail<span class="text-danger">*</span>
                                </label>
                                <input type="email"
                                    class="form-control @error('email') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                    name="email" id="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback fw-bold">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Nova senha -->
                            <div class="col-12 col-lg-4 col-xl-4 mb-3">
                                <label for="password" class="form-label">Senha<span class="text-danger">*</span></label>

                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                    name="password" required>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Repetir senha -->
                            <div class="col-12 col-lg-4 col-xl-4 mb-3">
                                <label for="password-confirm" class="form-label">Confirmar senha<span
                                        class="text-danger">*</span></label>
                                <div class="">
                                    <input id="password-confirm" type="password"
                                        class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-warning bg-warning px-4 mt-3 ">
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


    <div class="py-4"></div>

@endsection

@section('scripts')
    <!-- Mascaras de input -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/imask/6.4.3/imask.min.js"></script>
    <script>
        var phone = IMask(document.getElementById('phone'), {
            mask: '(00) 00000-0000'
        });
    </script>

@endsection
