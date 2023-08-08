<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderShopkeeperController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:lojista|funcionario', 'can:visualizar pedidos']);
    }

    public function index(Request $request)
    {
        if (is_null(auth()->user()->store_has_user))
            return $this->redirectConfig();

        $orders = Order::where('store_id', auth()->user()->store_has_user->store_id);

        if ($request->has('v') && !is_null($request->v)) // pesquisa
            $orders = $this->search($orders, $request);

        $orders = $orders->latest()->paginate(12);
        return view('painel.lojista.pedidos.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $orderTime = $this->orderTime($order);
        return view('painel.lojista.pedidos.show', compact('order', 'orderTime'));
    }

    public function destroy(Order $order)
    {
        $this->checkModUser($order->store_id);
        $this->authorize('excluir pedidos');

        if ($order->order_status_id != 6 && $order->order_status_id != 7) // restourar estoque se status não for cancelado ou finalizado
            $this->restoreStock($order);

        $order->delete();
        return redirect()->back()->withSuccess('Pedido removido com sucesso');
    }

    public function acceptOrder(Request $request, Order $order)
    {
        $this->authorize('aprovar pedidos');
        $this->checkModUser($order->store_id);

        $order->obs_status_pedido = $request->obs_status_pedido;

        if ($order->order_status_id == 6) // atualizar esque se tiver sido cancelado
            $this->updateStock($order);

        $order->order_status_id = 2;
        $order->situacao_pgto = 'PENDENTE';
        if (is_null($order->timestamp_aceito))
            $order->timestamp_aceito = time();
        session()->put('total_pedidos_session', null); // resetar session total de pedidos para usar na notificação
        $order->save();
        return redirect()->back()->withSuccess('Pedido aceito com sucesso');
    }

    public function cancelOrder(Request $request, Order $order)
    {
        $this->authorize('negar pedidos');
        $this->checkModUser($order->store_id);
        $order->obs_status_pedido = $request->obs_status_pedido;

        if ($order->order_status_id != 6) // se já não é cancelado
            $this->restoreStock($order);

        $order->order_status_id = 6;
        $order->situacao_pgto = 'PENDENTE';
        $order->timestamp_aceito = null;
        session()->put('total_pedidos_session', null); // resetar session total de pedidos para usar na notificação
        $order->save();

        return redirect()->back()->withSuccess('Pedido cancelado com sucesso');
    }

    public function inProductionOrder(Request $request, Order $order)
    {
        $this->authorize('aprovar pedidos');
        $this->checkModUser($order->store_id);
        $order->obs_status_pedido = $request->obs_status_pedido;

        if ($order->order_status_id == 6) // atualizar esque se tiver sido cancelado
            $this->updateStock($order);

        $order->order_status_id = 3;
        $order->situacao_pgto = 'PENDENTE';
        if (is_null($order->timestamp_aceito))
            $order->timestamp_aceito = time();
        session()->put('total_pedidos_session', null); // resetar session total de pedidos para usar na notificação
        $order->save();
        return redirect()->back()->withSuccess('Pedido colocado em produção com sucesso');
    }

    public function onDeliveryRouteOrder(Request $request, Order $order)
    {
        $this->authorize('aprovar pedidos');
        $this->checkModUser($order->store_id);

        $order->obs_status_pedido = $request->obs_status_pedido;

        if ($order->order_status_id == 6) // atualizar esque se tiver sido cancelado
            $this->updateStock($order);

        $order->order_status_id = 4;
        $order->situacao_pgto = 'PENDENTE';
        if (is_null($order->timestamp_aceito))
            $order->timestamp_aceito = time();
        session()->put('total_pedidos_session', null); // resetar session total de pedidos para usar na notificação
        $order->save();
        return redirect()->back()->withSuccess('Pedido colocado em rota de entrega com sucesso');
    }

    public function deliveredOrder(Request $request, Order $order)
    {
        $this->authorize('aprovar pedidos');
        $this->checkModUser($order->store_id);
        $order->obs_status_pedido = $request->obs_status_pedido;

        if ($order->order_status_id == 6) // atualizar esque se tiver sido cancelado
            $this->updateStock($order);

        $order->order_status_id = 5;
        $order->situacao_pgto = 'PENDENTE';
        $order->timestamp_aceito = $order->timestamp_aceito = null;
        session()->put('total_pedidos_session', null); // resetar session total de pedidos para usar na notificação
        $order->save();
        return redirect()->back()->withSuccess('Pedido entregue com sucesso');
    }

    public function finishedOrder(Request $request, Order $order)
    {
        $this->authorize('aprovar pedidos');
        $this->checkModUser($order->store_id);
        $order->obs_status_pedido = $request->obs_status_pedido;

        if ($order->order_status_id == 6) // atualizar esque se tiver sido cancelado
            $this->updateStock($order);

        $order->order_status_id = 7;
        $order->situacao_pgto = 'PAGO';
        $order->timestamp_aceito = null;
        session()->put('total_pedidos_session', null); // resetar session total de pedidos para usar na notificação
        $order->save();
        return redirect()->back()->withSuccess('Pedido finalizado com sucesso');
    }

    public function redirectConfig()
    {
        return redirect()
            ->route('painel.lojista.configuracoes')
            ->withErro('Você precisa adicionar os dados da sua loja antes de adicionar categorias.');
    }

    /**
     * Varifciar se usuário pode modificar
     *
     * @return void
     */
    public function checkModUser($store_id)
    {
        if (auth()->user()->store_has_user->store->id != $store_id)
            abort(403);
    }

    public function search($orders, $request)
    {
        $strSearch = str_replace(['R$', '  ', '.', ','], ['', ' ', ',', '.'], $request->v);
        $strSearch = explode(' ', " $strSearch ");
        $strSearch = implode('%', $strSearch);

        $orders->where('id', 'like', $strSearch)
            ->orWhereHas('order_items', function ($q) use ($strSearch) { // nome do produto
                return $q->whereHas('product', function ($query) use ($strSearch) {
                    return $query->where('nome', 'like', $strSearch);
                });
            })
            ->orWhereHas('customer', function ($q) use ($strSearch) { // nome do cliente
                return $q->where('name', 'like', $strSearch);
            })
            ->orWhere('total_pedido', 'like', $strSearch) // valor do pedido
            ->orWhereHas('payment', function ($q) use ($strSearch) { // tipo de pagamento
                return $q->where('nome', 'like', $strSearch);
            })
            ->orWhereHas('delivery', function ($q) use ($strSearch) { // tipo de entrega
                return $q->where('nome', 'like', $strSearch);
            })
            ->orWhereHas('order_status', function ($q) use ($strSearch) { // status
                return $q->where('nome', 'like', $strSearch);
            });

        return $orders;
    }

    /**
     * Obter tempo do pedido, se o pedido for aceito libera o cronometro
     *
     * @return void
     */
    public function orderTime($order)
    {
        $dataTimeArray = explode(':', $order->tempo);
        $hours = intval($dataTimeArray[0]);
        $min = intval($dataTimeArray[1]);
        $sec = intval($dataTimeArray[2]);

        // somar data atual com o tempo de entrega para obter a data final
        $dateAccept = date('Y-m-d H:i:s', $order->timestamp_aceito);
        $dateEnd = date('Y-m-d H:i:s', strtotime($dateAccept . " + $hours hours"));
        $dateEnd = date('Y-m-d H:i:s', strtotime($dateEnd . " + $min minutes"));
        $dateEnd = date('Y-m-d H:i:s', strtotime($dateEnd . " + $sec seconds"));

        // data atual
        $dateCurrent = date('Y-m-d H:i:s');

        // timestamp de datas
        $dateEndTimestamp = strtotime($dateEnd);
        $dateCurrentTimestamp = strtotime($dateCurrent);

        // 
        $carbonDateCurrent = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dateCurrent);
        $carbonDateEnd = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dateEnd);

        $time = $carbonDateCurrent->diff($carbonDateEnd);
        $timeResult = '';
        $timeResult .= $time->y ? "{$time->y}a " : '';
        $timeResult .= $time->m ? "{$time->m}m " : '';
        $timeResult .= $time->d ? "{$time->d}d " : '';
        $timeResult .= ($time->h < 10 ? '0' . $time->h : $time->h) . ':' . ($time->i < 10 ? '0' . $time->i : $time->i) . ':' . ($time->s < 10 ? '0' . $time->s : $time->s);

        // Resultado com tempo
        $resultHtml = '';

        if ($dateCurrentTimestamp <= $dateEndTimestamp) : // se o timer atual é menor que o tempo final do pedido
            if ($order->timestamp_aceito === null) :
                $resultHtml = "<span class='badge rounded-pillss text-bg-warning'> {$order->tempo} </span>";
            endif;
            if ($order->timestamp_aceito == true) :
                $resultHtml = "<span class='badge rounded-pillss text-bg-success'> {$timeResult} </span>";
            endif;
            if ($order->timestamp_aceito === 0) :
                $resultHtml = "<span class='badge rounded-pillss text-bg-danger'> 00:00:00</span>";
            endif;
        else :
            if ($order->order_status_id == 5 || $order->order_status_id == 6 || $order->order_status_id == 7 || $order->timestamp_aceito != null) :
                $resultHtml = "<span class='badge rounded-pillss text-bg-danger'> 00:00:00 </span>";
            else :
                $resultHtml = "<span class='badge rounded-pillss text-bg-warning'> {$order->tempo}</span>";
            endif;
        endif;

        return $resultHtml;
    }

    /**
     * Restaurar estoque de produtos e adicionais quaando o pedido é cancelado
     *
     * @return void
     */
    public function restoreStock($order)
    {
        // $dataOrder = $this->dataOrderJsonToArray($order->data_order);
        $dataOrder = $order->data_order;

        /* restourar estoque de adicionais de produto */
        foreach ($dataOrder as $item) {
            // atualizar estoque
            $product = Product::find($item['product_id']);
            if (!is_null($product)) :
                $product->estoque = $product->estoque + $item['qtd_item'];
                $product->save();
            endif;

            // adicionais
            if (isset($item['additionals']) && count($item['additionals']) > 0) :
                foreach ($item['additionals'] as $additional) {
                    // atualizar estoque
                    $productAdditional = Product::find($additional['additional_id']);
                    if (!is_null($productAdditional)) :
                        $productAdditional->estoque = $productAdditional->estoque + $additional['qtd_item'];
                        $productAdditional->save();
                    endif;
                }
            endif;
        }

        // restourar estoque de adicionais de pizza
        foreach ($order->data_montar_pizza as $item) :
            if (isset($item['adicionais']) && is_array($item['adicionais']) && count($item['adicionais']) > 0) :
                foreach ($item['adicionais'] as $add) :
                    $productAdditional = Product::find($add['id']);
                    if (!is_null($productAdditional)) :
                        $productAdditional->estoque += intval($add['qtd']);
                        if ($productAdditional->estoque < 0)
                            $productAdditional->estoque = 0;
                        $productAdditional->save();
                    endif;
                endforeach;
            endif;
        endforeach;
    }

    /**
     * Atualizar estoque de produtos e adicionais,
     * subtraindo a qtd do pedido do total em estoque do produto ou adicional
     *
     * @return void
     */
    public function updateStock($order)
    {
        // $dataOrder = $this->dataOrderJsonToArray($order->data_order);
        $dataOrder = $order->data_order;

        // atualizar estoque de adicionais de produto
        foreach ($dataOrder as $item) {
            // atualizar estoque
            $product = Product::find($item['product_id']);
            if (!is_null($product)) :
                $product->estoque = $product->estoque - $item['qtd_item'];
                if ($product->estoque < 0)
                    $product->estoque = 0;
                $product->save();
            endif;

            // adicionais
            if (isset($item['additionals']) && count($item['additionals']) > 0) :
                foreach ($item['additionals'] as $additional) {
                    // atualizar estoque
                    $productAdditional = Product::find($additional['additional_id']);
                    if (!is_null($productAdditional)) :
                        $productAdditional->estoque = $productAdditional->estoque - $additional['qtd_item'];
                        if ($productAdditional->estoque < 0)
                            $productAdditional->estoque = 0;
                        $productAdditional->save();
                    endif;
                }
            endif;
        }

        // atualizar estoque de adicionais de pizza
        foreach ($order->data_montar_pizza as $item) :
            if (isset($item['adicionais']) && is_array($item['adicionais']) && count($item['adicionais']) > 0) :
                foreach ($item['adicionais'] as $add) :
                    $productAdditional = Product::find($add['id']);
                    if (!is_null($productAdditional)) :
                        $productAdditional->estoque -= intval($add['qtd']);
                        if ($productAdditional->estoque < 0)
                            $productAdditional->estoque = 0;
                        $productAdditional->save();
                    endif;
                endforeach;
            endif;
        endforeach;
    }

    /**
     * Colocar tudo de objeto para array
     *
     * @param  mixed $dataOrder
     * @return array
     */
    public function dataOrderJsonToArray($dataOrder): array
    {
        $dataOrder = (array) json_decode($dataOrder);
        foreach ($dataOrder as $key => $item) {
            $dataOrder[$key] = (array) $item;

            if (isset($dataOrder[$key]['additionals'])) :
                $dataOrder[$key]['additionals'] = (array) $dataOrder[$key]['additionals'];
                foreach ($dataOrder[$key]['additionals'] as $key_ad => $additional) {
                    $dataOrder[$key]['additionals'][$key_ad] = (array) $additional;
                }
            endif;
        }

        return $dataOrder;
    }
}
