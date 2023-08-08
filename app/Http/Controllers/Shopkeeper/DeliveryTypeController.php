<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Models\DeliveryType;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Models\DeliveryTypeHasPaymentMethod;
use App\Http\Requests\StoreDeliveryTypeRequest;
use App\Http\Requests\UpdateDeliveryTypeRequest;

class DeliveryTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:lojista|funcionario', 'can:visualizar modelo entrega']);
    }

    public function index()
    {
        /* Se não tiver dados de loja */
        if (!isset(auth()->user()->store_has_user->store->id))
            return $this->redirectConfig();

        $store_id = auth()->user()->store_has_user->store->id;
        $deliveryTypes = DeliveryType::where('store_id', $store_id)->latest()->paginate(12);

        return view('painel.lojista.tipo_entrega.index', compact('deliveryTypes'));
    }

    public function create()
    {
        $this->authorize('adicionar modelo entrega');
        $paymentMethods = PaymentMethod::where('store_id', auth()->user()->store_has_user->store->id)
            ->where('ativo', 'S')
            ->orderBy('nome')
            ->get();

        return view('painel.lojista.tipo_entrega.create', compact('paymentMethods'));
    }

    public function store(StoreDeliveryTypeRequest $request)
    {
        $this->authorize('adicionar modelo entrega');
        $deliveryType = (new DeliveryType)->fill($request->all());
        $deliveryType->store_id = auth()->user()->store_has_user->store->id;
        $deliveryType->save();

        // salver código do item
        if (is_null($deliveryType->codigo)) :
            if (DeliveryType::where('codigo', $deliveryType->id)->exists() == false) :
                $deliveryType->codigo = $deliveryType->id;
                $deliveryType->save();
            else :
                $total = DeliveryType::count();
                for ($i = 0; $i <= 1000000; $i++) :
                    $total++;
                    if (DeliveryType::where('codigo', $total)->exists() == false) {

                        $deliveryType->codigo = $total;
                        $deliveryType->save();
                        break;
                    }
                endfor;
            endif;
        endif;

        // alocar metodos de pagamente a tipo de entrega
        foreach ($request->metodos_pagamento as $method_id) {
            DeliveryTypeHasPaymentMethod::create([
                'delivery_type_id' => $deliveryType->id,
                'payment_method_id' => $method_id,
            ]);
        }

        return  redirect()
            ->route('painel.lojista.tipo-de-entrega.index')
            ->withSuccess('Tipo de entrega cadastrada com sucesso');
    }

    public function edit(DeliveryType $deliveryType)
    {
        $this->authorize('editar modelo entrega');
        $this->checkAccessStore($deliveryType->store_id);

        $paymentMethods = PaymentMethod::where('store_id', auth()->user()->store_has_user->store->id)
            ->where('ativo', 'S')
            ->orderBy('nome')
            ->get();

        return view('painel.lojista.tipo_entrega.edit', compact('deliveryType', 'paymentMethods'));
    }

    public function update(UpdateDeliveryTypeRequest $request, DeliveryType $deliveryType)
    {
        $this->authorize('editar modelo entrega');
        $this->checkAccessStore($deliveryType->store_id);

        $deliveryType = $deliveryType->fill($request->all());
        $deliveryType->save();

        // alocar metodos de pagamente a tipo de entrega
        DeliveryTypeHasPaymentMethod::where('delivery_type_id', $deliveryType->id)->delete();
        foreach ($request->metodos_pagamento as $method_id) {
            DeliveryTypeHasPaymentMethod::create([
                'delivery_type_id' => $deliveryType->id,
                'payment_method_id' => $method_id,
            ]);
        }

        return  redirect()->back()->withSuccess('Tipo de entrega atualizada com sucesso');
    }

    public function destroy(DeliveryType $deliveryType)
    {
        $this->authorize('excluir modelo entrega');
        $this->checkAccessStore($deliveryType->store_id);
        $deliveryType->delete();
        return redirect()->back()->withSuccess('Registro removido com sucesso');
    }

    public function redirectConfig()
    {
        return redirect()
            ->route('painel.lojista.configuracoes')
            ->withErro('Você precisa adicionar os dados da sua loja primeiro.');
    }

    public function checkAccessStore($store_id)
    {
        if (auth()->user()->store_has_user->store->id != $store_id)
            abort(403);
    }
}
