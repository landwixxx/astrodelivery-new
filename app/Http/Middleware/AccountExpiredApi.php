<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\StoreApi;
use Illuminate\Http\Request;

class AccountExpiredApi
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

        // verificar conta expirada
        $store = StoreApi::get($request->header('token'));
        if ($store != null) :
            if (isset($store->user_shopkeeper->account_expiration) && strtotime($store->user_shopkeeper->account_expiration) < time()) :
                return response()->json(['erro' => 'Conta expirada'], 403);
            endif;
        endif;

        return $next($request);
    }
}
