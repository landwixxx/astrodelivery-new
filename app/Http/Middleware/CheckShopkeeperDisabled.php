<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Store;
use Illuminate\Http\Request;

/**
 * Verificar se o lojista dono da loja foi desativado, isso tbm irá desativar a loja
 */
class CheckShopkeeperDisabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $slug_store = $request->route('slug_store');
        if ($slug_store) :
            $store = Store::where('slug_url', $slug_store)->first();
            if ($store) :
                if ($store->user_shopkeeper->status == 'desativado') :
                    return redirect()->route('loja.desativada', $slug_store);
                endif;
            endif;
        endif;

        return $next($request);
    }
}
