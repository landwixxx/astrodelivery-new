@extends('layouts.front.app')
@section('titulo', 'Solicitar Teste Grátis - ' . config('app.name', 'Web Site'))
@section('content')

    <!-- Solicitar teste grátis -->
    <section>
        <div class="min-vh-100 conteudo-topo mb-5 pb-5">
            <div class="container pt-5 mt-5">
                <div class="row justify-content-center align-items-center gx-5 text-center text-lg-start pt-3">
                    <div class="col-12 col-lg-12 sorder-2 sorder-lg-1 mb-4 mb-lg-0 order-2 order-lg-1 text-center">
                        <h1 class=" fw-bold ">
                            <span class="">
                                Solicitar Teste Grátis
                            </span>
                        </h1>
                        <p class="fs-5 text-muted mb-lg-4 pb-lg-3 col-12 col-lg-8 mx-auto">
                            Se você tiver dúvidas sobre a utilização do nosso sistema, solicite um teste grátis que vamos
                            disponibilizar uma conta de acesso para você testar todas as funcionalidades disponíveis.
                        </p>

                        <!-- Formulários -->
                        <div class="bg-white border p-4 shadow-sm rounded col-12 col-lg-5 mx-auto">
                            <div class="p-2 py-3 text-start">


                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show text-start mb-5"
                                        role="alert">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        Solicitação enviada com sucesso!<br>
                                        Um login de acesso foi enviado para o e-mail informado.<br><br>
                                        <a href="{{ route('login') }}" class="">Clieque aqui</a> para fazer login.
                                    </div>
                                @endif

                                <h2 class="text-start h6 text-muted text-uppercase mb-4 fw-lighter">Preencha o formulário
                                </h2>

                                <form action="{{ route('solicitar-teste-gratis.store') }}" method="post">
                                    @csrf
                                    <!-- Nome -->
                                    <div class="mb-3">
                                        <label for="nome" class="form-label mb-1 fw-semibold ">Nome e Sobrenome</label>
                                        <input type="text"
                                            class="form-control rounded-3  bg-light rounded-1 shadow-none @error('nome') is-invalid @enderror"
                                            name="nome" id="nome" value="{{ old('nome') }}"
                                            placeholder="Ex: José Carlos" required>
                                        @error('nome')
                                            <div class="invalid-feedback fw-bold text-start">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Meio de contato -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label mb-1 fw-semibold ">
                                            E-mail
                                        </label>
                                        <input type="email" value="{{ old('email') }}"
                                            class="form-control rounded-3  bg-light rounded-1 shadow-none @error('email') is-invalid @enderror"
                                            name="email" id="email" placeholder="Digite um e-mail válido" required>
                                        @error('email')
                                            <div class="invalid-feedback fw-bold text-start">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Meio de contato -->
                                    <div class="mb-3">
                                        <label for="meio_contato" class="form-label mb-1 fw-semibold ">
                                            Meio para contato
                                        </label>

                                        <div class="d-flex flex-column flex-lg-row gap-lg-4 mb-2">
                                            <div class="form-check ">
                                                <input
                                                    class="form-check-input @error('meio_contato') is-invalid @endif" type="radio" name="meio_contato"
                                                    value="e-mail" id="meio-email" @if (old('meio_contato') == 'e-mail') checked @endif required>
                                                <label class="form-check-label" for="meio-email">
                                                    E-mail
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input @error('meio_contato') is-invalid @endif" type="radio" name="meio_contato"
                                                    value="telefone" id="meio-tel" @if (old('meio_contato') == 'telefone') checked @endif>
                                                <label class="form-check-label" for="meio-tel">
                                                    Telefone
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input @error('meio_contato') is-invalid @endif" type="radio" name="meio_contato"
                                                    value="whatsapp" id="meio-whats" @if (old('meio_contato') == 'whatsapp') checked @endif>
                                                <label class="form-check-label" for="meio-whats">
                                                    WhatsApp
                                                </label>
                                            </div>
                                        </div>

                                        <div class=" @if ($errors->any()) d-block @else d-none @endif" id="div-input-meio-contato">
                                            <input type="text" value="{{ old('contato') }}"
                                                class="form-control rounded-3  bg-light rounded-1 shadow-none @error('contato') is-invalid @enderror"
                                                    name="contato" id="input-meio-contato" placeholder="" required>
                                                @error('contato')
                                                    <div class="invalid-feedback fw-bold text-start">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                        <!-- Mensagem -->
                                        <div class="mb-3">
                                            <label for="msg" class="form-label mb-1 fw-semibold ">Mensagem <span
                                                    class="fs-11px text-muted">(Opcional)</span></label>
                                            <textarea rows="3"
                                                class="form-control rounded-3  bg-light rounded-1 shadow-none @error('msg') is-invalid @enderror" name="msg"
                                                id="msg" placeholder="Digite uma mensagem">{{ old('msg') }}</textarea>
                                            @error('msg')
                                                <div class="invalid-feedback fw-bold text-start">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="text-start mt-4">
                                            <button type="submit" class="btn btn-outline-primary rounded-pill fw-bold"
                                                onclick="this.classList.add('disabled')" id="btn-submit">
                                                <div class="py-1 fs-6 px-1">
                                                    <i class="fa-regular fa-paper-plane me-1 fa-sm"></i>
                                                    Enviar
                                                </div>
                                            </button>
                                        </div>
                                </form>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection


@section('scripts')
    <script>
        /* Exibir input para meio de contatos */
        function exibirInputMeioContato(placeholder) {
            document.querySelector('#div-input-meio-contato').className = 'd-block'
            document.querySelector('#input-meio-contato').placeholder = placeholder
            document.querySelector('#input-meio-contato').value = '';
        }
        document.querySelector('#meio-email').onchange = function() {
            exibirInputMeioContato('E-mail');
        }
        document.querySelector('#meio-tel').onchange = function() {
            exibirInputMeioContato('Telefone');
        }
        document.querySelector('#meio-whats').onchange = function() {
            exibirInputMeioContato('WhatsApp');
        }

        document.querySelectorAll('input').onchange = function() {
            alert('ok')
        }

        /* remover class 'disabled' de btn */
        var inputs = document.getElementsByTagName('input');
        for (index = 0; index < inputs.length; ++index) {
            inputs[index].onkeyup= function() {
                document.querySelector('#btn-submit').classList.remove('disabled')
            }
        }
    </script>


@endsection
