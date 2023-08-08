<?php

namespace App\Http\Controllers\Customer;

use App\Models\Store;
use App\Models\Order;
use App\Models\User;
use App\Models\AdditionalItems;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class RecentOrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth_customer', 'role:cliente']);
    }

    public function index($slug_store)
    {
        $store = Store::where('slug_url', $slug_store)->first();
        $orders = $this->orderData($store->id);

        return view('front.loja.clientes.pedidos_recentes', compact('store', 'orders'));
    }

    /**
     * show order
     *
     * @param  mixed $slug_store
     * @param  \App\Models\Order $order
     * @return void
     */
    public function order($slug_store, Order $order)
    {
        $store = Store::where('slug_url', $slug_store)->first();
        $orderTime = $this->orderTime($order);

        return view('front.loja.clientes.pedido', compact('store', 'order', 'orderTime'));
    }

    private function orderData($store_id)
    {
        $orders = Order::where('store_id', $store_id)
            ->where('user_id', auth()->user()->id)
            ->with('order_items')
            ->with('order_status')
            ->with('delivery')
            ->with('payment');


        // verificar se tem produtos e se algum foi deletado, assim desconsidera o pedido
        $idsOrderIgnorar = [];
        // foreach ($orders->get() as $ord) :
        //     foreach ($ord->order_items as $or_item) :
        //         if ($or_item->product == null && $ord->data_order != '[]') :
        //             array_push($idsOrderIgnorar, $ord->id);
        //             break;
        //         endif;
        //     endforeach;
        // endforeach;




        // verificar se algum adicional do produto foi deletado
        // verificar se algum adicional de montar pizza foi deletado

        // dd($idsOrderIgnorar);
        // vou restourar o stoque e remover 
        // $orders->whereNotIn('id', $idsOrderIgnorar);

        //
        $orders = $orders->latest()->paginate(10);

        // foreach ($orders as $key => $order) :

        //     $descricao_pedido = null;
        //     foreach ($order->order_items as $key => $order_item) {

        //         $item = Product::where('id', $order_item->product_id)->with('image')->first();
        //         if (is_null($item))
        //             continue;

        //         $order_item->dados_item = $item;
        //         $descricao_pedido = $item->nome;
        //         $order['preco'] = $item->valor * $order_item->quantidade;
        //         $additionals = AdditionalItems::where('order_id', $order_item->order_id)
        //             ->where('product_id', $order_item->product_id)
        //             ->get();

        //         if ($additionals->count()) {
        //             foreach ($additionals as $additional) {
        //                 $product = Product::where('id', $additional->additional_id)->with('image')->with('additional_group')->first();
        //                 $order['preco'] += $product->valor;
        //                 $adicionais[] = $product;
        //                 $order_item->preco_item = $order['preco'];
        //             }
        //             $order_item->adicionais = $adicionais;
        //         }
        //     }
        // $order['descricao_pedido'] = $descricao_pedido;
        // $order['data'] = $order->created_at->format('d/m/Y \à\s H:i');
        // $user = User::where('id', $order->user_id)->first();
        // $order['user_name'] = $user->name;

        // endforeach;
        return $orders;
    }

    public function repeatOrder($slug_store, Order $order)
    {
        if ($order->user_id != auth()->user()->id)
            abort(403);

        // $data = (array) json_decode($order->data_order);
        $dataProdutos = $order->data_order;
        $dataPizza = $order->data_montar_pizza;
        $dataPizzaProduct = $order->data_pizza_produto;

        session()->put('items_cart', $dataProdutos);
        session()->put('items_cart_pizza', $dataPizza);
        session()->put('items_cart_pizza_produto', $dataPizzaProduct);
        return redirect()->route('cliente.resumo-pedido', $slug_store);
    }

    public function removeOrder($slug_store, Order $order)
    {
        if ($order->user_id != auth()->user()->id)
            abort(403);
        if ($order->order_status_id != 6 && $order->order_status_id != 7)
            abort(403);

        $order->delete();
        return redirect()->back()->withSuccess('Pedido removido com sucesso');
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
}
