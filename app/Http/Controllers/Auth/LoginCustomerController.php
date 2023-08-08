<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginCustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function loginCustomerForm($slug_store)
    {
        $store = Store::where('slug_url', $slug_store)->first();
        return view('auth.login_customer', compact('store'));
    }

    public function login(Request $request, $slug_store)
    {
        // Validate the user's login credentials
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($validatedData)) {
            // Authentication passed...
            $user = auth()->user();

            return $this->redirectTo($user, $slug_store);
        } else {
            // Authentication failed...
            return back()->withInput()->withErrors(['email' => 'Essas credenciais não foram encontradas em nossos registros.']);
        }
    }

    public function redirectTo($user, $slug_store)
    {
        if ($user->profile == 'admin') :
            return redirect()->intended(route('painel.admin.index'));
        endif;

        if ($user->profile == 'lojista' || $user->profile == 'funcionario') :
            return redirect()->intended(route('painel.lojista.index'));
        endif;

        if ($user->profile == 'cliente') :
            return redirect()->intended(route('loja.index', $slug_store));
        endif;
    }

    /**
     * Verificar se está logados e redireciona para painel
     *
     * @return void
     */
    public function authCheck()
    {
        //
    }

    public function logout($slug_store)
    {
        Auth::logout();
        return redirect()->route('cliente.login', $slug_store);
    }
}
