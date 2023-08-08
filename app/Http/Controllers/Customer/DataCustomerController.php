<?php

namespace App\Http\Controllers\Customer;

use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerUpdateRequest;
use App\Http\Requests\UpdateCredentialsRequest;

class DataCustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth_customer', 'role:cliente', 'verify-shopkeeper-disabled']);
    }

    public function index($slug_store)
    {
        $store = Store::where('slug_url', $slug_store)->first();
        return view('front.loja.clientes.meus_dados', compact('store'));
    }

    public function updatePersonalData(CustomerUpdateRequest $request, $slug_store)
    {
        $user = User::find(auth()->user()->id);
        /* Atualizar nome */
        $user->name = $request->name;
        $user->save();
        /* Dado Cliente */
        $user->data_customer->fill($request->all());
        $user->data_customer->telefone = str_replace(['(', ')', '-', ' '], [''], $request->telefone);
        $user->data_customer->save();

        return redirect()->back()->withSuccess('Dados atualizados com sucesso!');
    }

    public function updateCredentials(UpdateCredentialsRequest $request, $slug_store)
    {
        $user = User::find(auth()->user()->id);
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->withSuccess('Credenciais de acesso atualizadas com sucesso!');
    }
}
