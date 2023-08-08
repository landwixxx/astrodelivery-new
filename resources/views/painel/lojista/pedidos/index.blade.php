@extends('layouts.painel.app')
@section('title', 'Pedidos')
@section('content')
    <br>

    {{-- Alertas --}}
    <x-alerts />

    <!-- Search -->
    <form action="{{ route('painel.lojista.pedidos.index') }}" method="get">
        <div class="pesquisa flex justify-center flex-1 lg:mr-32">
            <div class="relative w-full max-w-xl mr-6 focus-within:text-purple-500 mx-auto" style="width: 85%">
                <div class="div-icon absolute inset-y-0 flex items-center pl-2" style="">
                    <svg class="w-4 h-4 text-secondary" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <!-- input search -->
                <input
                    class="w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                    type="text" placeholder="Pesquise por um pedido, cliente, valor, status, etc..." aria-label="Search"
                    name="v" value="{{ request()->get('v') }}">
            </div>
        </div>
    </form>


    <!-- Pedidos -->
    <div class="container-fluid px-6 mx-auto grid">
        @if (request()->get('v'))
            <div class="text-muted">
                {{ $orders->total() }} resultados
            </div>
        @endif

        <br>
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto ">
                <table class="w-full whitespace-no-wrap table table-hover">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-3 py-3">Nº</th>
                            <th class="px-3 py-3">Tempo</th>
                            <th class="px-3 py-3">Cliente</th>
                            <th class="px-3 py-3">Valor</th>
                            <th class="px-3 py-3">Valor +taxa</th>
                            {{-- <th class="px-3 py-3">Pagamento</th>
                            <th class="px-3 py-3">Entrega</th> --}}
                            <th class="px-3 py-3">Status</th>
                            <th class="px-3 py-3">Ações</th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @if ($orders->total() == 0)
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
                        @foreach ($orders as $item)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-3 py-2 text-sm ">
                                    #{{ $item->codigo }}
                                </td>
                                <td class="px-3 py-2 text-sm">
                                    @php
                                        $from = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                                        $dateNow = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at->format('Y-m-d H:i:s'));
                                        $diff_in_date = $dateNow->longRelativeDiffForHumans($from, 4);
                                        
                                        // não exibir segundos
                                        if ($dateNow->diffInSeconds($from, 4) >= 70) {
                                            $positionSeg = strpos($diff_in_date, 'segundos');
                                            $diff_in_date = substr($diff_in_date, 0, $positionSeg - 4);
                                        }
                                        if ($dateNow->diffInDays($from, 4) >= 1) {
                                            $diff_in_date = $dateNow->diffInDays($from, 4) . ' dias';
                                        }
                                        $diff_in_date = str_replace([' hora ', ' horas ', ' minutos', ' minuto', ' antes', ' segundos'], ['h ', 'h', 'min', 'min', '', 'seg'], $diff_in_date);
                                    @endphp
                                    há {{ $diff_in_date }}
                                </td>
                                <td class="px-3 py-2">
                                    {{ is_null($item->user_id) ? '(Cliente removido)' : $item->customer->name }}
                                </td>
                                <td class="px-3 py-2 text-sm">
                                    {{ currency_format($item->total_pedido) }}
                                </td>
                                <td class="px-3 py-2 text-sm">
                                    {{ currency_format($item->total_pedido + $item->valor) }}
                                </td>
                                {{-- <td class="px-3 py-2 text-sm">
                                    {{ $item->payment->nome }}
                                </td>
                                <td class=" px-3 py-2 text-sm">
                                    {{ $item->delivery->nome }}
                                </td> --}}
                                <td class=" px-3 py-2 text-sm">
                                    <span class="badge rounded-pill {{ $item->order_status->classe_css }}">
                                        {{ $item->order_status->nome }}
                                    </span>
                                </td>
                                <td class=" px-3 py-2 text-sm">
                                    <a type="button" href="{{ route('painel.lojista.pedidos.show', $item->id) }}"
                                        class="btn btn-light border-0 dark:text-gray-200 py-0 px-1 pt-1"
                                        title="Visualizar Pedido">
                                        <span class="material-symbols-outlined text-primary">
                                            visibility
                                        </span>
                                    </a>
                                    <button class="btn btn-light border-0 dark:text-gray-200 py-0 px-1 pt-1" type="button"
                                        data-modal-toggle="popup-modal-remover" title="Remover"
                                        onclick="document.getElementById('form-remover-pedido').action= `{{ route('painel.lojista.pedidos.destroy', $item->id) }}`;">
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
                class="grid px-3 py-2 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                <span class="col-span-2"></span>
            </div>
        </div>

        <!-- Paginação -->
        <div class="mt-4"></div>
        {{ $orders->withQueryString()->links() }}

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

                    <h3 class=" mb-5 text-lg font-normal text-gray-500 dark:text-gray-400 mt-3">
                        Tem certeza que deseja remover este pedido?
                    </h3>
                    <form action="#" method="post" id="form-remover-pedido">
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
