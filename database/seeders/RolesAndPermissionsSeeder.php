<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        /* Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete articles']);
        Permission::create(['name' => 'publish articles']);
        Permission::create(['name' => 'unpublish articles']); */

        // create roles and assign created permissions

        // this can be done as separate statements
        /* $role = Role::create(['name' => 'writer']);
        $role->givePermissionTo('edit articles'); */

        // or may be done by chaining
        /* $role = Role::create(['name' => 'moderator'])
            ->givePermissionTo(['publish articles', 'unpublish articles']);

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all()); */

        /* Criar permissões para lojista e funcionários desse lojista */
        // Pedidos
        Permission::create(['name' => 'visualizar pedidos']);
        Permission::create(['name' => 'aprovar pedidos']);
        Permission::create(['name' => 'negar pedidos']);
        Permission::create(['name' => 'excluir pedidos']);

        // Usuários (Funcionários)
        Permission::create(['name' => 'visualizar usuários']);
        Permission::create(['name' => 'adicionar usuários']);
        Permission::create(['name' => 'excluir usuários']);
        Permission::create(['name' => 'editar usuários']);

        // Clientes
        Permission::create(['name' => 'visualizar clientes']);
        Permission::create(['name' => 'banir e desbanir']);

        // Dados da empresa
        Permission::create(['name' => 'atualizar empresa']);

        // Imagens da loja
        Permission::create(['name' => 'atualizar imagens']);

        // Imagens da loja
        Permission::create(['name' => 'horario atendimento']);

        // Categorias
        Permission::create(['name' => 'visualizar categorias']);
        Permission::create(['name' => 'adicionar categorias']);
        Permission::create(['name' => 'editar categorias']);
        Permission::create(['name' => 'excluir categorias']);

        // Produtos
        Permission::create(['name' => 'visualizar produtos']);
        Permission::create(['name' => 'adicionar produtos']);
        Permission::create(['name' => 'editar produtos']);
        Permission::create(['name' => 'excluir produtos']);

        // Modelo de entrega
        Permission::create(['name' => 'visualizar modelo entrega']);
        Permission::create(['name' => 'adicionar modelo entrega']);
        Permission::create(['name' => 'editar modelo entrega']);
        Permission::create(['name' => 'excluir modelo entrega']);

        // Forma de pagamento
        Permission::create(['name' => 'visualizar forma pagamento']);
        Permission::create(['name' => 'adicionar forma pagamento']);
        Permission::create(['name' => 'editar forma pagamento']);
        Permission::create(['name' => 'excluir forma pagamento']);

        // Configurações
        Permission::create(['name' => 'configurações']);

        /* Admin */
        Role::create(['name' => 'admin']);

        /* Adicionar todas as permissões para lojista */
        $lojista = Role::create(['name' => 'lojista']);
        $lojista->givePermissionTo(Permission::all());

        /* Funcionários */
        Role::create(['name' => 'funcionario']);

        /* Cliente */
        Role::create(['name' => 'cliente']);
    }
}
