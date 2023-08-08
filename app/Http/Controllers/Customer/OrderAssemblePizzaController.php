<?php

namespace App\Http\Controllers\Customer;

use App\Models\Edge;
use App\Models\Size;
use App\Models\Order;
use App\Models\Store;
use App\Models\Flavor;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderAssemblePizzaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth_customer']);
    }

    /**
     * Preparando dados para add ao carrinho
     *
     * @param  mixed $slug_store
     * @param  mixed $request
     * @return void
     */
    public function createOrder($slug_store, Request $request)
    {
        $data = [
            'tamanho' => null,
            'sabores' => [],
            'bordas' => [],
            'adicionais' => [],
            'valor_total' => $this->totalValuePizza($slug_store)
        ];

        if (session('tamanho_id')) :
            $data['tamanho'] = $this->getDataSize();
        else :
            return redirect()
                ->route('loja.montar-pizza.tamanhos', ['slug_store' => $slug_store])
                ->withError('Selecione o tamanho');
        endif;

        // Sabores
        if (!is_null(session('sabores_id'))) :
            $data['sabores'] = $this->getDataFlavors();
        else :
            return redirect()
                ->route('loja.montar-pizza.sabores', ['slug_store' => $slug_store])
                ->withError('Selecione o sabor');
        endif;

        // Bordas
        if (!is_null(session('bordas_id'))) :
            $data['bordas'] = $this->getDataEdge();
        else :
            return redirect()
                ->route('loja.montar-pizza.bordas', ['slug_store' => $slug_store])
                ->withError('Selecione a borda');
        endif;

        // Adicionais
        $data['adicionais'] = $this->getDataAdditionals();

        // add dados no carrinho
        if (session('items_cart_pizza')) :
            $dataCart = session('items_cart_pizza');
            array_push($dataCart, $data);
        else :
            $dataCart = [$data];
        endif;
        $request->session()->put('items_cart_pizza', $dataCart);

        session()->forget('sabores_id');
        session()->forget('bordas_id');
        session()->forget('tamanho_id');
        session()->forget('adicionais');

        return redirect()->route('loja.index', $slug_store);
    }

    public function getDataSize()
    {
        $size = Size::find(session('tamanho_id'));
        $tamanho = [
            'nome' => $size->tamanho,
            'valor' => $size->valor,
            'max_sabores' => $size->max_sabores,
        ];
        return $tamanho;
    }

    public function getDataFlavors()
    {
        $data = [];
        foreach (session('sabores_id') ?? [] as $key => $sabor_id) :
            $sabor = Flavor::find($sabor_id);
            if (!is_null($sabor)) :
                $data[] = [
                    'id' => $sabor->id,
                    'nome' => $sabor->sabor,
                    'descricao' => Str::limit($sabor->descricao, 90),
                    'img' => asset($sabor->img ?? 'assets/img/pizza/pizza-empty.png'),
                    'valor' => $sabor->valor / count(session('sabores_id') ?? [1]),
                ];
            endif;
        endforeach;

        return $data;
    }

    public function getDataEdge()
    {
        $data = [];
        foreach (session('bordas_id') ?? [] as $key => $borda_id) :
            $borda = Edge::find($borda_id);
            if (!is_null($borda)) :
                $data[] = [
                    'id' => $borda->id,
                    'nome' => $borda->borda,
                    'descricao' => Str::limit($borda->descricao, 90),
                    'img' => asset($borda->img ?? 'assets/img/pizza/pizza-empty.png'),
                    'valor' => $borda->valor / (count(session('bordas_id') ?? [1]))
                ];
            endif;
        endforeach;
        return $data;
    }

    public function getDataAdditionals()
    {
        $data = [];
        if (isset(session('adicionais')['itens'])) :
            foreach (session('adicionais')['itens'] as $key => $item) :
                $adicional = Product::find($item['id']);
                if (!is_null($adicional)) :
                    $data[] = [
                        'id' => $adicional->id,
                        'nome' => $adicional->nome,
                        'img' => $adicional->img_destaque,
                        'descricao' => Str::limit($adicional->descricao, 90),
                        'qtd' => $item['qtd'],
                        'valor' => ($item['qtd'] * $adicional->valor),
                    ];
                endif;
            endforeach;
        endif;

        return $data;
    }

    public function totalValuePizza($slug_store)
    {
        $tamanho = Size::find(session('tamanho_id'));

        $valorBordas = \App\Models\Edge::whereIn('id', session('bordas_id') ?? [])->sum('valor');
        $valorBordas = $valorBordas / count(session('bordas_id') ?? [0]);

        $valorSabores = Flavor::whereIn('id', session('sabores_id'))->sum('valor');
        $valorSabores = $valorSabores / count(session('sabores_id') ?? [1]);

        $adicionais = [];
        $totalValorAdicionais = 0;
        // se existe adicionais
        if (isset(session('adicionais')['itens']) && count(session('adicionais')['itens']) > 0) :
            foreach (session('adicionais')['itens'] as $key => $item) :
                $produto = Product::find($item['id']);
                // se o adicional produto foi removido enquanto esta no carrinho
                if (is_null($produto)) :
                    return redirect()->route('loja.montar-pizza.adicionais', ['slug_store' => $slug_store])->withError('Ouve uma alteração nos adicionais');
                endif;
                $adicionais[] = [
                    'id' => $item['id'],
                    'qtd' => $item['qtd'],
                    'produto' => $produto
                ];

                $totalValorAdicionais += $item['qtd'] * $produto->valor;
            endforeach;
        endif;

        $valorTotalPizza = $totalValorAdicionais + $valorBordas  + $valorSabores + $tamanho->valor;

        return $valorTotalPizza;
    }

    public function verificarAdicionalMontarPizza($slug_store)
    {

        // dd(session())

        $itensCartPizza = session('items_cart_pizza') ?? [];


        if (count($itensCartPizza) > 0) :
            foreach ($itensCartPizza as $keyItem => $item) :
                $adicionais = $item['adicionais'];
                if (count($adicionais) > 0) :
                    foreach ($adicionais as $keyAd => $adicional) :
                        $produto = Product::find($adicional['id']);

                        // dd($produto->toArray());

                        //  verificar se está disponível
                        if (is_null($produto) || isset($produto->ativo) && $produto->ativo == 'N') :
                            // remover adicional
                            unset($itensCartPizza[$keyItem]['adicionais'][$keyAd]);

                            // atualizar valor total
                            $itensCartPizza[$keyItem]['valor_total'] -= $adicional['valor'];

                            // atualizar a session
                            session()->put('items_cart_pizza', $itensCartPizza);
                            return [
                                'erro' => true,
                                'redirect' => redirect()
                                    ->route('cliente.resumo-pedido', $slug_store)
                                    ->with('nao_disponivel', "O adicional <strong>&quot;" . $adicional['nome'] . "&quot;</strong> não está mais disponível"),
                            ];
                        endif;

                        // verificar se estoque está disponível
                        if ($produto->limitar_estoque == 'S' && $adicional['qtd'] > $produto->estoque) :

                            if ($produto->estoque == 0) : //remover se for 0
                                // remover adicional
                                unset($itensCartPizza[$keyItem]['adicionais'][$keyAd]);
                                // atualizar valor total
                                $itensCartPizza[$keyItem]['valor_total'] -= $adicional['valor'];
                            else : // fazer novo calculo se tiver em estoque
                                $itensCartPizza[$keyItem]['valor_total'] -= $adicional['valor'];

                                // atualizar novo valor 
                                $itensCartPizza[$keyItem]['valor_total'] += ($produto->estoque * $produto->valor);
                                // atualizar novo estoque
                                $itensCartPizza[$keyItem]['adicionais'][$keyAd]['qtd'] = $produto->estoque;
                                $itensCartPizza[$keyItem]['adicionais'][$keyAd]['valor'] = ($produto->estoque * $produto->valor);

                            // vou fazer o teste e ver se o novo calculo para o dicional está correto,
                            // se tiver menos adicionais que o do pedido refaz o calculo
                            endif;

                            // atualizar a session
                            session()->put('items_cart_pizza', $itensCartPizza);
                            return [
                                'erro' => true,
                                'redirect' => redirect()
                                    ->route('cliente.resumo-pedido', $slug_store)
                                    ->with('nao_disponivel', "O adicional <strong>&quot;" . $adicional['nome'] . "&quot;</strong> tem {$produto->estoque} em estoque"),
                            ];
                        endif;

                    endforeach;;
                endif;
            endforeach;
        endif;

        return ['erro' => false];
    }

    /**
     * Armazenar dados do pedido no banco de dados
     *
     * @param  mixed $request
     * @return void
     */
    public function savePIzzaOrder($order_id)
    {
        $this->updateStockAdditionals();

        $order = Order::find($order_id);
        $order->data_montar_pizza = session('items_cart_pizza') ?? [];
        $order->save();
    }

    public function updateStockAdditionals()
    {
        $itemsCart = session('items_cart_pizza') ?? [];
        foreach ($itemsCart as $item) :
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
     * Remover pizza do carrinho
     *
     * @param  mixed $index Indice no array da session para ser removido
     * @return void
     */
    public function removerPizzaCard($slug_store, $index)
    {
        $data = session('items_cart_pizza');
        unset($data[$index]);
        session()->put('items_cart_pizza', $data);
        return redirect()->back()->withSuccess('Item removido com sucesso');
    }
}
