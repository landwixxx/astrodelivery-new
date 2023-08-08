<?php

namespace App\Http\Controllers\Customer;

use App\Models\Store;
use App\Models\DeliveryType;
use Illuminate\Http\Request;
use App\Models\DeliveryTable;
use App\Models\PaymentMethod;
use App\Models\DeliveryZipCode;
use App\Http\Controllers\Controller;
use App\Models\DeliveryTypeHasPaymentMethod;

class DeliveryFormsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth_customer', 'role:cliente']);
    }

    public function index($slug_store)
    {
        $store = Store::where('slug_url', $slug_store)->first();
        $deliveryTypes = DeliveryType::where('store_id', $store->id)->where('ativo', 'S')->orderBy('nome')->get();
        $paymentMethods = PaymentMethod::where('store_id', $store->id)->where('ativo', 'S')->orderBy('nome')->get();

        if ($store->empresa_aberta == 'nao') :
            return redirect()->back()->with('abrir_modal_loja_fechada', true);
        endif;

        $items_cart = session('items_cart') ?? [];
        $qtd_itens = count($items_cart);
        $soma_pedido = array_column($items_cart, 'vl_item');
        $soma_pedido = array_sum($soma_pedido);
        $data = [
            'qtd_itens' => $qtd_itens,
            'soma_pedido' => $soma_pedido
        ];

        //total do pedido
        $items_cart = session('items_cart') ?? [];
        $soma_pedido = 0;
        if (count($items_cart) > 0) :
            $soma_pedido = array_column($items_cart, 'vl_item');
            $soma_pedido = array_sum($soma_pedido);
        endif;

        // total de montar pizza
        if (count(session('items_cart_pizza') ?? []) > 0) :
            // dd(session('items_cart_pizza'));
            $valoresMontaPizzaArr = array_column(session('items_cart_pizza'), 'valor_total');
            $valoresMontaPizza = array_sum($valoresMontaPizzaArr);
            $soma_pedido += $valoresMontaPizza;

            $data['soma_pedido'] += $valoresMontaPizza;
            $data['qtd_itens'] += count(session('items_cart_pizza'));
        endif;

        // total de pizza produto
        if (count(session('items_cart_pizza_produto') ?? []) > 0) :
            $valoresMontaPizzaArr = array_column(session('items_cart_pizza_produto'), 'valor_total');
            $valoresMontaPizza = array_sum($valoresMontaPizzaArr);
            $soma_pedido += $valoresMontaPizza;
            $data['soma_pedido'] += $valoresMontaPizza;
            $data['qtd_itens'] += count(session('items_cart_pizza_produto'));
        endif;

        $valor_total_pedido = $soma_pedido;

        return view('front.loja.realizar_pedido.forma_entrega_e_pagamento', compact('store', 'deliveryTypes', 'paymentMethods', 'data', 'valor_total_pedido'));
    }

    public function jsonPaymentMethods($slug_store, Request $request)
    {
        $store = Store::where('slug_url', $slug_store)->first();

        $str_filter = "%" . implode('%', explode(' ', $request->q)) . "%";

        $data = [];
        $data = DeliveryTypeHasPaymentMethod::where('delivery_type_id', $request->tipo_entrega_id)
            ->whereHas('payment_method', function ($query) use ($str_filter) {
                $query->where('ativo', 'S')->where('nome', 'like', $str_filter)->orderBy('nome');
            })
            ->with('payment_method')
            ->limit(30)
            ->get();

        return response()->json($data);
    }

    public function jsonDeliveryTables($slug_store, Request $request)
    {
        $store = Store::where('slug_url', $slug_store)->first();

        $data = [];
        if ($request->has('q')) :
            $str_filter = "%" . implode('%', explode(' ', $request->q)) . "%";
            $data = DeliveryTable::where('store_id', $store->id)
                ->where('tipo_entrega_id', $request->tipo_entrega_id)
                ->where('mesa', 'like', $str_filter)
                ->where('status', 'ativo')
                ->limit(30)
                ->orderBy('mesa')
                ->get();
        else :
            $data = DeliveryTable::where('store_id', $store->id)
                ->where('tipo_entrega_id', $request->tipo_entrega_id)
                ->where('status', 'ativo')
                ->orderBy('mesa')->get();
        endif;

        return response()->json($data);
    }

    public function searchCep($slug_store, Request $request)
    {
        $store = Store::where('slug_url', $slug_store)->first();

        if ($request->has('cep') && $request->cep != null) :
            $dadosCep = DeliveryZipCode::where('status', 'ativo')
                ->where('store_id', $store->id)
                ->where('cep_fim', $request->cep)
                ->first();
            return response()->json([
                'dados' => $dadosCep
            ]);
        endif;

        return response()->json(['error' => 'CEP não informado'], 404);
    }
}
