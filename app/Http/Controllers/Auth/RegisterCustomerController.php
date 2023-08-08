<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Store;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CustomerRequest;
use App\Models\StoreHasCustomer;
use App\Models\StoreHasUsers;

class RegisterCustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showFormRegister($slug_store)
    {
        $store = Store::where('slug_url', $slug_store)->first();
        return view('auth.register_customer', compact('store'));
    }

    public function register(CustomerRequest $request, $slug_store)
    {
        $userCustomer = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'profile' => 'cliente',
            'password' => Hash::make($request['password']),
        ]);
        $userCustomer->assignRole('cliente');

        $customerData = (new Customer)->fill($request->all());
        $customerData->user_id = $userCustomer->id;
        $customerData->telefone = str_replace(['(', ')', '-', ' '], [''], $request->telefone);
        $customerData->save();

        $store = Store::where('slug_url', $slug_store)->first();
        StoreHasCustomer::create([
            'store_id' => $store->id,
            'user_id' => $userCustomer->id
        ]);

        Auth::login($userCustomer);

        return redirect()->route('cliente.meus-dados', $slug_store)->withSuccess('Cadastro realizado com sucesso!');
    }
}
