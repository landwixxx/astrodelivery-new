<?php

namespace App\Http\Controllers\Api;

use App\Traits\StoreApi;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PaymentMethodApiController extends Controller
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

    public function consultar(Request $request)
    {
        $paymentMethods = PaymentMethod::where('store_id', $this->store->id);
        $strSearch = str_replace(' ', '%', " {$request->termo} ");

        // pesquisa nome
        if ($request->has('termo') && $request->termo != null)
            $paymentMethods->where('nome', 'like', $strSearch);

        // pesquisa código
        if ($request->has('n_codigo') && $request->n_codigo != null)
            $paymentMethods->where('codigo', $request->n_codigo);

        // pesquisa ativo
        if ($request->has('ativo') && $request->ativo != null)
            $paymentMethods->where('ativo', $request->ativo);

        return response()->json([
            'sucesso' => $paymentMethods->get([
                'codigo', 'nome', 'descricao', 'icone', 'classe', 'param', 'usu_alt', 'tipo', 'ativo', 'updated_at'
            ])
        ]);
    }

    public function gravar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'n_codigo' => ['nullable', 'unique:payment_methods,codigo', 'max:255'],
            'ativo' => ['required', 'in:S,N', 'max:255'],
            'classe' => ['required', 'max:255'],
            'icone' => ['required', 'max:255'],
            'tipo' => ['required', 'max:255'],
            'nome' => ['required', 'max:255'],
        ], [], [
            'n_codigo' => 'código'
        ]);
        if ($validator->fails()) {
            return response()->json(['erro' => $validator->errors()], 422);
        }

        $paymentMethod = new PaymentMethod;
        if ($request->n_codigo != null)
            $paymentMethod->codigo = $request->n_codigo;
        $paymentMethod->nome = $request->nome;
        $paymentMethod->descricao = $request->descricao;
        $paymentMethod->icone = $request->icone;
        $paymentMethod->classe = $request->classe;
        $paymentMethod->param = $request->param;
        $paymentMethod->tipo = $request->tipo;
        $paymentMethod->ativo = $request->ativo;
        $paymentMethod->store_id = $this->store->id;
        $paymentMethod->usu_alt = null;
        $paymentMethod->save();

        // salver código do item
        if (is_null($paymentMethod->codigo)) :
            if (PaymentMethod::where('codigo', $paymentMethod->id)->exists() == false) :
                $paymentMethod->codigo = $paymentMethod->id;
                $paymentMethod->save();
            else :
                $total = PaymentMethod::count();
                for ($i = 0; $i <= 1000000; $i++) :
                    $total++;
                    if (PaymentMethod::where('codigo', $total)->exists() == false) {
                        $paymentMethod->codigo = $total;
                        $paymentMethod->save();
                        break;
                    }
                endfor;
            endif;
        endif;

        return response()->json(['sucesso' => "{$paymentMethod->codigo}"]);
    }
}
