@extends('layouts.painel.app')
@section('title', 'Clientes')
@section('content')
    <br>

    {{-- Alertas --}}
    <x-alerts />

    <!-- Search input -->
    <div class=" px-4 pesquisa gap-3 flex-column flex-lg-row  flex justify-center flex-1 lg:mr-32 ">
        <div class=" order-2 order-lg-1 relative w-full max-w-xl mr-6 focus-within:text-purple-500">
            <div class="div-icon absolute inset-y-0 flex items-center pl-2 ">
                <svg class="w-4 h-4 text-secondary" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <form action="{{ route('painel.lojista.clientes.index') }}">
                <input
                    class="w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                    name="v" value="{{ request()->get('v') }}" type="text" placeholder="Pesquisar cliente"
                    aria-label="Search">
            </form>
        </div>
        <div class="text-end order-1 order-lg-2">
            <a href="{{ route('painel.lojista.clientes.create') }}"><button
                    class="px-4 py-2 border-0 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Adicionar Cliente
                </button></a>
        </div>
    </div>



    <div class="container-fluid px-6 mx-auto grid">
        <br>
        @if (request()->get('v') != '')
            <!-- Resultados pesquisa -->
            <div class="mb-2 text-muted">
                {{ $customers->total() }} resultados
            </div>
        @endif

        <!-- Clientes -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs">

            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-3 py-2">Nome</th>
                            <th class="px-3 py-2">Data registro</th>
                            <th class="px-3 py-2">Telefone</th>
                            <th class="px-3 py-2">WhatsApp</th>
                            <th class="px-3 py-2">Compras</th>
                            <th class="px-3 py-2">Status</th>
                            <th class="px-3 py-2">Ações</th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @if ($customers->total() == 0)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-3 py-3 text-sm text-center py-5" colspan="7">
                                    <div class="d-flex gap-1 align-items-center justify-content-center">
                                        <span class="material-symbols-outlined fs-6 ">
                                            info
                                        </span>
                                        Nenhum registro
                                    </div>
                                </td>
                            </tr>
                        @endif
                        @foreach ($customers as $customer)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-3 py-2">
                                    {{ $customer->name }}
                                </td>
                                <td class="px-3 py-2 ">
                                    {{ $customer->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-3 py-2 ">
                                    {{ $customer->data_customer ? $customer->data_customer->telefone : '' }}
                                </td>
                                <td class="px-3 py-2 ">
                                    @php
                                        $whats = $customer->data_customer ? $customer->data_customer->telefone : '';
                                        $whats = str_replace(['(', ')', ' ', '-'], [''], $whats);
                                    @endphp
                                    <a href="https://wa.me/55{{ $whats }}" class="" target="_blank">
                                        @if ($whats)
                                            wa.me/55{{ $whats }}
                                        @endif
                                    </a>

                                </td>
                                <td class="px-3 py-2 ">
                                    @php
                                        $totalCompras = $customer
                                            ->orders_cutomer()
                                            ->where('store_id', auth()->user()->store_has_user->store_id)
                                            ->where('order_status_id', 7)
                                            ->withTrashed()
                                            ->count();
                                    @endphp
                                    {{ $totalCompras }}
                                </td>
                                <!-- Status -->
                                <td class=" px-3 py-3 ">
                                    @if ($customer->banned_customer)
                                        <span class="badge rounded-pill text-bg-danger">Banido</span>
                                    @else
                                        <span class="badge rounded-pill text-bg-success">Ativo</span>
                                    @endif
                                </td>
                                <!-- Ações -->
                                <td class=" px-3 py-2 ">
                                    <a type="button" href="{{ route('painel.lojista.clientes.show', $customer->id) }}"
                                        class="btn btn-light border-0 dark:text-gray-200 py-0 px-1 pt-1"
                                        title="Visualizar dados">
                                        <span class="material-symbols-outlined text-primary">
                                            visibility
                                        </span>
                                    </a>

                                    @if ($customer->banned_customer)
                                        <a type="button"
                                            href="{{ route('painel.lojista.clientes.desbanir', $customer->id) }}"
                                            class="btn btn-light border-0 dark:text-gray-200 py-0 px-1 pt-1"
                                            title="Desbanir cliente">
                                            <span class="material-symbols-outlined text-success">
                                                how_to_reg
                                            </span>
                                        </a>
                                    @else
                                        <a type="button"
                                            href="{{ route('painel.lojista.clientes.banir', $customer->id) }}"
                                            class="btn btn-light border-0 dark:text-gray-200 py-0 px-1 pt-1"
                                            title="Banir cliente">
                                            <span class="material-symbols-outlined text-danger">
                                                block
                                            </span>
                                        </a>
                                    @endif
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
        {{ $customers->withQueryString()->links() }}
    </div>

    <!-- Modal negar -->
    <div id="popup-modal-negar" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 p-4 md:inset-0 h-modal md:h-full">
        <div class="relative w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                    data-modal-toggle="popup-modal-negar">
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
                        Tem certeza que deseja remover este cliente?
                    </h3>

                    <form action="" method="post" id="form-remover">
                        @csrf
                        @method('DELETE')
                        <button data-modal-toggle="popup-modal-negar" type="submit"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Sim
                        </button>
                        <button data-modal-toggle="popup-modal-negar" type="button"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            Cancelar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal aprovar -->
    <div id="popup-modal-aprovar" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 p-4 md:inset-0 h-modal md:h-full">
        <div class="relative w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                    data-modal-toggle="popup-modal-aprovar">
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
                        check_circle
                    </span>
                    <h3 class="mb-5 mt-3 text-lg font-normal text-gray-500 dark:text-gray-400">
                        Tem certeza que deseja aprovar este pedido?
                    </h3>
                    <button data-modal-toggle="popup-modal-aprovar" type="button"
                        class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                        Sim
                    </button>
                    <button data-modal-toggle="popup-modal-aprovar" type="button"
                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="py-4"></div>

@endsection
