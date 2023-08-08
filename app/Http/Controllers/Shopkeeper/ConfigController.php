<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\StoreHasUsers;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStoreDataRequest;
use App\Models\ShopkeeperToken;

class ConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:lojista|funcionario', 'can:configurações']);
    }

    public function index()
    {
        $apiToken = $this->getApiToken();
        return view('painel.lojista.config', compact('apiToken'));
    }

    public function updateStoreData(UpdateStoreDataRequest $request)
    {

        if (isset(auth()->user()->store_has_user->store->id)) : // Se exist um cadastro de loja
            $this->updateStore($request);
        else : // Fazer registro da loja

            if (auth()->user()->profile != 'lojista')
                return redirect()
                    ->route('painel.lojista.configuracoes')
                    ->withErro('Somente o usuário principal (dono da loja) pode cadastrar os primeiros dados.');

            $this->createStore($request);
        endif;

        $this->allocateUserStore();

        return redirect()->back()->withSuccess('Dados da loja atualizados com sucesso!');
    }

    public function allocateUserStore()
    {
        return StoreHasUsers::updateOrCreate(
            ['user_id' => auth()->user()->id],
            ['store_id' => auth()->user()->store->id]
        );
    }

    public function updateStore($request)
    {
        $store = auth()->user()->store_has_user->store;

        $store->fill($request->all());
        $store->slug_url = Str::slug($request->slug_url);

        return $store->save();
    }

    public function createStore($request)
    {
        $store = (new Store)->fill($request->all());
        $store->slug_url = Str::slug($request->slug_url);
        $store->lojista_id = auth()->user()->id;

        if ($request->file('logo'))
            $store->logo = $request
                ->file('logo')
                ->store('loja/logos');

        return $store->save();
    }

    /**
     * getApiToken
     *
     * @return string api token
     */
    public function getApiToken(): string
    {
        if (auth()->user()->store_has_user != null) :

            $lojista_id = auth()->user()->store_has_user->store->user_shopkeeper->id;
            $shopkeeperToken  = ShopkeeperToken::where('lojista_id', $lojista_id)->first();

            $apiToken = $shopkeeperToken->token;
        else :
            $apiToken = 'ADICIONE-OS-DADOS-DA-LOJA-PARA-TER-ACESSO-AO-TOKEN';
        endif;

        return $apiToken;
    }

    public function toggleStoreOpen(Request $request)
    {
        if (is_null(auth()->user()->store_has_user))
            return $this->redirectConfig();

        $store = auth()->user()->store_has_user->store;
        $store->empresa_aberta = $request->alternar_empresa_aberto;
        $store->save();

        return redirect()->back()->withSuccess('Status da empresa foi alterado com sucesso');
    }

    public function redirectConfig()
    {
        return redirect()
            ->route('painel.lojista.configuracoes')
            ->withErro('Você precisa adicionar os dados da sua loja antes de alterar o status.');
    }
}
