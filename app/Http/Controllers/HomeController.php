<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index($slug_store = null)
    {
        if ($this->checkAdmin() === false)
            return redirect()->route('auth.register.admin');

        $stores = Store::limit(12)->get();

        return view('front.pagina_inicial', compact('stores'));
    }

    /**
     * Verifica se existe super admin
     *
     * @return bool
     */
    public function checkAdmin(): bool
    {
        if (User::where('profile', 'admin')->exists())
            return true;

        return false;
    }
}
