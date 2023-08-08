<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Models\DeliveryType;
use Illuminate\Http\Request;
use App\Models\DeliveryTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryTableStoreRequest;
use App\Http\Requests\DeliveryTableUpdateRequest;

class DeliveryTableController extends Controller
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
        $deliveryTables = DeliveryTable::where('store_id', $store_id)->latest()->paginate(12);

        return view('painel.lojista.entrega_mesa.index', compact('deliveryTables'));
    }

    public function create()
    {
        $dataDeliveryTypes = $this->dataDeliveryTypes();
        return view('painel.lojista.entrega_mesa.create', compact('dataDeliveryTypes'));
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

    public function store(DeliveryTableStoreRequest $request)
    {
        $deliveryTable = (new DeliveryTable)->fill($request->all());
        $deliveryTable->store_id = auth()->user()->store_has_user->store->id;
        $deliveryTable->save();

        // salver código do item
        if (is_null($deliveryTable->codigo)) :
            if (DeliveryTable::where('codigo', $deliveryTable->id)->exists() == false) :
                $deliveryTable->codigo = $deliveryTable->id;
                $deliveryTable->save();
            else :
                $total = DeliveryTable::count();
                for ($i = 0; $i <= 1000000; $i++) :
                    $total++;
                    if (DeliveryTable::where('codigo', $total)->exists() == false) {
                        $deliveryTable->codigo = $total;
                        $deliveryTable->save();
                        break;
                    }
                endfor;
            endif;
        endif;

        return redirect()->route('painel.lojista.entrega-mesa.index')->withSuccess('Dados cadastrados com sucesso');
    }

    public function edit(DeliveryTable $deliveryTable)
    {
        $this->checkAccessStore($deliveryTable->store_id);
        $dataDeliveryTypes = $this->dataDeliveryTypes();
        return view('painel.lojista.entrega_mesa.edit', compact('dataDeliveryTypes', 'deliveryTable'));
    }

    public function update(DeliveryTableUpdateRequest $request, DeliveryTable $deliveryTable)
    {
        $this->checkAccessStore($deliveryTable->store_id);
        $deliveryTable = $deliveryTable->fill($request->all());
        $deliveryTable->save();

        return redirect()->back()->withSuccess('Dados atualizados com sucesso');
    }

    public function destroy(DeliveryTable $deliveryTable)
    {
        $this->checkAccessStore($deliveryTable->store_id);
        $deliveryTable->delete();
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
