<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\StoreHasUsers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserShopkeeperUpdateRequest;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:lojista|funcionario', 'can:visualizar usuários']);
    }

    public function index(Request $request)
    {
        /* Se não tiver dados de loja */
        if (!isset(auth()->user()->store_has_user->store->id))
            return redirect()
                ->route('painel.lojista.configuracoes')
                ->withErro('Você precisa adicionar os dados da sua loja primeiro.');

        /* Obter todos os lojistas que esteja associados à loja */
        $users = User::whereIn('profile', ['funcionario', 'lojista'])
            ->whereHas(
                'store_has_user',
                function ($query) {
                    return $query->where('store_id', auth()->user()->store_has_user->store->id);
                }
            );


        if ($request->has('v')) :
            $users->where('name', 'like', '%' . $request->v . '%');
        endif;
        $users = $users->latest()->paginate(10);

        return view('painel.lojista.usuarios.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('adicionar usuários');

        /* Se não tiver dados de loja */
        if (!isset(auth()->user()->store_has_user->store->id))
            return redirect()
                ->route('painel.lojista.configuracoes')
                ->withErro('Você precisa adicionar os dados da sua loja primeiro.');

        return view('painel.lojista.usuarios.create');
    }

    public function store(UserStoreRequest $request)
    {
        $this->authorize('adicionar usuários');
        $usuario = (new User)->fill($request->all());
        $usuario->profile = 'funcionario';
        $usuario->password = Hash::make($request['password']);
        $usuario->save();
        $usuario->assignRole('funcionario');

        $this->verifyPermissions($request, $usuario);

        // Alocar usuário a loja
        StoreHasUsers::updateOrCreate(
            ['user_id' => $usuario->id],
            ['store_id' => auth()->user()->store_has_user->store->id]
        );

        return redirect()->back()->withSuccess('Usuário cadastrado com sucesso');
    }

    public function edit(User $usuario)
    {
        $this->authorize('editar usuários');
        $this->checkUserAccess($usuario);
        $user = $usuario;
        return view('painel.lojista.usuarios.edit', compact('user'));
    }

    public function update(UserShopkeeperUpdateRequest $request, User $usuario)
    {
        $this->authorize('editar usuários');
        $this->checkUserAccess($usuario);

        $usuario->fill($request->all())->save();
        $this->verifyPermissions($request, $usuario);
        return redirect()->back()->withSuccess('Usuário cadastrado com sucesso');
    }

    public function updateCredentials(Request $request, User $usuario)
    {
        $this->authorize('editar usuários');
        $this->checkUserAccess($usuario);

        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $usuario->id],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $usuario->email = $request->email;
        $usuario->password = bcrypt($request->password);
        $usuario->save();

        return redirect()->back()->withSuccess('Credenciais de acesso atualizadas com sucesso!');
    }

    public function destroy(User $usuario)
    {
        $this->authorize('excluir usuários');
        $this->checkUserAccess($usuario);
        $usuario->delete();
        return redirect()->back()->withSuccess('Usuário removido com sucesso.');
    }

    /**
     * Verificar se o usuário que está tentando modificar os dados pertence a mesmo loja, e se user for 'lojista' impede
     *
     * @return void
     */
    public function checkUserAccess($usuario)
    {
        if (auth()->user()->store_has_user->store_id != $usuario->store_has_user->store_id || $usuario->profile == 'lojista')
            abort(403);
    }

    /**
     * verifyPermissions
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\User $usuario
     * @return void
     */
    public function verifyPermissions($request, $usuario)
    {
        $this->setPermissions($request, $usuario, 'pedidos_visualizar', 'visualizar pedidos');
        $this->setPermissions($request, $usuario, 'pedidos_aprovar', 'aprovar pedidos');
        $this->setPermissions($request, $usuario, 'pedidos_negar', 'negar pedidos');
        $this->setPermissions($request, $usuario, 'pedidos_excluir', 'excluir pedidos');

        $this->setPermissions($request, $usuario, 'usuarios_visualizar', 'visualizar usuários');
        $this->setPermissions($request, $usuario, 'usuarios_adicionar', 'adicionar usuários');
        $this->setPermissions($request, $usuario, 'usuarios_excluir', 'excluir usuários');
        $this->setPermissions($request, $usuario, 'usuarios_editar', 'editar usuários');

        $this->setPermissions($request, $usuario, 'clientes_visualizar', 'visualizar clientes');
        $this->setPermissions($request, $usuario, 'clientes_banir_desbanir', 'banir e desbanir');

        $this->setPermissions($request, $usuario, 'atualizar_empresa', 'atualizar empresa');
        $this->setPermissions($request, $usuario, 'atualizar_imagens', 'atualizar imagens');
        $this->setPermissions($request, $usuario, 'horario_atendimento', 'horario atendimento');

        $this->setPermissions($request, $usuario, 'visualizar_categorias', 'visualizar categorias');
        $this->setPermissions($request, $usuario, 'adicionar_categorias', 'adicionar categorias');
        $this->setPermissions($request, $usuario, 'editar_categorias', 'editar categorias');
        $this->setPermissions($request, $usuario, 'excluir_categorias', 'excluir categorias');

        $this->setPermissions($request, $usuario, 'visualizar_produtos', 'visualizar produtos');
        $this->setPermissions($request, $usuario, 'adicionar_produtos', 'adicionar produtos');
        $this->setPermissions($request, $usuario, 'editar_produtos', 'editar produtos');
        $this->setPermissions($request, $usuario, 'excluir_produtos', 'excluir produtos');

        $this->setPermissions($request, $usuario, 'visualizar_modelo_entrega', 'visualizar modelo entrega');
        $this->setPermissions($request, $usuario, 'adicionar_modelo_entrega', 'adicionar modelo entrega');
        $this->setPermissions($request, $usuario, 'editar_modelo_entrega', 'editar modelo entrega');
        $this->setPermissions($request, $usuario, 'excluir_modelo_entrega', 'excluir modelo entrega');
        $this->setPermissions($request, $usuario, 'configuracoes', 'configurações');

        $this->setPermissions($request, $usuario, 'visualizar_forma_pagamento', 'visualizar forma pagamento');
        $this->setPermissions($request, $usuario, 'adicionar_forma_pagamento', 'adicionar forma pagamento');
        $this->setPermissions($request, $usuario, 'editar_forma_pagamento', 'editar forma pagamento');
        $this->setPermissions($request, $usuario, 'excluir_forma_pagamento', 'excluir forma pagamento');

        return true;
    }

    /**
     * Adicionar permissões
     *
     * @param  mixed $request
     * @param  mixed $usuario
     * @param  mixed $atributo_input
     * @param  mixed $permissao
     * @return void
     */
    public function setPermissions($request, $usuario, $atributo_input, $permissao)
    {
        if ($request->has($atributo_input)) :
            $usuario->givePermissionTo($permissao);
        else :
            if ($usuario->can($permissao))
                $usuario->revokePermissionTo($permissao);
        endif;

        return true;
    }
}
