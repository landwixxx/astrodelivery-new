<?php

namespace App\Http\Controllers\Api;

use App\Traits\StoreApi;
use App\Models\DeliveryType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DeliveryTable;
use Illuminate\Support\Facades\Validator;
use App\Models\DeliveryTypeHasPaymentMethod;
use App\Models\DeliveryZipCode;
use App\Models\PaymentMethod;

class DeliveryTypeApiController extends Controller
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
        $deliveryTypes = DeliveryType::where('store_id', $this->store->id);
        $strSearch = str_replace(' ', '%', " {$request->termo} ");

        // pesquisa nome
        if ($request->has('termo') && $request->termo != null)
            $deliveryTypes->where('nome', 'like', $strSearch);

        // pesquisa código
        if ($request->has('n_codigo') && $request->n_codigo != null)
            $deliveryTypes->where('codigo', $request->n_codigo);

        // pesquisa ativo
        if ($request->has('ativo') && $request->ativo != null)
            $deliveryTypes->where('ativo', $request->ativo);

        $dataDeliveryTypes = [];
        foreach ($deliveryTypes->get() as $deliveryType) {

            $dataDeliveryTypes[] = [
                'codigo' => $deliveryType->codigo,
                'nome' => $deliveryType->nome,
                'descricao' => $deliveryType->descricao,
                'icone' => $deliveryType->icone,
                'classe' => $deliveryType->classe,
                'param' => $deliveryType->param ?? '',
                'valor' => $deliveryType->valor,
                'valor_minimo' => $deliveryType->valor_minimo,
                'tipo' => $deliveryType->tipo,
                'bloqueia_sem_cep' => $deliveryType->bloqueia_sem_cep,
                'usu_alt' => '',
                'dta_alteracao' => $deliveryType->updated_at->format('Y-m-d H:i:s'),
                'ativo' => $deliveryType->ativo,
                'tempo' => $deliveryType->tempo,
            ];
        }

        return response()->json([
            'sucesso' => $dataDeliveryTypes
        ]);
    }

    public function gravar(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'n_codigo' => ['nullable', 'unique:delivery_types,codigo', 'max:255'],
            'ativo' => ['required', 'in:S,N', 'max:255'],
            'classe' => ['required', 'max:255'],
            'icone' => ['required', 'max:255'],
            'tipo' => ['required', 'max:255'],
            'nome' => ['required', 'max:255'],
            'param' => ['nullable', 'max:255'],
            "descricao" =>  ['nullable', 'max:1000'],
            "valor" => ['required', 'numeric', 'min:0.00', 'max:999999999'],
            "valor_minimo" => ['required', 'numeric', 'min:0.00', 'max:999999999'],
            "tempo" => ['nullable', 'regex:/^[0-9][0-9]:[0-5][0-9]:[0-5][0-9]$/'],
            "bloqueia_sem_cep" => ['required:S,N'],
        ], [], [
            'n_codigo' => 'código',
            'descricao' => 'descrição',
        ]);
        if ($validator->fails()) {
            return response()->json(['erro' => $validator->errors()], 422);
        }

        $paymentMethod = (new DeliveryType())->fill($request->all());
        $paymentMethod->codigo = $request->n_codigo;
        $paymentMethod->param = $request->param;
        $paymentMethod->store_id = $this->store->id;
        $paymentMethod->save();

        // salver código do item
        if (is_null($paymentMethod->codigo)) :
            if (DeliveryType::where('codigo', $paymentMethod->id)->exists() == false) :
                $paymentMethod->codigo = $paymentMethod->id;
                $paymentMethod->save();
            else :
                $total = DeliveryType::count();
                for ($i = 0; $i <= 1000000; $i++) :
                    $total++;
                    if (DeliveryType::where('codigo', $total)->exists() == false) {
                        $paymentMethod->codigo = $total;
                        $paymentMethod->save();
                        break;
                    }
                endfor;
            endif;
        endif;

        return response()->json(['sucesso' => "{$paymentMethod->codigo}"]);
    }

    public function consultarEntregaPagamento(Request $request)
    {
        if (is_null($request->n_tipo_entrega_codigo))
            return response()->json(['erro' => 'O código da entrega é obrigatório'], 403);

        $deliveryTypes = DeliveryType::where('store_id', $this->store->id);

        // filtrar código
        $deliveryType = $deliveryTypes->where('codigo', $request->n_tipo_entrega_codigo)->first();

        $data = [];
        if ($deliveryType != null) :
            foreach ($deliveryType->delivery_type_has_payment_methods as $key => $item) :
                if ($item->payment_method->ativo == 'N')
                    continue;
                $data[] = [
                    'nome' => $item->payment_method->nome,
                    'tipo' => $item->payment_method->tipo,
                    'forma_pgto_codigo' => $item->payment_method->codigo,
                    'tipo_entrega_codigo' => $deliveryType->codigo,
                    'icone' => $item->payment_method->icone,
                    'classe' => $item->payment_method->classe,
                ];
            endforeach;

            return response()->json(['sucesso' => $data]);

        else :
            return response()->json(['erro' => 'O código informado não foi encontrado'], 404);
        endif;
    }

    public function gravarEntregaPagamento(Request $request)
    {
        $deliveryType = DeliveryType::where('store_id', $this->store->id)
            ->where('codigo', $request->n_tipo_entrega_codigo)->first();

        $paymentMethod = PaymentMethod::where('store_id', $this->store->id)
            ->where('codigo', $request->n_forma_pgto_codigo)->first();

        if (is_null($deliveryType))
            return response()->json(['erro' => 'O código do tipo de entrega não foi encontrado'], 404);
        if (is_null($paymentMethod))
            return response()->json(['erro' => 'O código da forma de pagamento não foi encontrado'], 404);

        DeliveryTypeHasPaymentMethod::firstOrCreate([
            'delivery_type_id' => $deliveryType->id,
            'payment_method_id' => $paymentMethod->id,
        ]);

        return response()->json(['sucesso' => '@']);
    }

    public function consultarEntregaCep(Request $request)
    {
        if (is_null($request->tipo_entrega_codigo))
            return response()->json(['erro' => 'Informe o código do tipo de entrega'], 403);

        $deliveryType = DeliveryType::where('store_id', $this->store->id)
            ->where('codigo', $request->tipo_entrega_codigo)->first();

        if (is_null($deliveryType))
            return response()->json(['erro' => 'O código do tipo de entrega não foi encontrado'], 404);

        $data = [];
        foreach ($deliveryType->delivery_zip_codes as $key => $item) {
            $data[] = [
                'codigo' => $item->codigo,
                'nome' => $item->nome,
                'cep_ini' => $item->cep_ini,
                'cep_fim' => $item->cep_fim,
                'valor' => $item->valor,
                'usu_alt' => $item->usu_alt ?? '',
                'dta_alteracao' => $item->updated_at->format('Y-m-d H:i:s'),
                'ativo' => $item->status == 'ativo' ? 'S' : 'N',
                'tipo_entrega_codigo' => $deliveryType->codigo,
            ];
        }

        return response()->json(['sucesso' => $data]);
    }

    public function gravarEntregaCep(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'n_codigo' => ['nullable', 'unique:delivery_zip_codes,codigo', 'max:255'],
            'n_tipo_entrega_codigo' => ['required', 'exists:delivery_types,codigo'],
            'nome' => ['required', 'max:255'],
            'cep_ini' =>  ['required', 'max:255'],
            'cep_fim' =>  ['required', 'max:255'],
            "valor" => ['required', 'numeric', 'min:0.00', 'max:999999999'],
            'ativo' => ['required', 'in:S,N', 'max:255'],
        ], [], [
            'n_codigo' => 'código',
            'n_tipo_entrega_codigo' => 'código do tipo de entrega',
        ]);
        if ($validator->fails()) {
            return response()->json(['erro' => $validator->errors()], 422);
        }

        $deliveryZipCode = new DeliveryZipCode;
        $deliveryZipCode->codigo = $request->n_codigo;
        $deliveryZipCode->nome = $request->nome;
        $deliveryZipCode->cep_ini = $request->cep_ini;
        $deliveryZipCode->cep_fim = $request->cep_fim;
        $deliveryZipCode->valor = $request->valor;
        $deliveryZipCode->usu_alt = '';
        $deliveryZipCode->status = $request->ativo == 'S' ? 'ativo' : 'desativado';
        $deliveryZipCode->tipo_entrega_id = $request->n_tipo_entrega_codigo;
        $deliveryZipCode->store_id = $this->store->id;
        $deliveryZipCode->save();

        // salver código do item
        if (is_null($deliveryZipCode->codigo)) :
            if (DeliveryZipCode::where('codigo', $deliveryZipCode->id)->exists() == false) :
                $deliveryZipCode->codigo = $deliveryZipCode->id;
                $deliveryZipCode->save();
            else :
                $total = DeliveryZipCode::count();
                for ($i = 0; $i <= 1000000; $i++) :
                    $total++;
                    if (DeliveryZipCode::where('codigo', $total)->exists() == false) {
                        $deliveryZipCode->codigo = $total;
                        $deliveryZipCode->save();
                        break;
                    }
                endfor;
            endif;
        endif;

        return response()->json(['sucesso' => "{$deliveryZipCode->codigo}"]);
    }

    public function gravarEntregaMesa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => ['nullable', 'unique:delivery_tables,codigo', 'max:255'],
            'tipo_entrega_codigo' => ['required', 'exists:delivery_types,codigo'],
            'mesa' => ['required', 'max:255'],
            'descricao' =>  ['nullable', 'max:1000'],
            'ativo' => ['required', 'in:S,N', 'max:255'],
        ], [], [
            'codigo' => 'código',
            'tipo_entrega_codigo' => 'código do tipo de entrega',
            'descricao' => 'descrição'
        ]);
        if ($validator->fails()) {
            return response()->json(['erro' => $validator->errors()], 422);
        }

        $deliveryType = DeliveryType::where('store_id', $this->store->id)
            ->where('codigo', $request->tipo_entrega_codigo)
            ->first();

        if (is_null($deliveryType))
            return response()->json(['erro' => 'Você não tem tipo de pagamento com o código informado']);

        $deliveryTable = new DeliveryTable;
        $deliveryTable->codigo = $request->codigo;
        $deliveryTable->mesa = $request->mesa;
        $deliveryTable->descricao = $request->descricao;
        $deliveryTable->usu_alt = '';
        $deliveryTable->status = $request->ativo == 'S' ? 'ativo' : 'desativado';
        $deliveryTable->tipo_entrega_id = $deliveryType->id;
        $deliveryTable->store_id = $this->store->id;
        $deliveryTable->save();

        // salver código do item
        if (is_null($deliveryTable->codigo)) :
            if (DeliveryTable::where('codigo', $deliveryTable->id)->exists() == false) :
                $deliveryTable->codigo = $deliveryTable->id;
                $deliveryTable->save();
            else :
                $total = DeliveryTable::count();
                for ($i = 0; $i <= 1000000; $i++) :
                    $total++;
                    if (DeliveryTable::where('codigo', $total)->exists() == false) {
                        $deliveryTable->codigo = $total;
                        $deliveryTable->save();
                        break;
                    }
                endfor;
            endif;
        endif;

        return response()->json(['sucesso' => "{$deliveryTable->codigo}"]);
    }

    public function consultarEntregaMesa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'n_tipo_entrega_codigo' => ['required', 'exists:delivery_types,codigo'],
            'ativo' => ['nullable', 'in:S,N', 'max:255'],
        ], [], [
            'n_tipo_entrega_codigo' => 'código do tipo de entrega',
        ]);
        if ($validator->fails()) {
            return response()->json(['erro' => $validator->errors()], 422);
        }

        $deliveryType = DeliveryType::where('store_id', $this->store->id)
            ->where('codigo', $request->n_tipo_entrega_codigo)
            ->first();

        // filtrar ativo S/N
        if ($request->ativo != null) :
            $ativo = $request->ativo  == 'S' ? 'ativo' : 'desativado';
            $delivery_tables = $deliveryType->delivery_tables()->where('status', $ativo)->get();
        else :
            $delivery_tables = $deliveryType->delivery_tables()->get();
        endif;

        $data = [];
        foreach ($delivery_tables as $delivery_table) {
            $data[] = [
                'codigo' => $delivery_table->codigo,
                'tipo_entrega_codigo' => $deliveryType->codigo,
                'mesa' => $delivery_table->mesa,
                'descricao' => $delivery_table->descricao ?? '',
                'usu_alt' => $delivery_table->usu_alt ?? '',
                'dta_alteracao' => $delivery_table->updated_at->format('Y-m-d H:i:s'),
                'ativo' => $delivery_table->status == 'ativo' ? 'S' : 'N',
            ];
        }

        return response()->json(['sucesso' => $data]);
    }
}
