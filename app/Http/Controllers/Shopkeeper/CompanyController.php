<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCompanyRequest;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:lojista|funcionario', 'can:atualizar empresa']);
    }

    public function index()
    {
        if (!isset(auth()->user()->store_has_user->store->id)) // Se dados da loja exist
            return redirect()
                ->route('painel.lojista.configuracoes')
                ->withErro('Você precisa adicionar os dados da sua loja antes de editar os dados da empresa.');

        /* Usuário lojista dono da loja */
        $user = auth()->user()->store_has_user->store->user_shopkeeper;

        return view('painel.lojista.dados_empresa.index', compact('user'));
    }

    public function updateCompany(UpdateCompanyRequest $request)
    {
        /* Usuário lojista dono da loja */
        $user = auth()->user()->store_has_user->store->user_shopkeeper;

        if ($user->company()->exists()) :
            $user->company->fill($request->all());
            $user->company->cep = str_replace(['-', '.'], [''], $request->cep);
            $user->company->save();
        else :
            $company = (new Company)->fill($request->all());
            $company->user_id = $user->id;
            $company->cep = str_replace(['-', '.'], [''], $request->cep);
            $company->save();

            // salver código do item
            if (is_null($company->codigo)) :
                if (Company::where('codigo', $company->id)->exists() == false) :
                    $company->codigo = $company->id;
                    $company->save();
                else :
                    $total = Company::count();
                    for ($i = 0; $i <= 1000000; $i++) :
                        $total++;
                        if (Company::where('codigo', $total)->exists() == false) {
                            $company->codigo = $total;
                            $company->save();
                            break;
                        }
                    endfor;
                endif;
            endif;

        endif;

        return redirect()->back()->withSuccess('Dados da empresa atualizados com sucesso.');
    }
}
