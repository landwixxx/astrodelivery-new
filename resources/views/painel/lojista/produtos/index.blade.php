@extends('layouts.painel.app')
@section('title', 'Produtos')
@section('content')
    <br>

    {{-- Alertas --}}
    <x-alerts />

    <!-- Search input -->
    <div class=" px-4 mb-3 pesquisa gap-3 flex-column flex-lg-row  flex justify-center flex-1 lg:mr-32 ">
        <div class=" order-2 order-lg-1 relative w-full max-w-xl mr-6 focus-within:text-purple-500">
            <div class="div-icon absolute inset-y-0 flex items-center pl-2 ">
                <svg class="w-4 h-4 text-secondary" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <form action="#">
                <input
                    class="w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                    name="v" value="{{ request()->get('v') }}" type="text" placeholder="Pesquisar produto"
                    aria-label="Search">
            </form>
        </div>
        <div class="text-end order-1 order-lg-2">
            <a href="{{ route('painel.lojista.produtos.create') }}"><button
                    class="px-4 py-2 border-0 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Cadastrar Produto
                </button></a>
        </div>
    </div>

    <div class="container-fluid px-6 mx-auto grid">
        <h2 class="my-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Produtos
        </h2>

        @if (request()->get('v'))
            <div class="text-muted dark:text-gray-200 mb-2">
                {{ $products->total() }} resultados
            </div>
        @endif

        <!-- Lista de produtos -->
        <div class="w-full overflow-x-auto">
            <table class="w-full ">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-3 py-2">Nome</th>
                        <th class="px-3 py-2">Categoria</th>
                        <th class="px-3 py-2">Tipo</th>
                        <th class="px-3 py-2">Valor</th>
                        <th class="px-3 py-2">Qtd. Estoque</th>
                        <th class="px-3 py-2">Ativo</th>
                        <th class="px-3 py-2">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @if ($products->total() == 0)
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
                    @foreach ($products as $product)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-3 py-2">
                                <div class="text-truncate">
                                    <div class="mr-1 float-start me-3 mt-1">
                                        <img src='{{ $product->img_destaque }}' alt="" width="50"
                                            style="min-width: 50px">
                                    </div>
                                    <span>{{ $product->nome }}</span>
                                </div>
                            </td>
                            <td class="px-3 py-2 text-sm">{{ $product->category->nome }}</td>
                            <td class="px-3 py-2 text-sm">{{ $product->tipo }}</td>
                            <td class="px-3 py-2 text-sm text-truncate">{{ currency_format($product->valor) }}</td>
                            <td class="px-3 py-2 text-sm">
                                @if ($product->tipo == 'PIZZA')
                                    -
                                @else
                                    {{ $product->estoque ?? '0' }}
                                @endif
                            </td>
                            <td class="px-3 py-2 text-sm">
                                @if ($product->ativo == 'S')
                                    <span class="badge rounded-pill text-bg-success">Sim</span>
                                @else
                                    <span class="badge rounded-pill text-bg-danger">Não</span>
                                @endif
                            </td>
                            <td class=" px-3 py-2 text-sm text-truncate">
                                @if ($product->tipo == 'PIZZA')
                                    <a type="button" href="{{ route('painel.lojista.produtos.pizza.show', $product->id) }}"
                                        class="btn btn-light border-0 dark:text-gray-200 py-0 px-1 pt-1" title="Visualizar">
                                        <span class="material-symbols-outlined text-secondary">
                                            visibility
                                        </span>
                                    </a>
                                @else
                                    <a type="button" href="{{ route('painel.lojista.produtos.show', $product->id) }}"
                                        class="btn btn-light border-0 dark:text-gray-200 py-0 px-1 pt-1" title="Visualizar">
                                        <span class="material-symbols-outlined text-secondary">
                                            visibility
                                        </span>
                                    </a>
                                @endif
                                @if ($product->tipo == 'PIZZA')
                                    <a type="button"
                                        href="{{ route('painel.lojista.produtos.pizza.edit', $product->id) }}"
                                        class="btn btn-light border-0 dark:text-gray-200 py-0 px-1 pt-1" title="Editar">
                                        <span class="material-symbols-outlined text-primary">
                                            edit
                                        </span>
                                    </a>
                                @else
                                    <a type="button" href="{{ route('painel.lojista.produtos.edit', $product->id) }}"
                                        class="btn btn-light border-0 dark:text-gray-200 py-0 px-1 pt-1" title="Editar">
                                        <span class="material-symbols-outlined text-primary">
                                            edit
                                        </span>
                                    </a>
                                @endif
                                @if ($product->ativo == 'S')
                                    <a type="button" href="{{ route('painel.lojista.produtos.desativar', $product->id) }}"
                                        class="btn btn-light border-0 dark:text-gray-200 py-0 px-1 pt-1" title="Desativar">
                                        <span class="material-symbols-outlined text-danger">
                                            unpublished
                                        </span>
                                    </a>
                                @else
                                    <a type="button" href="{{ route('painel.lojista.produtos.ativar', $product->id) }}"
                                        class="btn btn-light border-0 dark:text-gray-200 py-0 px-1 pt-1" title="Ativar">
                                        <span class="material-symbols-outlined text-success">
                                            check_circle
                                        </span>
                                    </a>
                                @endif

                                <button class="btn btn-light border-0 dark:text-gray-200 py-0 px-1 pt-1" type="button"
                                    data-modal-toggle="popup-modal-remover" id="remover" title="Remover"
                                    onclick="document.getElementById('form-remover').action = `{{ route('painel.lojista.produtos.destroy', $product->id) }}`">
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
        <!-- Paginação -->
        <div class="mt-4 mb-5 pb-4">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>
    <!-- Modal negar -->
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
                            Tem certeza que deseja remover esse produto?
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

@section('scripts')
    <script>
        setTimeout(() => {
            document.getElementById("alert-success").style.display = "none";
        }, 3000)
    </script>
@endsection
