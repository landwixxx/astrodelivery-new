@extends('layouts.painel.app')
@section('title', 'Editar entrega mesa')
@section('head')

    <!-- Icons FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- Select2 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/i18n/pt-BR.js"></script>

@endsection
@section('content')
    <br>
    {{-- Alertas --}}
    <x-alerts />

    <div class="container-fluid px-6 mx-auto grid tipo-entrega">
        <br>

        <!-- Editar entrega mesa -->
        <div class="w-full overflow-hidden rounded-lg ">
            <h2 class="my-2 text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-1">
                Editar entrega mesa
            </h2>
            <p class="small dark:text-gray-200 mb-3 ">
                Campos com <strong class="text-danger">*</strong> são obrigatórios
            </p>

            <div class="card border dark:border-none bg-white">
                <div class="card-body">
                    <!-- Formulário -->
                    <form action="{{ route('painel.lojista.entrega-mesa.update', $deliveryTable->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row dark:text-gray-200 gy-4">

                            <!-- Tipo: -->
                            <div class="col-12 col-lg-4 col-xl-3 ">
                                <label for="tipo_entrega_id" class="form-label fw-500">
                                    Tipo de entrega<span class="text-danger">*</span>
                                </label>
                                <div class="">
                                    <select class="selecionar-tipo w-100" name="tipo_entrega_id" required>
                                        <!-- options -->
                                        @if (old('tipo_entrega_id', $deliveryTable->tipo_entrega_id))
                                            <option value="{{ old('tipo_entrega_id', $deliveryTable->tipo_entrega_id) }}">
                                                {{ \App\Models\DeliveryType::find(old('tipo_entrega_id', $deliveryTable->tipo_entrega_id))->nome }}
                                            </option>
                                        @endif
                                    </select>
                                </div>
                                @error('tipo_entrega_id')
                                    <div class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Mesa -->
                            <div class="col-12 col-lg-4 col-xl-3 ">
                                <label for="mesa" class="form-label fw-500">
                                    Mesa<span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="@error('mesa') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                    name="mesa" id="mesa" value="{{ old('mesa', $deliveryTable->mesa) }}" required>
                                @error('mesa')
                                    <div class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Descrição -->
                            <div class="col-12 col-lg-4 col-xl-6">
                                <label for="descricao" class="form-label fw-500">
                                    Descrição
                                </label>
                                <input type="text"
                                    class="@error('descricao') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                    name="descricao" id="descricao"
                                    value="{{ old('descricao', $deliveryTable->descricao) }}">
                                @error('descricao')
                                    <div class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!--status: -->
                            <div class="col-12 col-lg-4 col-xl-3 ">
                                <label for="" class="form-label fw-500">
                                    Status
                                </label>
                                <div class="">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="status-ativo"
                                            value="ativo" required @if (old('status', $deliveryTable->status) == 'ativo') checked @endif>
                                        <label class="form-check-label" for="status-ativo">Ativo</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="status-desativado"
                                            value="desativado" @if (old('status', $deliveryTable->status) == 'desativado') checked @endif>
                                        <label class="form-check-label" for="status-desativado">Desativado</label>
                                    </div>
                                </div>
                                @error('ativo')
                                    <div class="invalid-feedback ">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary bg-primary px-4 mt-3 ">
                                    Atualizar
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

    <script>
        /* Ativar popovers bootstrap */
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

        /* Select2 - Selecionar tipo */
        $(document).ready(function() {
            $('.selecionar-tipo').select2({
                placeholder: 'Selecione uma opção',
                "language": "pt-BR",
                data: @json($dataDeliveryTypes),
            })
        });
    </script>

@endsection
