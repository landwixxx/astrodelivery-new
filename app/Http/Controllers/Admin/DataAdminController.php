<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCredentialsRequest;

class DataAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        return view('painel.admin.meus_dados');
    }

    public function updatePersonalData(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'phone' => ['required', 'celular_com_ddd']
        ]);

        $user = User::find(auth()->user()->id);
        $user->fill($request->all());
        $user->save();

        return redirect()->back()->withSuccess('Dados atualizados com sucesso!');
    }

    public function updateCredentials(UpdateCredentialsRequest $request)
    {
        $user = User::find(auth()->user()->id);
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->withSuccess('Credenciais de acesso atualizadas com sucesso!');
    }
}
