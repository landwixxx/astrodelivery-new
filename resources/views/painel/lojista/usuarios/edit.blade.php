@extends('layouts.painel.app')
@section('title', 'Editar Usuário')
@section('content')
    <br>

    {{-- Alertas --}}
    <x-alerts />

    <div class="container-fluid px-6 mx-auto grid">
        <br>

        <!-- Editar Usuário -->
        <div class="w-full overflow-hidden rounded-lg ">
            <h1 class="h4 fw-bold text-gray-600 dark:text-gray-200 mb-4">Editar Usuário</h1>

            <div class="card border dark:border-none bg-white">
                <div class="card-body">
                    <!-- Formulário -->
                    <form action="{{ route('painel.lojista.usuarios.update', $user->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row dark:text-gray-200">
                            <div class="col-12">
                                <h2 class="h5 fw-700"> Dados Pessoais</h2>
                            </div>
                            <!-- Nome -->
                            <div class="col-12 col-lg-4 col-xl-4 mb-3">
                                <label for="name" class="form-label fw-500">
                                    Nome<span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="@error('name') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input "
                                    name="name" id="name" value="{{ old('name', $user->name) }}" requiredxx>
                                @error('name')
                                    <div class="invalid-feedback fw-bold">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Telefone -->
                            <div class="col-12 col-lg-4 col-xl-4 mb-3">
                                <label for="phone" class="form-label fw-500">
                                    Telefone<span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control @error('phone') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                    name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                                    placeholder="(00) 00000-0000" requiredxx>
                                @error('phone')
                                    <div class="invalid-feedback fw-bold">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- ========== Início Permissões ========== -->
                            <div class="col-12 dark:text-gray-200">
                                <h2 class="h5 fw-700 pt-2">Permissões</h2>

                                <!-- Pedidos -->
                                <div class="table-responsive">
                                    <table class="table table-stripedd table-bordered dark:border-none">
                                        <thead class="bg-gray-200 dark:bg-gray-700">
                                            <tr class="">
                                                <th scope="col" colspan="4" class="dark:text-gray-400">Pedidos</th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            <tr class="">
                                                <td class="">
                                                    <!-- Visualizar -->
                                                    <div class="flex items-center">
                                                        <input id="pedidos_visualizar" type="checkbox"
                                                            name="pedidos_visualizar"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            @if (old('pedidos_visualizar', $user->can('visualizar pedidos'))) checked @endif>
                                                        <label for="pedidos_visualizar"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Visualizar
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="">
                                                    <!-- Aprovar -->
                                                    <div class="flex items-center">
                                                        <input id="pedidos_aprovar" type="checkbox" name="pedidos_aprovar"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            @if (old('pedidos_aprovar', $user->can('aprovar pedidos'))) checked @endif>
                                                        <label for="pedidos_aprovar"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Aprovar
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <!-- Negar -->
                                                    <div class="flex items-center">
                                                        <input id="pedidos_negar" type="checkbox" name="pedidos_negar"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            @if (old('pedidos_negar', $user->can('negar pedidos'))) checked @endif>
                                                        <label for="pedidos_negar"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Negar
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <!-- Excluir -->
                                                    <div class="flex items-center">
                                                        <input id="pedidos_excluir" type="checkbox" name="pedidos_excluir"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            @if (old('pedidos_excluir', $user->can('excluir pedidos'))) checked @endif>
                                                        <label for="pedidos_excluir"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Excluir
                                                        </label>
                                                    </div>
                                                </td>

                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <!-- Usuários -->
                                <div class="table-responsive">
                                    <table class="table table-stripedd table-bordered dark:border-none">
                                        <thead class="bg-gray-200 dark:bg-gray-700">
                                            <tr class="">
                                                <th scope="col" colspan="4" class="dark:text-gray-400">Usuários</th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            <tr class="">
                                                <td class="">
                                                    <!-- Visualizar -->
                                                    <div class="flex items-center">
                                                        <input id="usuarios_visualizar" type="checkbox"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            name="usuarios_visualizar"
                                                            @if (old('usuarios_visualizar', $user->can('visualizar usuários'))) checked @endif>
                                                        <label for="usuarios_visualizar"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Visualizar
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="">
                                                    <!-- Adicionar -->
                                                    <div class="flex items-center">
                                                        <input id="usuarios_adicionar" type="checkbox"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            name="usuarios_adicionar"
                                                            @if (old('usuarios_adicionar', $user->can('adicionar usuários'))) checked @endif>
                                                        <label for="usuarios_adicionar"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Adicionar
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <!-- Excluir -->
                                                    <div class="flex items-center">
                                                        <input id="usuarios_excluir" type="checkbox"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            name="usuarios_excluir"
                                                            @if (old('usuarios_excluir', $user->can('excluir usuários'))) checked @endif>
                                                        <label for="usuarios_excluir"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Excluir
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <!-- Editar -->
                                                    <div class="flex items-center">
                                                        <input id="usuarios_editar" type="checkbox"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            name="usuarios_editar"
                                                            @if (old('usuarios_editar', $user->can('editar usuários'))) checked @endif>
                                                        <label for="usuarios_editar"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Editar
                                                        </label>
                                                    </div>
                                                </td>

                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <!-- Clientes -->
                                <div class="table-responsive">
                                    <table class="table table-stripedd table-bordered dark:border-none">
                                        <thead class="bg-gray-200 dark:bg-gray-700">
                                            <tr class="">
                                                <th scope="col" colspan="4" class="dark:text-gray-400">Clientes
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            <tr class="">
                                                <td class="">
                                                    <!-- Visualizar -->
                                                    <div class="flex items-center">
                                                        <input id="clientes_visualizar" type="checkbox"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            name="clientes_visualizar"
                                                            @if (old('clientes_visualizar', $user->can('visualizar clientes'))) checked @endif>
                                                        <label for="clientes_visualizar"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Visualizar
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="">
                                                    <!-- Adicionar -->
                                                    <div class="flex items-center">
                                                        <input id="clientes_banir_desbanir" type="checkbox"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            name="clientes_banir_desbanir"
                                                            @if (old('clientes_banir_desbanir', $user->can('banir e desbanir'))) checked @endif>
                                                        <label for="clientes_banir_desbanir"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Banir/Desbanir
                                                        </label>
                                                    </div>
                                                </td>

                                                <td> </td>
                                                <td> </td>


                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <!-- Dados da empresa -->
                                <div class="table-responsive">
                                    <table class="table table-stripedd table-bordered dark:border-none ">
                                        <thead class="bg-gray-200 dark:bg-gray-700">
                                            <tr class="">
                                                <th scope="col" colspan="3" class="dark:text-gray-400">Dados da
                                                    empresa
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            <tr class="">
                                                <td>
                                                    <!-- Atualizar -->
                                                    <div class="flex items-center">
                                                        <input id="atualizar_empresa" type="checkbox"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            name="atualizar_empresa"
                                                            @if (old('atualizar_empresa', $user->can('atualizar empresa'))) checked @endif>
                                                        <label for="atualizar_empresa"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Atualizar
                                                        </label>
                                                    </div>
                                                </td>

                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <!-- Imagens da loja -->
                                <div class="table-responsive">
                                    <table class="table table-stripedd table-bordered dark:border-none">
                                        <thead class="bg-gray-200 dark:bg-gray-700">
                                            <tr class="">
                                                <th scope="col" colspan="3" class="dark:text-gray-400">Imagens da
                                                    loja
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            <tr class="">
                                                <td>
                                                    <!-- Atualizar -->
                                                    <div class="flex items-center">
                                                        <input id="atualizar_imagens" type="checkbox"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            name="atualizar_imagens"
                                                            @if (old('atualizar_imagens', $user->can('atualizar imagens'))) checked @endif>
                                                        <label for="atualizar_imagens"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Atualizar
                                                        </label>
                                                    </div>
                                                </td>

                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <!-- Horário de atendimento -->
                                <div class="table-responsive">
                                    <table class="table table-stripedd table-bordered dark:border-none">
                                        <thead class="bg-gray-200 dark:bg-gray-700">
                                            <tr class="">
                                                <th scope="col" colspan="3" class="dark:text-gray-400">Horário de
                                                    atendimento
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            <tr class="">
                                                <td>
                                                    <!-- Atualizar -->
                                                    <div class="flex items-center">
                                                        <input id="horario_atendimento" type="checkbox"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            name="horario_atendimento"
                                                            @if (old('horario_atendimento', $user->can('horario atendimento'))) checked @endif>
                                                        <label for="horario_atendimento"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Atualizar
                                                        </label>
                                                    </div>
                                                </td>

                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <!-- Categorias -->
                                <div class="table-responsive">
                                    <table class="table table-stripedd table-bordered dark:border-none">
                                        <thead class="bg-gray-200 dark:bg-gray-700">
                                            <tr class="">
                                                <th scope="col" colspan="4" class="dark:text-gray-400">Categorias
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            <tr class="">
                                                <td>
                                                    <!-- Visualizar -->
                                                    <div class="flex items-center">
                                                        <input id="visualizar_categorias" type="checkbox"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            name="visualizar_categorias"
                                                            @if (old('visualizar_categorias', $user->can('visualizar categorias'))) checked @endif>
                                                        <label for="visualizar_categorias"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Visualizar
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <!-- Adicionar -->
                                                    <div class="flex items-center">
                                                        <input id="adicionar_categorias" type="checkbox"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            name="adicionar_categorias"
                                                            @if (old('adicionar_categorias', $user->can('adicionar categorias'))) checked @endif>
                                                        <label for="adicionar_categorias"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Adicionar
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <!-- Editar -->
                                                    <div class="flex items-center">
                                                        <input id="editar_categorias" type="checkbox"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            name="editar_categorias"
                                                            @if (old('editar_categorias', $user->can('editar categorias'))) checked @endif>
                                                        <label for="editar_categorias"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Editar
                                                        </label>
                                                    </div>
                                                </td>

                                                <td>
                                                    <!-- Excluir -->
                                                    <div class="flex items-center">
                                                        <input id="excluir_categorias" type="checkbox"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            name="excluir_categorias"
                                                            @if (old('excluir_categorias', $user->can('excluir categorias'))) checked @endif>
                                                        <label for="excluir_categorias"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Excluir
                                                        </label>
                                                    </div>
                                                </td>

                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <!-- Produtos -->
                                <div class="table-responsive">
                                    <table class="table table-stripedd table-bordered dark:border-none">
                                        <thead class="bg-gray-200 dark:bg-gray-700">
                                            <tr class="">
                                                <th scope="col" colspan="4" class="dark:text-gray-400">Produtos
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            <tr class="">
                                                <td>
                                                    <!-- Visualizar -->
                                                    <div class="flex items-center">
                                                        <input id="visualizar_produtos" type="checkbox"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            name="visualizar_produtos"
                                                            @if (old('visualizar_produtos', $user->can('visualizar produtos'))) checked @endif>
                                                        <label for="visualizar_produtos"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Visualizar
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <!-- Adicionar -->
                                                    <div class="flex items-center">
                                                        <input id="adicionar_produtos" type="checkbox"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            name="adicionar_produtos"
                                                            @if (old('adicionar_produtos', $user->can('adicionar produtos'))) checked @endif>
                                                        <label for="adicionar_produtos"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Adicionar
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <!-- Editar -->
                                                    <div class="flex items-center">
                                                        <input id="editar_produtos" type="checkbox"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            name="editar_produtos"
                                                            @if (old('editar_produtos', $user->can('editar produtos'))) checked @endif>
                                                        <label for="editar_produtos"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Editar
                                                        </label>
                                                    </div>
                                                </td>

                                                <td>
                                                    <!-- Excluir -->
                                                    <div class="flex items-center">
                                                        <input id="excluir_produtos" type="checkbox"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            name="excluir_produtos"
                                                            @if (old('excluir_produtos', $user->can('excluir produtos'))) checked @endif>
                                                        <label for="excluir_produtos"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Excluir
                                                        </label>
                                                    </div>
                                                </td>

                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <!-- Tipo de entrega -->
                                <div class="table-responsive">
                                    <table class="table table-stripedd table-bordered dark:border-none">
                                        <thead class="bg-gray-200 dark:bg-gray-700">
                                            <tr class="">
                                                <th scope="col" colspan="4" class="dark:text-gray-400">Tipo de
                                                    entrega
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            <tr class="">
                                                <td>
                                                    <!-- Visualizar -->
                                                    <div class="flex items-center">
                                                        <input id="visualizar_modelo_entrega" type="checkbox"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            name="visualizar_modelo_entrega"
                                                            @if (old('visualizar_modelo_entrega', $user->can('visualizar modelo entrega'))) checked @endif>
                                                        <label for="visualizar_modelo_entrega"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Visualizar
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <!-- Adicionar -->
                                                    <div class="flex items-center">
                                                        <input id="adicionar_modelo_entrega" type="checkbox"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            name="adicionar_modelo_entrega"
                                                            @if (old('adicionar_modelo_entrega', $user->can('adicionar modelo entrega'))) checked @endif>
                                                        <label for="adicionar_modelo_entrega"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Adicionar
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <!-- Editar -->
                                                    <div class="flex items-center">
                                                        <input id="editar_modelo_entrega" type="checkbox"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            name="editar_modelo_entrega"
                                                            @if (old('editar_modelo_entrega', $user->can('editar modelo entrega'))) checked @endif>
                                                        <label for="editar_modelo_entrega"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Editar
                                                        </label>
                                                    </div>
                                                </td>

                                                <td>
                                                    <!-- Excluir -->
                                                    <div class="flex items-center">
                                                        <input id="excluir_modelo_entrega" type="checkbox"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            name="excluir_modelo_entrega"
                                                            @if (old('excluir_modelo_entrega', $user->can('excluir modelo entrega'))) checked @endif>
                                                        <label for="excluir_modelo_entrega"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Excluir
                                                        </label>
                                                    </div>
                                                </td>



                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <!-- Forma de pagamento -->
                                <div class="table-responsive">
                                    <table class="table table-stripedd table-bordered dark:border-none">
                                        <thead class="bg-gray-200 dark:bg-gray-700">
                                            <tr class="">
                                                <th scope="col" colspan="4" class="dark:text-gray-400">
                                                    Forma de pagamento
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            <tr class="">
                                                <td>
                                                    <!-- Visualizar -->
                                                    <div class="flex items-center">
                                                        <input id="visualizar_forma_pagamento" type="checkbox"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            name="visualizar_forma_pagamento"
                                                            @if (old('visualizar_forma_pagamento', $user->can('visualizar forma pagamento'))) checked @endif>
                                                        <label for="visualizar_forma_pagamento"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Visualizar
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <!-- Adicionar -->
                                                    <div class="flex items-center">
                                                        <input id="adicionar_forma_pagamento" type="checkbox"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            name="adicionar_forma_pagamento"
                                                            @if (old('adicionar_forma_pagamento', $user->can('adicionar forma pagamento'))) checked @endif>
                                                        <label for="adicionar_forma_pagamento"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Adicionar
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <!-- Editar -->
                                                    <div class="flex items-center">
                                                        <input id="editar_forma_pagamento" type="checkbox"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            name="editar_forma_pagamento"
                                                            @if (old('editar_forma_pagamento', $user->can('editar forma pagamento'))) checked @endif>
                                                        <label for="editar_forma_pagamento"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Editar
                                                        </label>
                                                    </div>
                                                </td>

                                                <td>
                                                    <!-- Excluir -->
                                                    <div class="flex items-center">
                                                        <input id="excluir_forma_pagamento" type="checkbox"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            name="excluir_forma_pagamento"
                                                            @if (old('excluir_forma_pagamento', $user->can('excluir forma pagamento'))) checked @endif>
                                                        <label for="excluir_forma_pagamento"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Excluir
                                                        </label>
                                                    </div>
                                                </td>



                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                                <!-- Configurações -->
                                <div class="table-responsive">
                                    <table class="table table-stripedd table-bordered dark:border-none">
                                        <thead class="bg-gray-200 dark:bg-gray-700">
                                            <tr class="">
                                                <th scope="col" colspan="3" class="dark:text-gray-400">
                                                    Configurações
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            <tr class="">
                                                <td>
                                                    <!-- Atualizar -->
                                                    <div class="flex items-center">
                                                        <input id="configuracoes" type="checkbox"
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                            name="configuracoes"
                                                            @if (old('configuracoes', $user->can('configurações'))) checked @endif>
                                                        <label for="configuracoes"
                                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                            Atualizar
                                                        </label>
                                                    </div>
                                                </td>

                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <!-- ========== Fim Permissões ========== -->

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary bg-primary px-4 mt-3 ">
                                    <div class="d-flex align-items-center gap-2">
                                        Atualizar
                                    </div>
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>


        </div>

        <!-- Credenciais de acesso -->
        <div class="w-full overflow-hidden rounded-lg mt-5">

            <div class="card border dark:border-none bg-white">
                <div class="card-body">
                    <!-- Formulário -->
                    <form action="{{ route('painel.lojista.usuarios.up-credenciais', $user->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row dark:text-gray-200">
                            <!-- Credenciaris de acesso -->
                            <div class="col-12">
                                <h2 class="h5 fw-700 pt-2">Credenciais de acesso</h2>
                            </div>

                            <!-- Email -->
                            <div class="col-12 col-lg-4 col-xl-4 mb-3 ">
                                <label for="email" class="form-label">
                                    E-mail
                                </label>
                                <input type="email"
                                    class="form-control @error('email') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                    name="email" id="email" value="{{ old('email', $user->email) }}" requiredxx>
                                @error('email')
                                    <div class="invalid-feedback fw-bold">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Nova senha -->
                            <div class="col-12 col-lg-4 col-xl-4 mb-3">
                                <label for="password" class="form-label">Senha</label>

                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                    name="password" requiredxx>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Repetir senha -->
                            <div class="col-12 col-lg-4 col-xl-4 mb-3">
                                <label for="password-confirm" class="form-label">Confirmar senha</label>
                                <div class="">
                                    <input id="password-confirm" type="password"
                                        class="form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="password_confirmation" requiredxx>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-warning bg-warning">
                                    Atualizar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <div class="py-4"></div>

@endsection



@section('scripts')
    <!-- Mascaras de input -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/imask/6.4.3/imask.min.js"></script>
    <script>
        var phone = IMask(document.getElementById('phone'), {
            mask: '(00) 00000-0000'
        });
    </script>

@endsection
