<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\StoreHasUsers;
use App\Models\ShopkeeperToken;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ShopkeeperStoreRequest;
use App\Http\Requests\UpdateStoreDataRequest;

class AdminShopkeeperController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index(Request $request)
    {
        $shopkeepers = User::where('profile', 'lojista')->doesntHave('test_order');
        if ($request->has('v'))
            $shopkeepers->where('name', 'like', '%' . $request->v . '%');

        $shopkeepers = $shopkeepers->latest()->paginate(10);
        return view('painel.admin.lojistas.index', compact('shopkeepers'));
    }

    public function create()
    {
        return view('painel.admin.lojistas.create');
    }

    public function store(ShopkeeperStoreRequest $request)
    {
        $lojista = (new User)->fill($request->all());
        $lojista->profile = 'lojista';
        $lojista->password = Hash::make($request['password']);
        $lojista->save();
        $lojista->assignRole('lojista');

        // Criar token para API
        $token = 'TOKEN-' . Str::random(20) . '-' . Str::random(20) . '-' . Str::random(20);
        if (ShopkeeperToken::where('token', $token)->exists()) {
            $token .= '-' . time();
        }
        ShopkeeperToken::create([
            'token' => $token,
            'lojista_id' => $lojista->id
        ]);

        return redirect()->back()->withSuccess('Lojista cadastrado com sucesso');
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        return view('painel.admin.lojistas.edit', compact('user'));
    }

    /**
     * Atualizar dodos pessoais do lojista
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'celular_com_ddd'],
        ]);
        $user = $user->fill($request->all());
        $user->save();
        return redirect()->back()->withSuccess('Dados pessoais do lojista editado com sucesso');
    }

    public function updateCredentials(Request $request, User $user)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->email = $request['email'];
        $user->password = Hash::make($request['password']);
        $user->save();

        return redirect()->back()->withSuccess('Credenciais atualizadas com sucesso');
    }

    public function activeShopkeeper(User $user)
    {
        $user->status = 'ativo';
        $user->save();
        return redirect()->back()->withSuccess('Lojista ativado com sucesso');
    }

    public function deactivateShopkeeper(User $user)
    {
        $user->status = 'desativado';
        $user->save();
        return redirect()->back()->withSuccess('Lojista desativado com sucesso');
    }

    public function updateStoreData(UpdateStoreDataRequest $request, User $user)
    {
        if ($user->store()->exists()) :

            if ($request->file('logo')) :
                Storage::delete($user->store->logo);
            endif;

            $user->store->fill($request->all());
            $user->store->slug_url = Str::slug($request->slug_url);

            if ($request->file('logo')) :
                $user->store->logo = $request
                    ->file('logo')
                    ->store('loja/logos');
            endif;
            $user->store->save();
        else :
            $store = (new Store)->fill($request->all());
            $store->slug_url = Str::slug($request->slug_url);
            $store->lojista_id = $user->id;
            if ($request->file('logo')) :
                $store->logo = $request
                    ->file('logo')
                    ->store('loja/logos');
            endif;
            $store->save();
        endif;

        // Alocar usuário a loja
        StoreHasUsers::updateOrCreate(
            ['user_id' => $user->id],
            ['store_id' => $user->store->id]
        );

        return redirect()->back()->withSuccess('Dados da loja atualizados com sucesso!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->withSuccess('Lojista removido com sucesso');
    }
}
