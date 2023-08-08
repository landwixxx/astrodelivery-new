<?php

namespace App\Http\Controllers\Shopkeeper;

use Illuminate\Http\Request;
use App\Models\PromotionalBanner;
use App\Http\Controllers\Controller;
use App\Http\Requests\PromotionalBannerCreateRequest;
use App\Http\Requests\PromotionalBannerselectBannerRequest;

class PromotionalBannerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:lojista|funcionario', 'can:atualizar imagens']);
    }

    public function selectBanner(Request $request)
    {
        $request->validate([
            'posicao' => ['required', 'in:1,2,3,4']
        ]);

        /* Se não tiver dados de loja */
        if (!isset(auth()->user()->store_has_user->store->id))
            return $this->redirectConfig();

        $store = auth()->user()->store_has_user->store;
        $banners = PromotionalBanner::where('store_id', $store->id)->latest()->get();
        return view('painel.lojista.banners_promocionais.selecionar_banner', compact('banners'));
    }

    public function redirectConfig()
    {
        return redirect()
            ->route('painel.lojista.configuracoes')
            ->withErro('Você precisa adicionar os dados da sua loja primeiro.');
    }

    /**
     * Varifciar se usuário pode modificar banner
     *
     * @return void
     */
    public function checkModUser($banner_store_id)
    {
        if (auth()->user()->store_has_user->store->id != $banner_store_id)
            abort(403);
    }

    /**
     * Cadastrar banner
     *
     * @param  mixed $request
     * @return void
     */
    public function createSave(PromotionalBannerCreateRequest $request)
    {
        $store = auth()->user()->store_has_user->store;
        $banner = (new PromotionalBanner)->fill($request->all());
        $banner->store_id = $store->id;
        $banner->img = 'storage/' . $request->file('img')->store('loja/banner');
        $banner->save();

        return redirect()->back()->withSuccess('Banner cadastrado com sucesso');
    }

    /**
     * Selecionar banner cadastrado
     *
     * @param  mixed $request
     * @return void
     */
    public function selectBannerSave(PromotionalBannerselectBannerRequest $request)
    {
        $store = auth()->user()->store_has_user->store;
        PromotionalBanner::where('store_id', $store->id)->where('posicao', $request->posicao)->update([
            'posicao' => null,
            'status' => 'desativado'
        ]);

        $banner = PromotionalBanner::find($request->banner_id);
        $this->checkModUser($banner->store_id);

        $banner->posicao = $request->posicao;
        $banner->status = 'ativo';
        $banner->save();

        return redirect()->route('painel.lojista.imagens-da-loja')->withSuccess('Banner selecionado com sucesso');
    }

    public function delete(PromotionalBanner $banner)
    {
        $this->checkModUser($banner->store_id);
        $banner->delete();
        return redirect()->back()->withSuccess('Registro removido com sucesso.');
    }

    public function activeBanner(PromotionalBanner $banner)
    {
        $this->checkModUser($banner->store_id);
        $banner->status = 'ativo';
        $banner->save();
        return redirect()->back()->withSuccess('Status do banner ativado com sucesso');
    }

    public function disabledBanner(PromotionalBanner $banner)
    {
        $this->checkModUser($banner->store_id);
        $banner->status = 'desativado';
        $banner->save();
        return redirect()->back()->withSuccess('Status do banner desativado com sucesso');
    }
}
