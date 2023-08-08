@extends('layouts.painel.app')
@section('title', 'Contatos')
@section('content')
    <br>

    {{-- Alertas --}}
    <x-alerts />


    <div class="container-fluid px-6 mx-auto grid">
        <br>

        <!-- Pedidos -->

        <div class="mb-4 d-flex justify-content-lg-between flex-column flex-lg-row">
            <h1 class="h4 fw-bold text-gray-600 dark:text-gray-200 mb-2">Contatos</h1>

            <form action="{{ route('painel.admin.marcar-todas-lidas') }}" method="post">
                @csrf
                @method('PUT')
                <button type="submit"
                    class="px-3 py-1 border-0 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue d-flex align-items-center gap-1">
                    <span class="material-symbols-outlined fs-16px">
                        checklist
                    </span>
                    Marcar todas como lidas
                </button>
            </form>
        </div>


        <div class="w-full overflow-hidden rounded-lg shadow-xs">

            <div class="w-full overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800 ">
                            <th class="px-3 py-2">Nome</th>
                            <th class="px-3 py-2">Meio de contato</th>
                            <th class="px-3 py-2">Mensagem</th>
                            <th class="px-3 py-2 text-truncate">Data de envio</th>
                            <th class="px-3 py-2"> Ações </th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 "
                        style="vertical-align: top !important">
                        @if ($contacts->total() == 0)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-3 py-3 text-sm text-center py-5" colspan="5">
                                    <div class="d-flex gap-1 align-items-center justify-content-center">
                                        <span class="material-symbols-outlined fs-6 ">
                                            info
                                        </span>
                                        Nenhum registro
                                    </div>
                                </td>
                            </tr>
                        @endif
                        @foreach ($contacts as $contact)
                            <tr
                                class="text-gray-700 dark:text-gray-400 @if ($contact->status == 'pendente') bg-yellow-100 @endif ">
                                <td class="px-3 py-3 text-truncate">
                                    {{ $contact->nome }}
                                </td>
                                <td class="px-3 py-3 text-sm text-truncate">
                                    {{ $contact->meio_contato }}
                                </td>
                                <td class="px-3 py-3 text-sm" style="min-width: 250px">
                                    {{ $contact->msg }}
                                </td>
                                <td class="px-3 py-3 text-sm text-truncate">
                                    {{ $contact->created_at->format('d/m/Y') }}
                                </td>
                                <td class=" px-3 py-2 text-sm text-truncate">

                                    <form action="{{ route('painel.admin.contato.marcar-lido', $contact->id) }}"
                                        method="post">
                                        @csrf
                                        @method('PUT')
                                        @if ($contact->status == 'pendente')
                                            <button class="btn btn-light border-0 dark:text-gray-200 py-0 px-1 pt-1"
                                                type="submit" title="Marcar como lido">
                                                <span class="material-symbols-outlined text-success">
                                                    mark_chat_read
                                                </span>
                                            </button>
                                        @endif
                                        <button class="btn btn-light border-0 dark:text-gray-200 py-0 px-1 pt-1"
                                            type="button" data-modal-toggle="popup-modal-remover" title="Remover"
                                            onclick="setRouteDelete(`{{ route('painel.admin.contatos.destroy', $contact->id) }}`)">
                                            <span class="material-symbols-outlined text-gray-700 dark:text-gray-400">
                                                delete
                                            </span>
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div
                class="grid px-3 py-2 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                <span class="col-span-2"></span>
            </div>



        </div>

        <div class="mt-4"></div>
        <!-- Paginação -->
        {{ $contacts->links() }}
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
                <div class="p-6 text-center">
                    <span class="material-symbols-outlined display-3 text-gray-500 dark:text-gray-400"">
                        info
                    </span>

                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400 mt-3">
                        Tem certeza que deseja remover essa mensagem de contato?
                    </h3>
                    <form action="" method="post" id="form-remover">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Sim
                        </button>
                        <button data-modal-toggle="popup-modal-remover" type="button"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            Cancelar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="py-4"></div>

@endsection

@section('scripts')
    <script>
        function setRouteDelete(route) {
            document.querySelector('#form-remover').action = route;
        }
    </script>
@endsection
