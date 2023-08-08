<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthCustomer
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

        if (!Auth::check()) :
            // $slug_store = explode('/', $request->path())[1];

            $host = $request->getHost();
            $partes = explode('.', $host);
            $slug_store = $partes[0];

            // Armazenar a URL anterior
            $previous_url = $request->path();
            Session::put('previous_url', $previous_url);
            
            // Redirecionar o usuário para a tela de login
            return redirect()->route('cliente.login', $slug_store);

        endif;

        return $next($request);
    }
}
