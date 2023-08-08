<?php

namespace App\Http\Controllers\Api;

use App\Models\Store;
use App\Models\Company;
use App\Traits\StoreApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CompanyApiController extends Controller
{
    /**
     * store
     *
     * @var object|null
     */
    public $store;

    public function __construct(Request $request)
    {
        $this->store = StoreApi::get($request->header('token'));
    }

    public function retornarEmpresa(Request $request)
    {
        /* Usuário lojista dono da loja */
        $companyShopkeeper = $this->store->user_shopkeeper->company;

        $obj = new \stdClass;
        $obj->codigo = isset($companyShopkeeper->codigo) ? "{$companyShopkeeper->codigo}" : null;
        $cnpj = isset($companyShopkeeper->cnpj) ? $companyShopkeeper->cnpj : null;
        $obj->cnpj = str_replace(['/', '.', '-'], [''], $cnpj);
        $obj->razao = isset($companyShopkeeper->razao_social) ? $companyShopkeeper->razao_social : null;
        $obj->fantasia = isset($companyShopkeeper->fantasia) ? $companyShopkeeper->fantasia : null;
        $obj->endereco = isset($companyShopkeeper->endereco) ? $companyShopkeeper->endereco : null;
        $obj->numero = isset($companyShopkeeper->numero_end) ? $companyShopkeeper->numero_end : null;
        $obj->complemento = isset($companyShopkeeper->complemento) ? $companyShopkeeper->complemento : null;
        $obj->referencia = isset($companyShopkeeper->ponto_referencia) ? $companyShopkeeper->ponto_referencia : null;
        $cep = isset($companyShopkeeper->cep) ? $companyShopkeeper->cep : null;
        $obj->cep =  str_replace(['/', '.', '-'], [''], $cep);
        $obj->cidade = isset($companyShopkeeper->cidade) ? $companyShopkeeper->cidade : null;
        $obj->uf = isset($companyShopkeeper->uf) ? $companyShopkeeper->uf : null;
        $obj->bairro = isset($companyShopkeeper->bairro) ? $companyShopkeeper->bairro : null;
        $obj->email = isset($companyShopkeeper->email) ? $companyShopkeeper->email : null;
        $obj->fone = isset($companyShopkeeper->telefone) ? $companyShopkeeper->telefone : null;
        $obj->whatsapp = isset($companyShopkeeper->whatsapp) ? $companyShopkeeper->whatsapp : null;
        $obj->contato = isset($companyShopkeeper->nome_contato) ? $companyShopkeeper->nome_contato : null;
        $obj->contato_fone = isset($companyShopkeeper->telefone_contato) ? $companyShopkeeper->telefone_contato : null;
        $obj->param = null;
        $obj->usu_alt = "1";
        $obj->dta_alteracao = isset($companyShopkeeper->updated_at) ? $companyShopkeeper->updated_at->format('Y-m-d H:i:s') : null;
        $obj->ativo = isset($companyShopkeeper->ativo) ? $companyShopkeeper->ativo : null;
        $obj->cor = isset($companyShopkeeper->cor) ? $companyShopkeeper->cor : null;

        $aberto = isset($this->store->empresa_aberta) ? $this->store->empresa_aberta : null;
        if ($aberto != null)
            $aberto = $aberto == 'sim' ? 'S' : 'N';
        $obj->aberto = $aberto;

        return response()->json(['sucesso' => $obj]);
    }

    public function gravar(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validacoesGravar());
        if ($validator->fails()) {
            return response()->json(['erro' => $validator->errors()], 422);
        }

        $company = $this->store->user_shopkeeper->company;
        if (is_null($company)) : // cadastrar dados da empresa se não tiver
            $obj = new Company;
            $obj->codigo = $request->codigo;
            $obj->cnpj = $request->cnpj;
            $obj->fantasia = $request->fantasia;
            $obj->razao_social = $request->razao;
            $obj->telefone = $request->n_fone;
            $obj->whatsapp = $request->n_whatsapp;
            $obj->email = $request->email;
            $obj->nome_contato = $request->contato;
            $obj->telefone_contato = $request->n_contato_fone;
            $obj->ponto_referencia = $request->referencia;
            $obj->cep =  $request->n_cep;
            $obj->endereco = $request->endereco;
            $obj->numero_end = $request->numero;
            $obj->complemento = $request->complemento;
            $obj->uf = $request->uf;
            $obj->cidade = $request->cidade;
            $obj->bairro = $request->bairro;
            $obj->cor = $request->cor;
            $obj->ativo = $request->ativo;
            $obj->user_id = $this->store->lojista_id;
            $obj->save();

            Store::find($this->store->id)->update([
                'empresa_aberta' => $request->aberto == 'S' ? 'sim' : 'nao',
            ]);

            return response()->json(['sucesso' => $obj->codigo]);

        else :

            if ($this->store->lojista_id != $company->user_id)
                return response()->json(['erro' => 'Você não tem autorização para editar os dados desse empresa']);

            $obj = Company::find($company->id);
            $obj->codigo = $request->codigo;
            $obj->cnpj = $request->cnpj;
            $obj->fantasia = $request->fantasia;
            $obj->razao_social = $request->razao;
            $obj->telefone = $request->n_fone;
            $obj->whatsapp = $request->n_whatsapp;
            $obj->email = $request->email;
            $obj->nome_contato = $request->contato;
            $obj->telefone_contato = $request->n_contato_fone;
            $obj->ponto_referencia = $request->referencia;
            $obj->cep =  $request->n_cep;
            $obj->endereco = $request->endereco;
            $obj->numero_end = $request->numero;
            $obj->complemento = $request->complemento;
            $obj->uf = $request->uf;
            $obj->cidade = $request->cidade;
            $obj->bairro = $request->bairro;
            $obj->cor = $request->cor;
            $obj->ativo = $request->ativo;
            $obj->save();

            Store::find($this->store->id)->update([
                'empresa_aberta' => $request->aberto == 'S' ? 'sim' : 'nao',
            ]);

            return response()->json(['sucesso' => $obj->codigo]);

        endif;
    }

    public function validacoesGravar(): array
    {
        $company_id = 0;
        if ($this->store->user_shopkeeper->company)
            $company_id = $this->store->user_shopkeeper->company->id;

        return [
            'codigo' => ['required', 'unique:companies,codigo,' . $company_id, 'max:255'],
            'cnpj' => ['required', 'max:255'],
            'fantasia' => ['required', 'max:255'],
            'razao' => ['required', 'max:255'],
            'n_fone' => ['required', 'max:255'],
            'n_whatsapp' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'contato' => ['required', 'max:255'],
            'n_contato_fone' => ['required', 'max:255'],
            'referencia' => ['required', 'max:255'],
            'n_cep' => ['required', 'max:255'],
            'endereco' => ['required', 'max:255'],
            'numero' => ['required', 'max:255'],
            'complemento' => ['required', 'max:255'],
            'uf' => ['required', 'max:255'],
            'cidade' => ['required', 'max:255'],
            'bairro' => ['required', 'max:255'],
            'cor' => ['required', 'max:255'],
            'ativo' => ['required', 'in:S,N', 'max:255'],
            'aberto' => ['required', 'in:S,N', 'max:255'],
        ];
    }
}
