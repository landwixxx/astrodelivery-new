<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\StoreApi;
use Illuminate\Http\Request;

class CheckShopkeeperDisabledApi
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
        // verificar conta desativada
        $store = StoreApi::get($request->header('token'));
        if ($store != null) :
            if (isset($store->user_shopkeeper->status) && $store->user_shopkeeper->status == 'desativado') :
                return response()->json(['erro' => 'Conta desativada'], 403);
            endif;
        endif;

        return $next($request);
    }
}
