<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Redirecionar para o painel do usuário
     *
     * @return void
     */
    public function redirect()
    {
        $profile = auth()->user()->profile;
        
        if ($profile == 'admin')
            return redirect()->route('painel.admin.index');

        if ($profile == 'lojista' || $profile == 'funcionario')
            return redirect()->route('painel.lojista.index');

        if ($profile == 'cliente') {
            if(auth()->user()->store_has_customer != null){
                $slug= auth()->user()->store_has_customer->store->slug_url;
                return redirect()->route('loja.index', $slug);
            }
            Auth::logout();
            return redirect()->route('login');
        }
    }
}
