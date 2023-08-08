<?php

namespace App\Http\Controllers\Customer;

use App\Models\Order;
use App\Models\Store;
use App\Models\AddCart;
use App\Models\Product;
use App\Models\OrderItems;
use App\Models\DeliveryType;
use Illuminate\Http\Request;
use App\Models\BannedCustomer;
use App\Models\AdditionalGroup;
use App\Models\AdditionalItems;
use App\Models\DeliveryZipCode;
use App\Models\StoreHasCustomer;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Controllers\StoreController;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth_customer', 'role:cliente', 'verify-shopkeeper-disabled'])->except([
            'addProduct',
            'addPizza',
            'index',
            'addCart',
        ]);
    }

    public function store(OrderStoreRequest $request, $slug_store)
    {
        $store = Store::where('slug_url', $slug_store)->first();

        // verificar se existe produtos e adicionais em estoque com a quantidade do pedido
        $checkStock = $this->checkStock($slug_store);
        if ($checkStock['erro'])
            return $checkStock['redirect'];

        if (BannedCustomer::where('user_id', auth()->user()->id)->where('store_id', $store->id)->exists())
            return redirect()->back()->withError('Você foi banido desta loja, se você acha que isso é um erro, entre em contato conosco');

        // obter valor do pedido
        $items_cart = session('items_cart') ?? [];
        $soma_pedido = array_column($items_cart, 'vl_item');
        $soma_pedido = array_sum($soma_pedido);
        $request['total_pedido'] = $soma_pedido;

        // total de montar pizza
        $valoresMontaPizza = 0;
        if (count(session('items_cart_pizza') ?? []) > 0) :
            // dd(session('items_cart_pizza'));
            $valoresMontaPizzaArr = array_column(session('items_cart_pizza'), 'valor_total');
            $valoresMontaPizza = array_sum($valoresMontaPizzaArr);
            $request['total_pedido'] += $valoresMontaPizza;
        endif;

        // total de pizza produto
        if (count(session('items_cart_pizza_produto') ?? []) > 0) :
            $valoresMontaPizzaArr = array_column(session('items_cart_pizza_produto'), 'valor_total');
            $valoresMontaPizza = array_sum($valoresMontaPizzaArr);
            $request['total_pedido'] += $valoresMontaPizza;
        endif;

        // obter valor da taxa entrega
        $delivery_type = DeliveryType::find($request->delivery_type_id);
        $request['valor'] = $delivery_type->valor;
        // valor do cep se for do tipo 'delivery' ou 'correios'
        if ($delivery_type->tipo == 'Delivery' || $delivery_type->tipo == 'Correios') {
            $dadosCep = DeliveryZipCode::where('status', 'ativo')
                ->where('store_id', $store->id)
                ->where('cep_fim', str_replace(['.', '-'], [''], $request->cep))
                ->first();
            if ($dadosCep != null) {
                $request['valor'] = $dadosCep->valor;
            }
        }

        // validar valor mínimo para entrega
        if ($request['total_pedido'] < $delivery_type->valor_minimo)
            return redirect()->back()
                ->withError("O valor mínimo do pedido para o tipo de entrega que você selecionou é " . currency($delivery_type->valor_minimo));

        // se tipo de entrega obriga CEP
        if ($delivery_type->tipo == 'Delivery' || $delivery_type->tipo == 'Correios')
            if ($delivery_type->bloqueia_sem_cep == 'S' && $request->cep == null)
                return redirect()->back()->withError('É obrigatório informar um CEP para o tipo de entrega que você selecionou');

        // registrar mesa apenas se o tipo for 'Mesa'
        if ($delivery_type->tipo != 'Mesa' && isset($request['delivery_table_id']))
            $request['delivery_table_id'] = null;


        // obter tempo
        $request['tempo'] = $delivery_type->tempo;


        /* Validar pedido da pizza */
        $orderMontarPizza = new OrderAssemblePizzaController;
        $resVerificarAdPizza = $orderMontarPizza->verificarAdicionalMontarPizza($slug_store);
        if ($resVerificarAdPizza['erro']) :
            return $resVerificarAdPizza['redirect'];
        endif;

        /* validar se o produto pizza tá disponivel */
        if (count(session('items_cart_pizza_produto') ?? []) > 0) :
            foreach (session('items_cart_pizza_produto') as $key => $value) :
                if (is_null(Product::find($value['produto_id']))) :
                    return redirect()
                        ->route('cliente.resumo-pedido', $slug_store)
                        ->with('nao_disponivel', "Desculpe, o item &quot;" . $value['nome'] . "&quot; não está mais disponível.");
                else :
                    $produtoPizza = Product::find($value['produto_id']);
                    if ($produtoPizza->ativo == 'N')
                        return redirect()
                            ->route('cliente.resumo-pedido', $slug_store)
                            ->with('nao_disponivel', "Desculpe, o item &quot;" . $value['nome'] . "&quot; não está mais disponível.");
                endif;
            endforeach;
        endif;

        /* savar pedido de produtos */
        $itens_carrinho = $request->session()->get('items_cart') ?? [];

        $order = (new Order)->fill($request->all());

        $end_entrega = [
            'estado' => $order->estado,
            'cidade' => $order->cidade,
            'bairro' => $order->bairro,
            'rua' => $order->rua,
            'numero' => $order->numero,
            'cep' => $order->cep,
            'complemento' => $order->complemento,
        ];
        unset($order->estado, $order->cidade, $order->bairro, $order->rua, $order->numero, $order->cep, $order->complemento);

        $order->valor_troco = $order->valor_troco ? currency_to_decimal($order->valor_troco) : 0.00;
        $order->end_entrega = $end_entrega;
        $order->store_id = $store->id;
        $order->user_id = auth()->user()->id;
        // $order->data_order = json_encode(session('items_cart') ?? []);
        $order->data_order = session('items_cart') ?? [];
        $order->save();

        // salver código do item
        if (is_null($order->codigo)) :
            if (Order::where('codigo', $order->id)->exists() == false) :
                $order->codigo = $order->id;
                $order->save();
            else :
                $total = Order::count();
                for ($i = 0; $i <= 1000000; $i++) :
                    $total++;
                    if (Order::where('codigo', $total)->exists() == false) {
                        $order->codigo = $total;
                        $order->save();
                        break;
                    }
                endfor;
            endif;
        endif;

        $this->saveItemsOrder($itens_carrinho, $order->id, $slug_store);

        // salvar dados da pizza montada se tiver no carrinho
        $orderMontarPizza->savePIzzaOrder($order->id);
        $this->savePIzzaProductOrder($order->id);

        $this->updateStock();

        // limpar carrinho
        $request->session()->forget('items_cart');
        $request->session()->forget('items_cart_pizza');
        $request->session()->forget('items_cart_pizza_produto');

        // adicionar usuário como cliente da loja
        StoreHasCustomer::firstOrCreate([
            'store_id' => $store->id,
            'user_id' => auth()->user()->id
        ]);

        return redirect()
            ->route('cliente.pedidos-recentes', $slug_store)
            ->withSuccess('Pedido enviado com sucesso.');
    }

    /**
     * Salvar pedido da pizza produto
     *
     * @param  mixed $request
     * @return void
     */
    public function savePIzzaProductOrder($order_id)
    {
        $order = Order::find($order_id);
        $order->data_pizza_produto = session('items_cart_pizza_produto') ?? [];
        $order->save();
    }

    /**
     * View para adicionar produto ao carrinho
     *
     * @param  mixed $slug_store
     * @param  mixed $product
     * @return void
     */
    public function addProduct($slug_store, Product $product)
    {
        if ($product->ativo == 'N')
            abort(403);

        $store = Store::where('slug_url', $slug_store)->first();
        $categories = $this->getCategories($store);

        $product = Product::where('id', $product->id)->with('additional_has_products')->with('image')->first();
        $additionals = $this->getAdditionals($product);

        // remover produto adicional que não esteja ativo
        foreach ($additionals as $key => $additional) {
            if (Product::find($additional->additional_product_id) != null)
                if (Product::find($additional->additional_product_id)->ativo != 'S') {
                    unset($additionals[$key]);
                }

            if (Product::find($additional->additional_product_id) == null)
                unset($additionals[$key]);
        }

        // produtos relacionados
        $productsRelated = $this->getProducts($product, $store);

        return view('front.loja.produto.add_product', compact('store', 'product', 'categories', 'additionals', 'productsRelated'));
    }

    public function getProducts($productMain, Store $store): ?object
    {

        $products = $store->products()
            ->where('ativo', 'S')
            ->where('category_id', $productMain->category_id)
            ->where('id', '!=', $productMain->id)
            ->with(['image']);

        // remover item se for adicional e se a coluna 'item_adicional' é 'S'
        $arrayRemoveIds = [];
        foreach ($products->get(['id', 'tipo', 'item_adicional']) as $item) :
            if ($item->tipo == 'ADICIONAL' && $item->item_adicional == 'S') {
                $arrayRemoveIds[] = $item->id;
            }
        endforeach;
        $products->whereNotIn('id', $arrayRemoveIds);

        return $products->orderBy('ordem')->latest()->paginate(12);
    }

    /**
     * View para adicionar pizza ao carrinho
     *
     * @param  mixed $request
     * @param  mixed $slug_store
     * @param  mixed $product
     * @return void
     */
    public function addPizza(Request $request, $slug_store, Product $product)
    {
        $store = Store::where('slug_url', $slug_store)->first();

        if ($product->ativo == 'N')
            abort(403);

        $produto = Product::where('id', $product->id)->with('additional_has_products')->with('image')->first();
        $additionals = $this->getAdditionals($produto);
        $categories = $this->getCategories($store);

        // remover produto adicional que não esteja ativo
        foreach ($additionals as $key => $additional) {
            if (Product::find($additional->additional_product_id) != null)
                if (Product::find($additional->additional_product_id)->ativo != 'S') {
                    unset($additionals[$key]);
                }
        }

        // agrupar por grupo de adicionais
        $gruposAdicionais = array_reduce($additionals->toArray(), function ($resultado, $valor) {
            if (isset($valor['additional_product_grupo'])) {
                $cidade = $valor['additional_product_grupo'];
                if (!isset($resultado[$cidade])) {
                    $resultado[$cidade] = array();
                }
                $resultado[$cidade][] = $valor;
            }
            return $resultado;
        }, array());

        return view('front.loja.produto.add_pizza', compact('store', 'product', 'categories', 'additionals', 'gruposAdicionais'));
    }

    public function getCategories(Store $store): array
    {
        return (new StoreController)->getCategories($store);
    }

    /**
     * Adicionar item e seus adicionais ao carrinho
     *
     * @param  mixed $request
     * @param  mixed $slug_store
     * @return void
     */
    public function addCart(Request $request, $slug_store)
    {
        $product = Product::find($request->product_id);
        if (is_null($product)) // se produto existe
            return redirect()->route('loja.index', $slug_store)->withError('O Item foi removido');

        // validar quantidade mínima e máxima de adicionasi permitidos
        if ($request->has('additionals')) :
            $collectAdditionals = collect($request->additionals);
            $totalAdditionals = $collectAdditionals->where('qtd_adicional', '>', 0)->count();

            // se adicionais selecionados forem menor que o mínimo permitido no produto
            if ($product->adicional_qtde_min != null)
                if ($totalAdditionals < $product->adicional_qtde_min)
                    return redirect()
                        ->back()
                        ->withError("Você precisa selecionar pelo menos {$product->adicional_qtde_min} adicionais");

            // se adicionais selecionados forem maior que o máximo permitido no produto
            if ($product->adicional_qtde_max != null)
                if ($totalAdditionals > $product->adicional_qtde_max)
                    return redirect()
                        ->back()
                        ->withError("Você pode selecionar no máximo {$product->adicional_qtde_max} adicionais");

            // se item adicional é obrigatorio
            if ($product->item_adicional_obrigar == 'S' && $totalAdditionals == 0)
                return redirect()->back()->withError('Você precisa selecionar um item adicional');
        endif;

        $store = Store::where('slug_url', $slug_store)->first();
        $addCart = (new AddCart())->fill($request->all());

        // permitir add ao cart apenas se a empresa estiver aberta
        if ($store->empresa_aberta == 'nao')
            return redirect()->back()->with('abrir_modal_loja_fechada', true);

        $item_cart = $this->itemData($addCart);

        if ($request->session()->has('items_cart')) :
            $request->session()->push('items_cart', $item_cart);
        else :
            $items_cart = [];
            $request->session()->put('items_cart', $items_cart);
            $request->session()->push('items_cart', $item_cart);
        endif;



        return redirect()->route('loja.index', $slug_store);
    }

    /**
     * remvover todos os itens do carrinho
     *
     * @param  mixed $request
     * @param  mixed $slug_store
     * @return void
     */
    public function rem_cart(Request $request, $slug_store)
    {
        $store = Store::where('slug_url', $slug_store)->first();
        $request->session()->forget('items_cart');
    }

    /**
     * Retorna os dados do item obtidos no banco de dados para adicionar ao carrinho
     *
     * @param  mixed $item_cart Item que está sendo adicionado ao carrinho
     * @return void
     */
    public function itemData($item_cart)
    {
        $item = [];
        $product = Product::where('id', $item_cart['product_id'])->with('image')->first();
        $item['product_id'] = $item_cart['product_id'];
        $item['product_foto'] = $product->image ? $product->image->foto : '';
        $item['product_nome'] = $product->nome;
        $item['product_preco'] = $product->valor;
        $item['product_descricao'] = $product->descricao;
        $item['product_tipo'] = $product->tipo;
        $item['product_observacao'] = $item_cart['observacao'];
        $item['qtd_item'] = $item_cart['qtd_item'];
        $item['vl_item'] = $product->valor * $item_cart['qtd_item'];

        if ($item_cart['additionals']) {
            foreach ($item_cart['additionals'] as $key => $additional) {
                if ($additional['qtd_adicional'] > 0) {
                    $product = Product::where('id', $additional['id'])->first();
                    $grupo = AdditionalGroup::where('id', $product->grupo_adicional_id)->first();
                    $item['additionals'][$key]['additional_id'] = $product->id;
                    $item['additionals'][$key]['additional_nome'] = $product->nome;
                    $item['additionals'][$key]['additional_descricao'] = $product->descricao;
                    $item['additionals'][$key]['additional_preco'] = $product->valor;
                    $item['additionals'][$key]['additional_grupo'] = $grupo->nome;
                    $item['additionals'][$key]['qtd_item'] = $additional['qtd_adicional'];
                    $vl_additional = ($item['additionals'][$key]['additional_preco'] * $additional['qtd_adicional']) * $item_cart['qtd_item'];

                    $item['vl_item'] = $item['vl_item'] + $vl_additional;
                }
            }
        }
        return $item;
    }

    /**
     * Salva o item produto no bando de dados em 'order_items'
     *
     * @param  mixed $itens_carrinho
     * @param  mixed $order_id
     * @param  mixed $slug_store
     * @return void
     */
    public function saveItemsOrder($itens_carrinho, $order_id, $slug_store)
    {
        $store = Store::where('slug_url', $slug_store)->first();

        foreach ($itens_carrinho as $item) {
            $order_items = new OrderItems();
            $order_items->order_id = $order_id;
            $order_items->product_id = $item['product_id'];
            $order_items->quantidade = $item['qtd_item'];
            $order_items->obs_produto = $item['product_observacao'];
            $order_items->valor_item_pedido = Product::find($item['product_id'])->valor;
            $order_items->store_id = $store->id;
            $order_items->save();

            if (!empty($item['additionals'])) {
                $this->saveAdditionalsItems($item['additionals'], $order_id, $item['product_id'], $order_items->id, $store->id);
            }
        }
    }

    /**
     * Salvar o adicional no banco de dados em 'additionals_items'
     *
     * @param  mixed $additionals
     * @param  mixed $order_id
     * @param  mixed $product_id
     * @param  mixed $order_item_id
     * @param  mixed $store_id
     * @return void
     */
    public function saveAdditionalsItems($additionals, $order_id, $product_id, $order_item_id, $store_id)
    {
        foreach ($additionals as $item) {
            $additional_items = new AdditionalItems();
            $additional_items->order_id = $order_id;
            $additional_items->product_id = $product_id;
            $additional_items->order_item_id = $order_item_id;
            $additional_items->quantidade = $item['qtd_item'];
            $additional_items->additional_id = $item['additional_id'];
            $additional_items->valor_adicional_pedido = Product::find($item['additional_id'])->valor;
            $additional_items->store_id = $store_id;
            $additional_items->save();
        }
    }

    public function orderSummary($slug_store)
    {

        // se algum item foi excluido pelo lojista, o carrinho será resetado e redirecionado com msg de erro para page anterior
        $return = $this->checkProductAndAdditionalsDeleted();
        if ($return)
            return $return;

        // session()->forget('items_cart');
        $store = Store::where('slug_url', $slug_store)->first();
        $items_cart = session('items_cart') ?? [];
        $qtd_itens = count($items_cart);
        $soma_pedido = array_column($items_cart, 'vl_item');
        $soma_pedido = array_sum($soma_pedido);
        $session = [
            'itens' => $items_cart,
            'qtd_itens' => $qtd_itens,
            'soma_pedido' => $soma_pedido
        ];

        return view('front.loja.realizar_pedido.resumo_pedido', compact('store', 'session'));
    }

    public function removePizzaProductCart($slug_store, $item_key_session)
    {
        $items = session('items_cart_pizza_produto') ?? [];
        if (count($items) > 0) {
            foreach ($items as $key => $item) {
                if ($key == $item_key_session) {
                    unset($items[$key]);
                    session()->put('items_cart_pizza_produto', $items);
                    return redirect()->back()->withSuccess('Item removido com sucesso');
                }
            }
        }
        return redirect()->back()->withError('Item não encontrado');
    }

    public function checkProductAndAdditionalsDeleted()
    {
        if (session()->has('items_cart')) :
            $itemsCart = session('items_cart') ?? [];

            foreach ($itemsCart as $keyItem => $item) :
                $product = Product::find($item['product_id']);

                if (is_null($product)) : //remover produto se não existe
                    session()->forget('items_cart'); // remover itens do carrinho se algum produto foi removido
                    return redirect()->back()->withError('Algum item foi removido, por favor tente novamente');
                endif;

                // adicionais
                if (isset($item['additionals']) && count($item['additionals']) > 0) :
                    foreach ($item['additionals'] as $keyAdditional => $additional) {
                        $productAdditional = Product::find($additional['additional_id']);
                        if (is_null($productAdditional)) : //remover adicional se não existe
                            session()->forget('items_cart'); // remover itens do carrinho se algum adicional foi removido
                            return redirect()->back()->withError('Algum item foi removido, por favor tente novamente');
                        endif;
                    }
                endif;
            endforeach;
        endif;

        return false;
    }

    public function removeItemCart($slug_store, $item_key_session)
    {
        $items = session('items_cart') ?? [];
        if (count($items) > 0) {
            foreach ($items as $key => $item) {
                if ($key == $item_key_session) {
                    unset($items[$key]);
                    session()->put('items_cart', $items);
                    return redirect()->back()->withSuccess('Item removido com sucesso');
                }
            }
        }
        return redirect()->back()->withError('Item não encontrado');
    }

    private function getAdditionals($product)
    {
        $additionals = $product->additional_has_products;
        foreach ($additionals as $additional) {
            $produto = Product::where('id', $additional->additional_product_id)->with('image')->first();

            if (is_null($produto))
                continue;

            $grupo = AdditionalGroup::where('id', $produto->grupo_adicional_id)->first();
            $additional->additional_product_nome = $produto->nome;
            $additional->additional_product_descricao = $produto->descricao;
            $additional->additional_product_valor = $produto->valor;
            $additional->additional_product_estoque = $produto->estoque;
            if (isset($grupo->nome))
                $additional->additional_product_grupo = $grupo->nome;
            if (isset($produto->image->foto))
                $additional->additional_product_foto = $produto->image->foto;
            if (isset($grupo->adicional_qtd_min))
                $additional->additional_product_qtd_min = $grupo->adicional_qtd_min;
            if (isset($grupo->adicional_qtd_max))
                $additional->additional_product_qtd_max = $grupo->adicional_qtd_max;
        }
        return $additionals;
    }

    public function redirectConfig()
    {
        return redirect()
            ->route('painel.lojista.configuracoes')
            ->withErro('Você precisa adicionar os dados da sua loja antes de adicionar categorias.');
    }

    /**
     * verificar estoque de produtos e adicionais se está disponível para realizar o pedido
     *
     * @param  mixed $slug_store
     * @return void
     */
    public function checkStock($slug_store)
    {
        $itemsCart = session('items_cart') ?? [];

        foreach ($itemsCart as $item) :
            $product = Product::find($item['product_id']);

            if (is_null($product) || $product->ativo == 'N') : // se o produto foi removido ou não ativo, vai limpar todo o carrinho
                session()->forget('items_cart');
                return [
                    'erro' => true,
                    'redirect' => redirect()->route('loja.index', $slug_store)
                        ->withError("Um produto selecionado foi desativado, tente novamente.")
                ];
            endif;

            // se estoque é menor que a quantidade do pedido
            if ($this->totalQtdItemCarrinho($item['product_id']) > $product->estoque && $product->limitar_estoque == 'S') :
                return [
                    'erro' => true,
                    'redirect' => redirect()
                        ->route('cliente.resumo-pedido', $slug_store)
                        ->withError("O item \"{$product->nome}\" tem {$product->estoque} em estoque")
                ];
            endif;

            // adicionais
            if (isset($item['additionals']) && count($item['additionals']) > 0) :
                foreach ($item['additionals'] as $additional) :
                    $productAdditional = Product::find($additional['additional_id']);
                    if (is_null($productAdditional) || $productAdditional->ativo == 'N') : // se o produto foi removido ou não ativo, vai limpar todo o carrinho
                        session()->forget('items_cart');
                        return [
                            'erro' => true,
                            'redirect' => redirect()->route('loja.index', $slug_store)
                                ->withError("Um adicional selecionado foi desativado, tente novamente.")
                        ];
                    endif;

                    if ($this->totalQtdItemCarrinho($additional['additional_id']) > $productAdditional->estoque && $productAdditional->limitar_estoque == 'S') :
                        return [
                            'erro' => true,
                            'redirect' => redirect()
                                ->route('cliente.resumo-pedido', $slug_store)
                                ->withError("O adicional \"{$productAdditional->nome}\" tem {$productAdditional->estoque} em estoque")
                        ];
                    endif;
                endforeach;
            endif;
        endforeach;

        return ['erro' => false];
    }

    /**
     * Atualizar estoque de produtos e adicionais
     *
     * @return void
     */
    public function updateStock()
    {
        $itemsCart = session('items_cart') ?? [];

        foreach ($itemsCart as $item) {
            // atualizar estoque
            $product = Product::find($item['product_id']);
            $product->estoque = $product->estoque - $item['qtd_item'];
            if ($product->estoque < 0)
                $product->estoque = 0;
            $product->save();

            // adicionais
            if (isset($item['additionals']) && count($item['additionals']) > 0) :
                foreach ($item['additionals'] as $additional) {
                    // atualizar estoque
                    $productAdditional = Product::find($additional['additional_id']);
                    $productAdditional->estoque = $productAdditional->estoque - $additional['qtd_item'];
                    if ($productAdditional->estoque < 0)
                        $productAdditional->estoque = 0;
                    $productAdditional->save();
                }
            endif;
        }
    }

    /**
     * Ober tota de items no carrinho de um determinado produto
     *
     * @param  mixed $produto_id
     * @return void
     */
    public function totalQtdItemCarrinho($produto_id)
    {
        $total = 0;
        if (session()->has('items_cart')) :
            $itens = session('items_cart') ?? [];
            foreach ($itens as $keyItem => $item) {

                // se item estiver no carrinho vai subtrar o valor do estoque
                if ($item['product_id'] == $produto_id) {
                    $total += intval($item['qtd_item']);
                }

                if (isset($item['additionals'])) {
                    $adicionais = $item['additionals'];
                    foreach ($adicionais as $keyAd => $ad) {
                        // se adicional estiver no carrinho vai subtrar o valor do estoque
                        if ($ad['additional_id'] == $produto_id) {
                            $total += intval($ad['qtd_item']);
                        }
                    }
                }
            }
        endif;

        return $total;
    }
}
