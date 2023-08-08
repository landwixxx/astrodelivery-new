<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Models\DeliveryType;
use Illuminate\Http\Request;
use App\Models\DeliveryZipCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryZipCodeStoreRequest;
use App\Http\Requests\DeliveryZipCodeUpdateRequest;

class DeliveryZipCodeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:lojista|funcionario']);
    }

    public function index()
    {
        /* Se não tiver dados de loja */
        if (!isset(auth()->user()->store_has_user->store->id))
            return $this->redirectConfig();

        $store_id = auth()->user()->store_has_user->store->id;
        $deliveryZipCodes = DeliveryZipCode::where('store_id', $store_id)->latest()->paginate(12);

        return view('painel.lojista.ceps_entrega.index', compact('deliveryZipCodes'));
    }

    public function create()
    {
        $dataDeliveryTypes = $this->dataDeliveryTypes();
        return view('painel.lojista.ceps_entrega.create', compact('dataDeliveryTypes'));
    }

    public function dataDeliveryTypes(): array
    {
        $store_id = auth()->user()->store_has_user->store->id;
        $deliveryTypes = DeliveryType::where('store_id', $store_id)->orderBy('nome')->get();
        $dataDeliveryTypes = [];
        foreach ($deliveryTypes as $value) {
            $dataDeliveryTypes[] = ['id' => $value->id, 'text' => $value->nome];
        }

        return $dataDeliveryTypes;
    }

    public function store(DeliveryZipCodeStoreRequest $request)
    {
        $deliveryZipCode = (new DeliveryZipCode)->fill($request->all());
        $deliveryZipCode->store_id = auth()->user()->store_has_user->store->id;
        $deliveryZipCode->cep_ini = str_replace(['-', '.'], [''], $request->cep_ini);
        $deliveryZipCode->cep_fim = str_replace(['-', '.'], [''], $request->cep_fim);
        $deliveryZipCode->save();

        // salvar código do item
        if (is_null($deliveryZipCode->codigo)) :
            if (DeliveryZipCode::where('codigo', $deliveryZipCode->id)->exists() == false) :
                $deliveryZipCode->codigo = $deliveryZipCode->id;
                $deliveryZipCode->save();
            else :
                $total = DeliveryZipCode::count();
                for ($i = 0; $i <= 1000000; $i++) :
                    $total++;
                    if (DeliveryZipCode::where('codigo', $total)->exists() == false) {
                        $deliveryZipCode->codigo = $total;
                        $deliveryZipCode->save();
                        break;
                    }
                endfor;
            endif;
        endif;

        return redirect()->route('painel.lojista.ceps-de-entrega.index')->withSuccess('Dados cadastrados com sucesso');
    }

    public function edit(DeliveryZipCode $deliveryZipCode)
    {
        $this->checkAccessStore($deliveryZipCode->store_id);
        $dataDeliveryTypes = $this->dataDeliveryTypes();
        return view('painel.lojista.ceps_entrega.edit', compact('dataDeliveryTypes', 'deliveryZipCode'));
    }

    public function update(DeliveryZipCodeUpdateRequest $request, DeliveryZipCode $deliveryZipCode)
    {
        $this->checkAccessStore($deliveryZipCode->store_id);

        $deliveryZipCode = $deliveryZipCode->fill($request->all());
        $deliveryZipCode->cep_ini = str_replace(['-', '.'], [''], $request->cep_ini);
        $deliveryZipCode->cep_fim = str_replace(['-', '.'], [''], $request->cep_fim);
        $deliveryZipCode->save();

        return redirect()->back()->withSuccess('Dados atualizados com sucesso');
    }

    public function destroy(DeliveryZipCode $deliveryZipCode)
    {
        $this->checkAccessStore($deliveryZipCode->store_id);
        $deliveryZipCode->delete();
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
