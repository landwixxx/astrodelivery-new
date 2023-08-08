<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotifyNewOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:lojista|funcionario', 'can:visualizar pedidos']);
    }

    /**
     * Obter dados de novos pedidos em json
     *
     * @return void
     */
    public function getData()
    {
        if (is_null(auth()->user()->store_has_user))
            return response()->json(['erro' => 'não existe dados da loja cadastrados'], 403);

        $store = auth()->user()->store_has_user->store;
        $totalPedidosNotificacao = $store
            ->orders()
            ->where('order_status_id', 1)
            ->count();

        return response()->json([
            'total' => $totalPedidosNotificacao,
            'total_pedidos_session' => session('total_pedidos_session')
        ]);
    }

    /**
     * Add sessão com o total de novos pedidos
     *
     * @param  mixed $request
     * @return void
     */
    public function addSession(Request $request)
    {
        session()->put('total_pedidos_session', $request->total);
        return response()->json(['success' => true]);
    }
}
