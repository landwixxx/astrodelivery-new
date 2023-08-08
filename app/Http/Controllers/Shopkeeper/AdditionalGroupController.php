<?php

namespace App\Http\Controllers\Shopkeeper;

use Illuminate\Http\Request;
use App\Models\AdditionalGroup;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdditionalGroupStoreRequest;
use App\Http\Requests\AdditionalGroupUpdateRequest;

class AdditionalGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:lojista|funcionario', 'can:visualizar produtos']);
    }

    public function index()
    {
        /* Se não tiver dados de loja */
        if (!isset(auth()->user()->store_has_user->store->id))
            return $this->redirectConfig();

        $store_id = auth()->user()->store_has_user->store->id;
        $additionalGroups = AdditionalGroup::where('store_id', $store_id)->latest()->paginate(12);

        return view('painel.lojista.produtos.grupo_adicional.index', compact('additionalGroups'));
    }

    public function create()
    {
        return view('painel.lojista.produtos.grupo_adicional.create');
    }

    public function store(AdditionalGroupStoreRequest $request)
    {
        $additionalGroup = (new AdditionalGroup)->fill($request->all());
        $additionalGroup->store_id = auth()->user()->store_has_user->store->id;
        if (is_null($request->ordem))
            $additionalGroup->ordem = 1;
        $additionalGroup->save();

        // salver código do item
        if (is_null($additionalGroup->codigo)) :
            if (AdditionalGroup::where('codigo', $additionalGroup->id)->exists() == false) :
                $additionalGroup->codigo = $additionalGroup->id;
                $additionalGroup->save();
            else :
                $total = AdditionalGroup::count();
                for ($i = 0; $i <= 1000000; $i++) :
                    $total++;
                    if (AdditionalGroup::where('codigo', $total)->exists() == false) {
                        $additionalGroup->codigo = $total;
                        $additionalGroup->save();
                        break;
                    }
                endfor;
            endif;
        endif;

        return redirect()->route('painel.lojista.grupo-adicional.index')->withSuccess('Cadastro realizado com sucesso');
    }

    public function edit(AdditionalGroup $additionalGroup)
    {
        $this->authorize('editar produtos');
        $this->checkAccessStore($additionalGroup->store_id);

        return view('painel.lojista.produtos.grupo_adicional.edit', compact('additionalGroup'));
    }


    public function update(AdditionalGroupUpdateRequest $request, AdditionalGroup $additionalGroup)
    {
        $this->authorize('editar produtos');
        $this->checkAccessStore($additionalGroup->store_id);

        $additionalGroup = $additionalGroup->fill($request->all());
        if (is_null($request->ordem))
            $additionalGroup->ordem = 1;
        $additionalGroup->save();

        return redirect()->back()->withSuccess('Registro atualizado com sucesso');
    }

    public function destroy(AdditionalGroup $additionalGroup)
    {
        $this->authorize('excluir produtos');
        $this->checkAccessStore($additionalGroup->store_id);
        $additionalGroup->delete();
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
