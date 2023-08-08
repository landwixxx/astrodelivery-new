<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Product;
use App\Traits\StoreApi;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use App\Models\AdditionalGroup;
use App\Models\AdditionalItems;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Shopkeeper\OrderShopkeeperController;

class OrderApiController extends Controller
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

    public function consultarPedidoInterno(Request $request)
    {
        $orders = Order::where('store_id', $this->store->id);

        // forma de pagamento
        if ($request->forma_pgto_codigo != null) :
            $orders->whereHas('payment', function ($query) use ($request) {
                return $query->whereIn('codigo', explode(',', $request->forma_pgto_codigo));
            });
        endif;

        // tipo de entrega
        if ($request->tipo_entrega_codigo != null) :
            $orders->whereHas('delivery', function ($query) use ($request) {
                return $query->whereIn('codigo', explode(',', $request->tipo_entrega_codigo));
            });
        endif;

        // situação pagamento
        if ($request->situacao_pgto != null) :
            $orders->where('situacao_pgto', $request->situacao_pgto);
        endif;

        /**
         * data_hora_ini -> 01/02/2021 22:03:45
         */
        if ($request->data_hora_ini != null) :

            // formatar data informada de ex: '01/02/2021 22:03:45' para '2021-02-01 22:03:45'
            $dataHoraInicio = $request->data_hora_ini . ' 00:00:00';
            $arrayDataHora = explode(' ', $dataHoraInicio);
            $dataIni = isset($arrayDataHora[0]) ? $arrayDataHora[0] : '01/02/1970';
            $horaIni = isset($arrayDataHora[1]) ? $arrayDataHora[1] : '00:00:00';

            $dataIni = explode('/', $dataIni);
            $dataIni = array_reverse($dataIni);
            $dataIni = implode('-', $dataIni);

            $resultadoDataHoraInicio = $dataIni . ' ' . $horaIni;

            // validar data e hora
            $dateString = $resultadoDataHoraInicio;
            $format = 'Y-m-d H:i:s';
            $dateTimeObj = \DateTime::createFromFormat($format, $dateString);

            if ($dateTimeObj && $dateTimeObj->format($format) === $dateString) :
                $dataIni = \Carbon\Carbon::parse($resultadoDataHoraInicio);
                $orders->whereBetween('created_at', [$dataIni, date('Y-m-d H:i:s')]);
            else :
                return response()->json(['erro' => 'O formato de data_hora_ini deve ser DD/MM/YY ou  DD/MM/YY HH:MM:SS '], 403);
            endif;
        endif;

        /**
         * data_hora_fim -> 01/02/2021 22:03:45
         */
        if ($request->data_hora_fim != null) :

            // formatar data informada de ex: '01/02/2021 22:03:45' para '2021-02-01 22:03:45'
            $dataHoraFim = $request->data_hora_fim . ' 00:00:00';
            $arrayDataHora = explode(' ', $dataHoraFim);
            $dataFim = isset($arrayDataHora[0]) ? $arrayDataHora[0] : '01/02/1970';
            $horaIni = isset($arrayDataHora[1]) ? $arrayDataHora[1] : '00:00:00';

            $dataFim = explode('/', $dataFim);
            $dataFim = array_reverse($dataFim);
            $dataFim = implode('-', $dataFim);

            $resultadoDataHoraFim = $dataFim . ' ' . $horaIni;

            // validar data e hora
            $dateString = $resultadoDataHoraFim;
            $format = 'Y-m-d H:i:s';
            $dateTimeObj = \DateTime::createFromFormat($format, $dateString);

            if ($dateTimeObj && $dateTimeObj->format($format) === $dateString) :
                $dataFim = \Carbon\Carbon::parse($resultadoDataHoraFim);
                $orders->whereBetween('created_at', ['1970-01-01', $dataFim]);
            else :
                return response()->json(['erro' => 'O formato de data_hora_fim deve ser DD/MM/YY ou  DD/MM/YY HH:MM:SS '], 403);
            endif;
        endif;

        /**
         * cliente_codigo
         */
        if ($request->cliente_codigo != null) {
            $orders->whereHas('customer', function ($query) use ($request) {
                return $query->where('id', $request->cliente_codigo);
            });
        }

        /**
         * cliente_fone
         */
        if ($request->cliente_fone != null) {
            $orders->whereHas('customer', function ($query) use ($request) {
                $query->whereHas('data_customer', function ($q) use ($request) {
                    $q->where('telefone', 'like', '%' . $request->cliente_fone . '%');
                });
            });
        }

        /**
         * cliente_mes_nasc
         */
        if ($request->cliente_mes_nasc != null) {
            $orders->whereHas('customer', function ($query) use ($request) {
                $query->whereHas('data_customer', function ($q) use ($request) {
                    $q->whereMonth('dt_nascimento', $request->cliente_mes_nasc);
                });
            });
        }

        /**
         * pedido_situacao_codigo
         */
        if ($request->pedido_situacao_codigo != null) {
            $orders->whereIn('order_status_id', explode(',', $request->pedido_situacao_codigo));
        }

        $dataOrders = [];
        foreach ($orders->get() as $key => $order) :

            /**
             * organizar produtos para obter dados para organizar melhor
             */
            $produtos = [];
            foreach (OrderItems::where('order_id', $order['id'])->get() as $key => $pro_item_obj) :

                if (is_null($pro_item_obj->product)) // se produto existe
                    continue;

                $pro_item = $pro_item_obj->product->toArray();

                /**
                 * organizar adicionais para obter dados para organizar melhor
                 */
                $adicionais = [];
                foreach (AdditionalItems::where('order_id', $order['id'])->where('order_item_id', $pro_item_obj->id)->get() as $key => $add) :
                    $add_product = Product::find($add->additional_id);
                    if ($add_product) :
                        // dados de adicionais
                        $add_product['quantidade'] = $add->quantidade;
                        $add_product['valor_adicional_pedido'] = $add->valor_adicional_pedido;
                        $adicionais[] = $add_product;
                    endif;
                endforeach;
                // dados do produto
                $pro_item['adicionais'] = $adicionais;
                $pro_item['quantidade'] = $pro_item_obj->quantidade;
                $pro_item['valor_item_pedido'] = $pro_item_obj->valor_item_pedido;
                $pro_item['obs_produto'] = $pro_item_obj->obs_produto;

                $produtos[] = $pro_item;
            endforeach;

            /**
             * Organizar dados do pedido
             */
            $newDataOrder = [];

            $newDataOrder['codigo'] = $order->codigo;
            $newDataOrder['data_hora'] = $order->created_at->format('Y-m-d H:i:s');
            $newDataOrder['cliente_codigo'] = "{$order->user_id}";
            $newDataOrder['cli_endereco_codigo'] = "";
            $newDataOrder['cliente_nome'] = $order->customer ? $order->customer->name : null;
            $newDataOrder['cliente_fone'] = isset($order->customer->data_customer->telefone) ? $order->customer->data_customer->telefone : null;
            $newDataOrder['vlr_produtos'] = $order->total_pedido;
            $newDataOrder['cliente_cpf'] = isset($order->customer->data_customer->cpf) ? $order->customer->data_customer->cpf : null;
            $newDataOrder['cliente_dta_nasc'] = isset($order->customer->data_customer->dt_nascimento) ? $order->customer->data_customer->dt_nascimento : null;
            $newDataOrder['tipo_entrega_codigo'] = $order->delivery ? $order->delivery->codigo : null;
            $newDataOrder['tipo_entrega_descricao'] = $order->delivery ? $order->delivery->nome : null;
            $newDataOrder['previsão_entrega'] = $order->tempo;
            $newDataOrder['forma_pgto_codigo'] = $order->payment ? $order->payment->codigo : null;
            $newDataOrder['forma_pgto_descricao'] = $order->payment ? $order->payment->descricao : null;
            $newDataOrder['situacao_pgto'] = $order->situacao_pgto;
            $newDataOrder['vlr_desc'] = "0";
            $newDataOrder['dsc_desc'] = "";
            $newDataOrder['vlr_taxa'] = $order->valor;
            $newDataOrder['dsc_taxa'] = $order->delivery ? $order->delivery->descricao : null;;
            $newDataOrder['vlr_acrescimo'] = "0";
            $newDataOrder['vlr_total'] = "" . $order->total_pedido + $order->valor . ""; // valor do pedido + taxa
            $newDataOrder['dta_alteracao'] = $order->updated_at->format('Y-m-d H:i:s');
            $newDataOrder['usu_alt'] = "";
            $newDataOrder['pedido_situacao_codigo'] = "{$order->order_status_id}";
            $newDataOrder['obs'] = "{$order->observacao}";
            $newDataOrder['forma_pgto_adicional'] = $order->valor_troco > 0 ? "Obs: troco para " . currency_format($order->valor_troco) : '';
            $newDataOrder['tipo_entrega_adicional'] = "";
            $newDataOrder['endereco'] = isset($order->end_entrega['rua']) ? "Rua " . $order->end_entrega['rua'] : "";
            $newDataOrder['numero'] = isset($order->end_entrega['numero']) ? "{$order->end_entrega['numero']}" : "";
            $newDataOrder['complemento'] = isset($order->end_entrega['complemento']) ? "{$order->end_entrega['complemento']}" : "";
            $newDataOrder['bairro'] = isset($order->end_entrega['bairro']) ? "{$order->end_entrega['bairro']}" : "";
            $newDataOrder['cidade'] = isset($order->end_entrega['cidade']) ? "{$order->end_entrega['cidade']}" : "";
            $newDataOrder['uf'] = isset($order->end_entrega['estado']) ? "{$order->end_entrega['estado']}" : "";
            $newDataOrder['referencia'] = "";
            $newDataOrder['cep'] = isset($order->end_entrega['cep']) ?  "" . str_replace(['-', '.'], [''], $order->end_entrega['cep']) . "" : "";
            $newDataOrder['pedido_situacao_descricao'] = $order->order_status ? $order->order_status->nome : '';
            $newDataOrder['tipo_entrega_tipo'] = $order->delivery ? $order->delivery->tipo : '';
            $newDataOrder['mesa'] = $order->delivery_table ? $order->delivery_table->mesa : '';
            $newDataOrder['mesa_descricao'] = $order->delivery_table ? $order->delivery_table->descricao : '';
            $newDataOrder['integrado'] = $order->integrado;

            // $newDataOrder = [];
            $dataProducts = [];

            /**
             * Retornar dados de produtos S/N
             */
            if ($request->produtos == 'S' || is_null($request->produtos)) :
                /**
                 * Organizar dados de produtos
                 */
                foreach ($produtos as $keyProd => $produto) :

                    $grupoAdicional = $produto['grupo_adicional_id'] ? AdditionalGroup::find($produto['grupo_adicional_id'])  : null;
                    $grupoNomeAdicional = '';
                    $grupoNomeAdicionalDsc = '';
                    if ($grupoAdicional != null) :
                        $grupoNomeAdicional = $grupoAdicional->nome;
                        $grupoNomeAdicionalDsc = $grupoAdicional->descricao;
                    endif;

                    $sequencial = $keyProd + 1;
                    $vtotal = '' . number_format(($produto['quantidade'] * $produto['valor_item_pedido']), 2, '.', '') . '';
                    $dataProducts[] = [
                        'produtos_codigo' => $produto['codigo'] ?: '',
                        'pedido_codigo' => $order->codigo,
                        'grupo_nome_adicional' => $grupoNomeAdicional,
                        'grupo_nome_adicional_dsc' => $grupoNomeAdicionalDsc,
                        'sequencial' => "$sequencial",
                        'adicional' => $produto['item_adicional'] ?: '',
                        'nome' => $produto['nome'] ?: '',
                        'qtde' => $produto['quantidade'] ? '' . $produto['quantidade'] . '' : '',
                        'valor' => $produto['valor_item_pedido'] ?: '',
                        'total' => $vtotal,
                        'codigo_empresa' => $produto['codigo_empresa'] ?: '',
                        'codigo_barras' => $produto['codigo_barras'] ?: '',
                        'codigo_barras_padrao' => $produto['codigo_barras_padrao'] ?: '',
                        'prod_obs' => $produto['obs_produto'] ?: '',
                        'adicionais' => [],
                    ];

                    /**
                     * Organizar dados de adicionais
                     */
                    $dataAdditionals = [];
                    if (is_array($produto['adicionais'])) :
                        foreach ($produto['adicionais'] as $keyAdicional => $adicional) :
                            $grupoAdicionalDeProduto = $adicional['grupo_adicional_id'] ? AdditionalGroup::find($adicional['grupo_adicional_id'])  : null;
                            $grupoNomeAdicionalDeProduto = '';
                            $grupoNomeAdicionalDeProdutoDsc = '';
                            if ($grupoAdicionalDeProduto != null) :
                                $grupoNomeAdicionalDeProduto = $grupoAdicionalDeProduto->nome;
                                $grupoNomeAdicionalDeProdutoDsc = $grupoAdicionalDeProduto->descricao;
                            endif;

                            $sequencialAdicional = $keyAdicional + 1;
                            $vtotalAdicional = '' . number_format(($adicional['quantidade'] * $adicional['valor_adicional_pedido']), 2, '.', '') . '';
                            $dataAdditionals[] = [
                                'produtos_codigo' => $adicional['codigo'] ?: '',
                                'pedido_codigo' => $order->codigo,
                                'grupo_nome_adicional' => $grupoNomeAdicionalDeProduto,
                                'grupo_nome_adicional_dsc' => $grupoNomeAdicionalDeProdutoDsc,
                                'sequencial' => "$sequencialAdicional",
                                'adicional' => $adicional['item_adicional'] ?: '',
                                'nome' => $adicional['nome'] ?: '',
                                'qtde' => $adicional['quantidade'] ? '' . $adicional['quantidade'] . '' : '',
                                'valor' => $adicional['valor_adicional_pedido'] ?: '',
                                'total' => $vtotalAdicional,
                                'codigo_empresa' => $adicional['codigo_empresa'] ?: '',
                                'codigo_barras' => $adicional['codigo_barras'] ?: '',
                                'codigo_barras_padrao' => $adicional['codigo_barras_padrao'] ?: '',
                            ];
                        endforeach; // adicionais

                        $ultimoIndiceProdudos = count($dataProducts) - 1;
                        $dataProducts[$ultimoIndiceProdudos]['adicionais'] = $dataAdditionals;
                    endif;

                endforeach; // produtos
            endif;

            //organizar da dados da pizza
            $dataPizzas = $order->data_montar_pizza;
            if (!empty($dataPizzas)) :
                foreach ($dataPizzas as $keyItem => $ItemPizza) :
                    // $dataPizzas
                    if (isset($ItemPizza['adicionais']) && is_array($ItemPizza['adicionais'])) :
                        foreach ($ItemPizza['adicionais'] as $keyAd => $itemAdicional) :
                            if (isset($dataPizzas[$keyItem]['adicionais'][$keyAd]['id'])) :
                                // add codigo no array
                                $prodAd = Product::find($dataPizzas[$keyItem]['adicionais'][$keyAd]['id']);
                                if (!is_null($prodAd)) :
                                    // $dataPizzas[$keyItem]['adicionais'][$keyAd]['codigo'] = $prodAd->codigo;
                                    // organizar ordem de array
                                    $orgAd = [];
                                    $orgAd['codigo'] = $prodAd->codigo;
                                    $orgAd['nome'] = $itemAdicional['nome'];
                                    $orgAd['img'] = $itemAdicional['img'];
                                    $orgAd['descricao'] = $itemAdicional['descricao'];
                                    $orgAd['qtd'] = $itemAdicional['qtd'];
                                    $orgAd['valor'] = $itemAdicional['valor'] / $itemAdicional['qtd'];

                                    // array_merge($dataPizzas[$keyItem]['adicionais'][$keyAd],  ['codigo' => $prodAd->codigo]);

                                    $dataPizzas[$keyItem]['adicionais'][$keyAd] = $orgAd;
                                endif;
                                // remover id do array
                                unset($dataPizzas[$keyItem]['adicionais'][$keyAd]['id']);
                            endif;
                        endforeach;
                    endif;
                endforeach;
            endif;

            $dataPizzasProduto = $order->data_pizza_produto ?? [];
            // Organizar imagens de sabores da pizza
            if (count($dataPizzasProduto) > 0) :
                foreach ($dataPizzasProduto as $keyPizza => $pizzaProduto) :

                    $dataPizzasProduto[$keyPizza]['pedido_codigo'] = $order->codigo;
                    unset($dataPizzasProduto[$keyPizza]['produto_id']);

                    foreach ($pizzaProduto['sabores'] as $keySabor => $sabor) :
                        $img = $sabor['imagem'] ?? 'assets/img/pizza/pizza-empty.png';
                        $dataPizzasProduto[$keyPizza]['sabores'][$keySabor]['imagem'] = asset($img);
                    endforeach;
                    // adicionar imagens de bordas
                    foreach ($pizzaProduto['bordas'] as $keySabor => $borda) :
                        $img = $borda['imagem'] ?? 'assets/img/pizza/pizza-empty.png';
                        $dataPizzasProduto[$keyPizza]['bordas'][$keySabor]['imagem'] = asset($img);
                    endforeach;
                endforeach;
            endif;

            $newDataOrder['produtos'] = $dataProducts;
            $newDataOrder['pizzas_montadas'] = $dataPizzas;
            $newDataOrder['pizzas_produto'] = $dataPizzasProduto;
            $dataOrders[] =  $newDataOrder;
        endforeach;

        return response()->json($dataOrders);
    }

    public function atualizarIntegradoPedido(Request $request)
    {
        $orders = Order::where('store_id', $this->store->id);

        if ($request->n_codigo != null) {
            if ($orders->where('codigo', $request->n_codigo)->exists()) :
                $orders->where('codigo', $request->n_codigo)->update([
                    'integrado' => 'S'
                ]);
                return response()->json(['sucesso' => 'ok']);
            else :
                return response()->json(['erro' => 'O código informado não foi encontrado'], 404);
            endif;
        }

        return response()->json(['erro' => 'Informe um código'], 403);
    }

    public function atualizarPedido(Request $request)
    {

        $orders = Order::where('store_id', $this->store->id);

        if (is_null($request->n_codigo))
            return response()->json(['erro' => 'Informe um código'], 403);

        if ($orders->whereIn('codigo', explode(',', $request->n_codigo))->exists() == false)
            return response()->json(['erro' => 'O código informado não foi encontrado'], 404);

        if (is_null($request->situacao_pgto))
            return response()->json(['erro' => 'Informe uma situação de pagamento PENDENTE ou PAGO'], 403);

        if ($request->situacao_pgto != 'PENDENTE' && $request->situacao_pgto != 'PAGO')
            return response()->json(['erro' => "A situação de pagamento tem que ser 'PENDENTE' ou 'PAGO'"], 403);

        if (is_null($request->n_status_pedido))
            return response()->json(['erro' => 'Informe um número de status do pedido'], 403);

        if (in_array($request->n_status_pedido, [1, 2, 3, 4, 5, 6, 7]) == false)
            return response()->json(['erro' => 'O número de status do pedido tem que ser entre 1 e 7'], 403);

        // pedidos
        $orders = $orders->whereIn('codigo', explode(',', $request->n_codigo));
        // atualizar estoque
        $this->updateStockAndTime($orders, $request->n_status_pedido);

        // atualizar status e situação pgto
        $result = $orders->update([
            'order_status_id' => $request->n_status_pedido,
            'situacao_pgto' => $request->situacao_pgto,
            'obs_status_pedido' => $request->obs
        ]);

        if ($result)
            return response()->json(['sucesso' => 'ok']);

        return response()->json(['erro' => 'Pedido não foi atualizado'], 409);
    }

    public function updateStockAndTime($orders, $new_order_status_id)
    {
        foreach ($orders->get() as $order) :
            if (in_array($new_order_status_id, [1, 2, 3, 4]))
                $this->acceptOrder($order);

            if (in_array($new_order_status_id, [5, 7]))
                $this->deliveredOrder($order);

            if ($new_order_status_id == 6)
                $this->cancelOrder($order);
        endforeach;
    }

    public function acceptOrder($order)
    {
        $orderController = new OrderShopkeeperController;

        if ($order->order_status_id == 6) // atualizar estoque se tiver sido cancelado
            $orderController->updateStock($order);

        if (is_null($order->timestamp_aceito))
            $order->timestamp_aceito = time();
        $order->save();

        return $order;
    }

    public function deliveredOrder($order)
    {
        $orderController = new OrderShopkeeperController;
        if ($order->order_status_id == 6) // atualizar esque se tiver sido cancelado
            $orderController->updateStock($order);

        $order->timestamp_aceito = null;
        $order->save();
        return $order;
    }

    public function cancelOrder($order)
    {
        $orderController = new OrderShopkeeperController;
        if ($order->order_status_id != 6) // se já não é cancelado
            $orderController->restoreStock($order);

        $order->timestamp_aceito = null;
        $order->save();

        return $order;
    }
}
