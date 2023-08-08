<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\BannedCustomer;
use App\Models\StoreHasCustomer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:lojista|funcionario', 'can:visualizar clientes']);
    }

    public function index(Request $request)
    {
        /* Se não tiver dados de loja */
        if (!isset(auth()->user()->store_has_user->store->id))
            return redirect()
                ->route('painel.lojista.configuracoes')
                ->withErro('Você precisa adicionar os dados da sua loja antes de adicionar um cliente.');

        /* Obter todos os clientes que esteja associados à loja */
        $customers = User::where('profile', 'cliente')
            ->where('status', 'ativo')
            ->whereHas('store_has_customer', function ($query) {
                return $query->where('store_id', auth()->user()->store_has_user->store->id);
            });


        if ($request->has('v')) :
            $customers->where('name', 'like', '%' . $request->v . '%');
        endif;
        $customers = $customers->latest()->paginate(10);

        return view('painel.lojista.clientes.index', compact('customers'));
    }

    public function create()
    {
        return view('painel.lojista.clientes.create');
    }

    public function store(CustomerRequest $request)
    {
        $this->authorize('visualizar clientes');
        if (!isset(auth()->user()->store_has_user->store->id)) //Se usuário logado tem relaçao com uma loja
            return redirect()
                ->route('painel.lojista.configuracoes')
                ->withErro('Você precisa adicionar os dados da sua loja antes de adicionar um cliente.');

        $userCustomer = (new User)->fill($request->all());
        $userCustomer->profile = 'cliente';
        $userCustomer->password = Hash::make($request['password']);
        $userCustomer->save();
        $userCustomer->assignRole('cliente');

        $customerData = (new Customer)->fill($request->all());
        $customerData->user_id = $userCustomer->id;
        $customerData->telefone = str_replace(['(', ')', '-', ' '], [''], $request->telefone);
        $customerData->save();

        // Associar cliente a loja
        StoreHasCustomer::firstOrCreate([
            'store_id' => auth()->user()->store_has_user->store->id,
            'user_id' => $userCustomer->id
        ]);

        return redirect()->back()->withSuccess('Cliente adicionado com sucesso.');
    }

    public function show(User $cliente)
    {
        $this->authorize('visualizar clientes');

        /* Se usuários lojista e cliente tem relação com loja */
        if (auth()->user()->store_has_user && $cliente->store_has_customer) :

            /* Loja relacionada ao lojista que esta visualizando os dados do cliente */
            $storeShopkeeper = auth()->user()->store_has_user->store();

            /* Se o cliente tem relaçao com a mesma loja do lojista que está visualizando os dados */
            $customersInStore = $storeShopkeeper->whereHas('store_has_customers', function ($query) use ($cliente) {
                return $query->where('user_id', $cliente->id);
            });

            $user = $cliente;

            /* Se lojista e clente tem relação com a mesmo loja, ou seja, se o usuário cliente é cliente da loja */
            if ($customersInStore->exists())
                return view('painel.lojista.clientes.show', compact('user'));

        endif;

        abort(403);
    }

    public function banCustomer(User $customer)
    {
        $this->authorize('banir e desbanir');
        BannedCustomer::create([
            'user_id' => $customer->id,
            'store_id' => auth()->user()->store_has_user->store_id,
        ]);

        return redirect()->back()->withSuccess('Cliente banido com sucesso.');
    }

    public function unbanCustomer(User $customer)
    {
        $this->authorize('banir e desbanir');
        BannedCustomer::where('user_id', $customer->id)
            ->where('store_id', auth()->user()->store_has_user->store_id)
            ->delete();

        return redirect()->back()->withSuccess('Cliente desbanido com sucesso.');
    }
}
