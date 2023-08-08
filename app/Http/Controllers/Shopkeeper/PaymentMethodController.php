<?php

namespace App\Http\Controllers\Shopkeeper;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentMethodRequest;
use App\Http\Requests\UpdatePaymentMethodRequest;

class PaymentMethodController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:lojista|funcionario', 'can:visualizar forma pagamento']);
    }

    public function index()
    {
        /* Se não tiver dados de loja */
        if (!isset(auth()->user()->store_has_user->store->id))
            return $this->redirectConfig();

        $store_id = auth()->user()->store_has_user->store->id;
        $paymentMethods = PaymentMethod::where('store_id', $store_id)->latest()->paginate(12);

        return view('painel.lojista.forma_pagamento.index', compact('paymentMethods'));
    }

    public function create()
    {
        $this->authorize('adicionar forma pagamento');
        return view('painel.lojista.forma_pagamento.create');
    }

    public function store(StorePaymentMethodRequest $request)
    {
        $this->authorize('adicionar forma pagamento');
        $paymentMethod = (new PaymentMethod)->fill($request->all());
        $paymentMethod->store_id = auth()->user()->store_has_user->store->id;
        $paymentMethod->save();

        // salver código do item
        if (is_null($paymentMethod->codigo)) :
            if (PaymentMethod::where('codigo', $paymentMethod->id)->exists() == false) :
                $paymentMethod->codigo = $paymentMethod->id;
                $paymentMethod->save();
            else :
                $total = PaymentMethod::count();
                for ($i = 0; $i <= 1000000; $i++) :
                    $total++;
                    if (PaymentMethod::where('codigo', $total)->exists() == false) {
                        $paymentMethod->codigo = $total;
                        $paymentMethod->save();
                        break;
                    }
                endfor;
            endif;
        endif;

        return  redirect()
            ->route('painel.lojista.forma-de-pagamento.index')
            ->withSuccess('Forma de pagamento cadastrada com sucesso');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        $this->authorize('editar forma pagamento');
        $this->checkAccessStore($paymentMethod->store_id);
        return view('painel.lojista.forma_pagamento.edit', compact('paymentMethod'));
    }

    public function update(UpdatePaymentMethodRequest $request, PaymentMethod $paymentMethod)
    {
        $this->authorize('editar forma pagamento');
        $this->checkAccessStore($paymentMethod->store_id);
        $paymentMethod = $paymentMethod->fill($request->all());
        $paymentMethod->save();

        return  redirect()->back()->withSuccess('Forma de pagamento editada com sucesso');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        $this->authorize('excluir forma pagamento');
        $this->checkAccessStore($paymentMethod->store_id);
        $paymentMethod->delete();
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
