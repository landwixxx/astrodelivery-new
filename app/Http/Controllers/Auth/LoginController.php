<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
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
            if ($user->profile == 'admin')
                return redirect()->intended(route('painel.admin.index'));
            if ($user->profile == 'lojista' || $user->profile == 'funcionario')
                return redirect()->intended(route('painel.lojista.index'));
            if ($user->profile == 'cliente') {
                Auth::logout();
                return redirect()->route('login')->withInput()->withErrors(['email' => 'Essas credenciais não foram encontradas em nossos registros.']);
            }
        } else {
            // Authentication failed...
            return back()->withInput()->withErrors(['email' => 'Essas credenciais não foram encontradas em nossos registros.']);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
