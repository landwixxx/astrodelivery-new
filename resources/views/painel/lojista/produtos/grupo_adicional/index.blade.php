@extends('layouts.painel.app')
@section('title', 'Grupo de adicional')
@section('content')
    <br>

    {{-- Alertas --}}
    <x-alerts />

    <div class="container-fluid px-6 mx-auto grid dark:text-gray-200 mb-5 pb-5">
        <h2 class="my-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Grupo de adicional
        </h2>

        <div class="w-full overflow-x-auto px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">

            <div class="text-end mb-3">
                <a href="{{ route('painel.lojista.grupo-adicional.create') }}">
                    <button
                        class="px-4 py-2 border-0 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Cadastrar
                    </button>
                </a>
            </div>

            <div class="w-full overflow-x-auto ">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-1 py-2">Nome</th>
                            <th class="px-1 py-2">Descrição</sub></th>
                            <th class="px-1 py-2">Qtd. Mínima</th>
                            <th class="px-1 py-2">Qtd. Máxima</sub></th>
                            <th class="px-1 py-2">Junção</th>
                            <th class="px-1 py-2">Ordem</th>
                            <th class="px-1 py-2">Ordem Interna</th>
                            <th class="px-1 py-2">Ações</th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @if ($additionalGroups->total() == 0)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-3 py-3 text-sm text-center py-5" colspan="8">
                                    <div class="d-flex gap-1 align-items-center justify-content-center">
                                        <span class="material-symbols-outlined fs-6 ">
                                            info
                                        </span>
                                        Nenhum registro
                                    </div>
                                </td>
                            </tr>
                        @endif
                        @foreach ($additionalGroups as $additionalGroup)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td scope="row" class=" px-1 py-2">
                                    {{ $additionalGroup->nome }}
                                </td>
                                <td scope="row" class=" px-1 py-2">
                                    {{ Str::limit($additionalGroup->descricao, 100) }}
                                </td>
                                <td scope="row" class=" px-1 py-2">
                                    {{ $additionalGroup->adicional_qtd_min == null ? '-' : $additionalGroup->adicional_qtd_min }}
                                </td>
                                <td scope="row" class=" px-1 py-2">
                                    {{ $additionalGroup->adicional_qtd_max == null ? '-' : $additionalGroup->adicional_qtd_max }}
                                </td>
                                <td scope="row" class=" px-1 py-2">
                                    {{ $additionalGroup->adicional_juncao }}
                                </td>
                                <td scope="row" class=" px-1 py-2">
                                    {{ $additionalGroup->ordem }}
                                </td>
                                <td scope="row" class=" px-1 py-2">
                                    {{ $additionalGroup->ordem_interna }}
                                </td>

                                <td class=" px-1 py-2">

                                    <a type="button"
                                        href="{{ route('painel.lojista.grupo-adicional.edit', $additionalGroup->id) }}"
                                        class="btn btn-light border-0 dark:text-gray-200 py-0 px-1 pt-1" title="Editar">
                                        <span class="material-symbols-outlined text-primary">
                                            edit
                                        </span>
                                    </a>

                                    <button class="btn btn-light border-0 dark:text-gray-200 py-0 px-1 pt-1" type="button"
                                        data-modal-toggle="popup-modal-remover" id="remover" title="Remover"
                                        onclick="document.getElementById('form-remover').action = `{{ route('painel.lojista.grupo-adicional.destroy', $additionalGroup->id) }}`">
                                        <span class="material-symbols-outlined text-danger">
                                            delete
                                        </span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div
                class="grid px-1 py-2 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                <span class="col-span-2"></span>
            </div>
        </div>

        <!-- Paginação -->
        {{ $additionalGroups->links() }}

    </div>

    <!-- Modal remover -->
    <div id="popup-modal-remover" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 p-4 md:inset-0 h-modal md:h-full">
        <div class="relative w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                    data-modal-toggle="popup-modal-remover">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>

                <!-- Formulário remover categoria -->
                <form action="" method="post" name="form_remover_cat" id='form-remover'>
                    @csrf
                    @method('DELETE')
                    <div class="p-6 text-center">
                        <span class="material-symbols-outlined display-3 text-gray-500 dark:text-gray-400">
                            info
                        </span>

                        <h3 class="mb-5 h5 font-normal text-gray-500 dark:text-gray-400 mt-3 fw-bold">
                            Tem certeza que deseja remover este registro? Isso também removerá todos os adicionais deste grupo
                        </h3>

                        <button type="submit"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Remover
                        </button>
                        <button data-modal-toggle="popup-modal-remover" type="button"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
