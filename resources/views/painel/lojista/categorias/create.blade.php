@extends('layouts.painel.app')
@section('title', 'Adicionar Categoria')
@section('content')
    <br>

    {{-- Alertas --}}
    <x-alerts />

    <div class="container px-6 mx-auto grid mb-5 pb-4">

        <!-- Cadastrar -->
        <div class="container px-0 mx-auto grid mb-5">
            <br>

            <div class="w-full overflow-hidden rounded-lg ">
                <h1 class="h4 fw-bold text-gray-600 dark:text-gray-200 mb-2">Adicionar Categoria</h1>

                <div class="card border dark:border-none bg-white">
                    <div class="card-body">
                        <!-- Formulário -->
                        <form action="{{ route('painel.lojista.categorias.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf

                            <div class=" py-3 mb-0 bg-white rounded-lg  dark:bg-gray-800">
                                <div class="row gy-4 ">

                                    <!-- foto -->
                                    <div class=" col-12 col-lg-4 dark:text-gray-200 ">
                                        <label for="foto">
                                            Foto<span class="text-danger">*</span>
                                        </label>
                                        <div class="d-flex  gap-2">
                                            <img src="{{ asset('assets/img/img-prod-vazio.png') }}" alt=""
                                                width="100" id="img-previa">
                                            <div class="">
                                                <input type="file" name="foto" id="foto"
                                                    accept=".jpg,.jpeg,.png,.gif,.bmp,.webp" class="w-100" required>
                                                <div class="fs-11px text-muted pt-1">
                                                    Tipos suportados: jpg, jpeg, png, gif, bmp, webp
                                                </div>
                                            </div>
                                        </div>
                                        @error('foto')
                                            <div class="text-danger bold mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- nome -->
                                    <label class="block col-12 col-lg-3">
                                        <span class="text-gray-700 dark:text-gray-200 d-block mb-1">Nome<span
                                                class="text-danger">*</span></span>
                                        <input name="nome" id="nome" value="{{ old('nome') }}"
                                            class="form-control @error('nome') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                            id="nome" placeholder="" required>
                                        @error('nome')
                                            <div class="invalid-feedback bold">{{ $message }}</div>
                                        @enderror
                                    </label>

                                    <!-- tipo -->
                                    <div class="col-12 col-lg-3">
                                        <label for="ativo" class="form-label fw-500 dark:text-gray-200">
                                            Ativo<span class="text-danger">*</span>
                                        </label>
                                        <select
                                            class="@error('ativo') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                            name="ativo" id="ativo" required>
                                            <option value="S" @if (old('ativo') == 'S')  @endif> Sim </option>
                                            <option value="N" @if (old('ativo') == 'N')  @endif> Não </option>
                                        </select>
                                        @error('ativo')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Descrição -->
                                    <label class="block mt-4  col-lg-12">
                                        <span class="text-gray-700 dark:text-gray-200 d-block mb-1">Descrição</span>
                                        <textarea name="descricao"
                                            class="form-control @error('descricao') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                            rows="3" placeholder="">{{ old('descricao') }}</textarea>
                                        @error('descricao')
                                            <div class="invalid-feedback bold">{{ $message }}</div>
                                        @enderror
                                    </label>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary bg-primary">Cadastrar</button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection


@section('scripts')
    <!-- Prévia de imagem -->
    <script>
        function onFileChange() {
            let e = document.getElementById('foto')
            let files = e.files || e.dataTransfer.files;
            if (!files.length) {
                return
            }
            createImage(files[0])
        }

        function createImage(file) {
            let reader = new FileReader()
            reader.onload = (e) => {
                document.getElementById('img-previa').src = e.target.result
            }
            reader.readAsDataURL(file)
        }
        document.getElementById('foto').onchange = () => {
            onFileChange()
        }
    </script>
@endsection
