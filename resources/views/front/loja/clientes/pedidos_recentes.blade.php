@extends('layouts.front.loja.app', ['store' => $store])
@section('titulo', 'Pedidos Recentes - ' . $store->nome)
@section('content')
    <section>
        <div class="container py-5 mt-5 mx-auto">

            <!-- Alerte de sucesso -->
            <x-alert-success />

            <h1 class="h3">Pedidos Recentes</h1>

            <!-- Lista de pedidos -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nº</th>
                            <th scope="col">Data</th>
                            <th scope="col">Valor</th>
                            <th scope="col" class='text-truncate'>Valor +taxa</th>
                            <th scope="col">Status</th>

                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="">
                                <td>#{{ $order->codigo }}</td>
                                <td class='text-truncate'>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class='text-truncate'>{{ currency_format($order->total_pedido) }}</td>
                                <td class='text-truncate'>{{ currency_format($order->total_pedido + $order->valor) }}</td>
                                <td>
                                    <span class="badge rounded-pill {{ $order->order_status->classe_css }}">
                                        {{ $order->order_status->nome }}
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('cliente.pedido', ['slug_store' => $store->slug_url, 'order' => $order->id]) }}"
                                            class="btn btn-outline-success btn-sm fw-600 d-flex align-items-center gap-1">
                                            <i class="fa-regular fa-eye fa-sm"></i>
                                            Visualizar
                                        </a>
                                        <a href="{{ route('cliente.repetir-pedido', ['slug_store' => $store->slug_url, $order->id]) }}"
                                            class="btn btn-outline-primary btn-sm fw-600 d-flex align-items-center gap-1">
                                            <i class="fa-solid fa-arrows-rotate fa-sm"></i>
                                            Repetir
                                        </a>
                                        @if ($order->order_status_id == 6 || $order->order_status_id == 7)
                                            <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#modal-remover-item"
                                                class="btn btn-outline-danger btn-sm fw-600 d-flex align-items-center gap-1"
                                                onclick="document.getElementById('link-remover-item').href= '{{ route('cliente.remover-pedido', ['slug_store' => $store->slug_url, $order->id]) }}';">
                                                <i class="fa-regular fa-trash-can fa-sm"></i>
                                                Remover
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            {{ $orders->links() }}

        </div>
    </section>

    <!-- Modal remover item -->
    <div class="modal fade" id="modal-remover-item" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-ssm" role="document">
            <div class="modal-content">
                <div class="d-flex justify-content-end p-2">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center fs-4">
                    Tem certeza em remover o pedido?
                </div>
                <div class="modal-footer justify-content-center pb-5">
                    <a href="#" class="btn btn-danger px-3" id="link-remover-item">Remover</a>
                    <button type="button" class="btn btn-outline-primary px-3" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

@endsection
