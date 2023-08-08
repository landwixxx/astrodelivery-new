<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NotifyNewOrder extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if (is_null(auth()->user()->store_has_user))
            return;

        $store = auth()->user()->store_has_user->store;
        $pedidosPendentes = $store
            ->orders()
            ->where('order_status_id', 1);

        $totalPedidosNotificacao = $pedidosPendentes->count();

        $rotaPedido = null;
        if ($totalPedidosNotificacao == 1) :
            $pedidId = $pedidosPendentes->first()->id;
            $rotaPedido = route('painel.lojista.pedidos.show', $pedidId);
        else :
            $rotaPedido = route('painel.lojista.pedidos.index');
        endif;

        return view('components.notify-new-order', compact('totalPedidosNotificacao', 'rotaPedido'));
    }
}
