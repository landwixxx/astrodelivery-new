<?php

namespace App\Http\Controllers\Customer;

use App\Models\Store;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AssemblePizzaProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth_customer'])->except([
            'createOrder',
            'index',
        ]);
    }

    public function index(Request $request, $slug_store, Product $product)
    {
        // session()->forget('items_cart_pizza_produto');
        $store = Store::where('slug_url', $slug_store)->first();
        $max_sabores = $product->pizza_product->qtd_max_sabores;
        $min_sabores = $product->pizza_product->qtd_min_sabores;
        return view('front.loja.montar_pizza_produto.index', compact('store', 'product', 'max_sabores', 'min_sabores'));
    }

    public function createOrder(Request $request, $slug_store, Product $product)
    {
        $request->validate([
            'json_sabores.0' => ['required'],
            'json_bordas.0' => ['required'],
            'bordas_key.0' => ['required'],
        ]);

        $dataCart = [
            'produtos_codigo' => $product->codigo,
            'pedido_codigo' => null,
            'valor_produto' => $product->valor,
            'nome' => $product->nome,
            'descricao' => $product->descricao,
            'produto_id' => $product->id,
            'sabores' => [],
            'bordas' => [],
            'valor_total' => floatval($product->valor),
            'obs' => $request->observacao
        ];


        // Organizar sabores
        $totalSabores = count($request->json_sabores);
        foreach ($request->json_sabores as $key => $value) {
            $saborObj = json_decode($value);
            $valorSabor = $saborObj->valor / $totalSabores;
            $saborArray = [
                'sabor' => $saborObj->sabor,
                'descricao' => $saborObj->descricao,
                'valor' => $valorSabor,
                'imagem' => $saborObj->imagem,
            ];
            array_push($dataCart['sabores'], $saborArray);
            $dataCart['valor_total'] += $valorSabor;
        }

        // Organizar botrdas
        $totalBordas = count($request->bordas_key);
        foreach ($request->json_bordas as $key => $value) {
            $bordaObj = json_decode($value);
            $valorBorda = $bordaObj->valor / $totalBordas;
            $bordaArray = [
                'borda' => $bordaObj->borda,
                'descricao' => $bordaObj->descricao,
                'valor' => $valorBorda,
                'imagem' => $bordaObj->imagem,
            ];
            if (in_array($key, $request->bordas_key)) {
                array_push($dataCart['bordas'], $bordaArray);
                $dataCart['valor_total'] += $valorBorda;
            }
        }
        $sessionCartPizza = session('items_cart_pizza_produto') ?? [];
        array_push($sessionCartPizza, $dataCart);
        $request->session()->put('items_cart_pizza_produto', $sessionCartPizza);

        return redirect()->route('loja.index', $slug_store);
    }
}
