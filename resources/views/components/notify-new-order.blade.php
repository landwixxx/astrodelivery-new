<div class="notificacao-pedido">

    <div id="toast-interactive"
        class="w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:bg-gray-800 dark:text-gray-400 
        @if ($totalPedidosNotificacao == 0 || $totalPedidosNotificacao == session('total_pedidos_session')) transition-opacity duration-300 ease-out opacity-0 hidden @endif"
        role="alert">
        <div class="flex">
            <!-- Total pedidos -->
            <div id="total-pedidos-not"
                class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-orange-500 bg-orange-100 rounded-lg dark:text-orange-300 dark:bg-orange-900 small fw-bold">
                {{ $totalPedidosNotificacao }}
            </div>
            <div class="ml-3 text-sm font-normal me-4">
                <span class="mb-1 text-sm font-semibold text-gray-900 dark:text-white" id="text-novo-pedido">
                    @if ($totalPedidosNotificacao == 1)
                        Novo Pedido
                    @else
                        Novos Pedidos
                    @endif
                </span>
                <div class="grid grid-cols-2 gap-2 mt-2">
                    <div>
                        <a href="{{ $rotaPedido }}"
                            class="inline-flex justify-center w-full py-1 px-1 text-xs font-medium text-center text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                            Ver
                        </a>
                    </div>
                </div>
            </div>
            <button type="button"
                class="n-close ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                data-dismiss-target="#toast-interactive" aria-label="Close" onclick="fecharNotificacao()">
                <span class="sr-only">Close</span>
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    </div>

</div>

<!-- cdn axios -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.2/axios.min.js"></script>
<script>
    function verificarPedidos() {
        axios
            .get("{{ route('painel.lojista.dados-novo-pedido') }}")
            .then(function(response) {
                let total = response.data.total
                let total_pedidos_session = response.data.total_pedidos_session

                // add valores
                if (document.getElementById('total-pedidos-not'))
                    document.getElementById('total-pedidos-not').innerText = total
                if (document.getElementById('total-pedidos-sidebar')) {
                    document.getElementById('total-pedidos-sidebar').innerText = total
                } else { // add total na sidebar
                    // link-sedebar-pedidos
                    if (total > 0) {
                        document.getElementById('link-sedebar-pedidos').innerHTML += `
                            <span id="total-pedidos-sidebar"
                                class="ms-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-600 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-600">
                                ${total}
                            </span> `
                    }
                }

                // alterar texto
                if (total == 1) {
                    document.getElementById('text-novo-pedido').innerText = 'Novo Pedido';
                } else {
                    document.getElementById('text-novo-pedido').innerText = 'Novos Pedidos';
                }

                // ocultar notificação se for maior q 0 e se for difernte do valor da session
                if (total > 0 && total != total_pedidos_session) {
                    document.getElementById('toast-interactive').className =
                        'w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:bg-gray-800 dark:text-gray-400'
                } else {
                    document.getElementById('toast-interactive').className =
                        'w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:bg-gray-800 dark:text-gray-400 transition-opacity duration-300 ease-out opacity-0 hidden '
                }
            })
            .catch(function(error) {
                console.log(error);
            });
    }

    setInterval(() => {
        verificarPedidos()
    }, 10000);


    function fecharNotificacao() {
        let total = document.getElementById('total-pedidos-not').innerText;

        // requisição
        axios
            .get("{{ route('painel.lojista.add-sessao-total-pedidos') }}?total=" + total)
            .then(function(response) {
                let total = response.data
            })
    }
</script>
