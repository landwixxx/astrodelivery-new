<?php

namespace App\Http\Controllers\Shopkeeper;

use Illuminate\Http\Request;
use App\Models\PromotionalBanner;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class StoreImagesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:lojista|funcionario', 'can:atualizar imagens']);
    }

    public function index()
    {
        /* Se não tiver dados de loja */
        if (!isset(auth()->user()->store_has_user->store->id))
            return redirect()
                ->route('painel.lojista.configuracoes')
                ->withErro('Você precisa adicionar os dados da sua loja primeiro.');

        $store = auth()->user()->store_has_user->store;

        $banners = [
            'banner_posicao1' => PromotionalBanner::where('store_id', $store->id)->where('posicao', 1)->first(),
            'banner_posicao2' => PromotionalBanner::where('store_id', $store->id)->where('posicao', 2)->first(),
            'banner_posicao3' => PromotionalBanner::where('store_id', $store->id)->where('posicao', 3)->first(),
        ];

        return view('painel.lojista.imagens_loja', compact('store', 'banners'));
    }

    public function updateImages(Request $request)
    {
        $store = auth()->user()->store_has_user->store;

        if ($request->hasFile('logo')) :
            Storage::delete($store->logo);
            $store->logo = $request->file('logo')->store('loja/logos');
        endif;

        if ($request->hasFile('imagem_bg')) :
            Storage::delete($store->imagem_bg);
            $store->imagem_bg = $request->file('imagem_bg')->store('loja/img-bg');
        endif;

        if ($request->hasFile('banner_promocional')) :
            Storage::delete($store->banner_promocional);
            $store->banner_promocional = $request->file('banner_promocional')->store('loja/banner');
        endif;

        $store->save();

        return redirect()->back()->withSuccess('Imagens atualizadas com sucesso.');
    }
}
