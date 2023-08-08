<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterAdminController extends Controller
{
    /**
     * Formulário para cadastro 
     *
     * @return void
     */
    public function index()
    {
        $this->checkAdmin();
        return view('auth.register_admin');
    }

    /**
     * Armazenar dados do cadastro
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $admin = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'profile' => 'admin',
            'password' => Hash::make($request['password']),
        ])->assignRole('admin');

        Auth::login($admin);
        return redirect()->route('painel.admin.index');

    }

    /**
     * Autorizar acesso a view apenas se não existir super admin
     *
     * @return void
     */
    public function checkAdmin()
    {
        if (User::where('profile', 'admin')->exists())
            abort(403);
    }
}
