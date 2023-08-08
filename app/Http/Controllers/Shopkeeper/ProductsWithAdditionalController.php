<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\AdditionalGroup;
use App\Http\Controllers\Controller;
use App\Models\AdditionalHasProducts;
use App\Http\Requests\ProductsWithAdditionalRequest;

class ProductsWithAdditionalController extends Controller
{
    public function index()
    {
        if (is_null(auth()->user()->store_has_user))
            return $this->redirectConfig();

        $store_id = auth()->user()->store_has_user->store->id;
        $products = Product::where('store_id', $store_id)->has('additional_has_products')->latest()->paginate(12);

        return view('painel.lojista.produtos.produtos_com_adicionais.index', compact('products'));
    }

    public function create()
    {
        return view('painel.lojista.produtos.produtos_com_adicionais.create');
    }

    public function store(ProductsWithAdditionalRequest $request)
    {
        $product = Product::find($request->product_id);

        // bloquear modificação se o produto não for da mesmo loja que o usuário
        if (auth()->user()->store_has_user->store->id != $product->store_id)
            abort(403);

        AdditionalHasProducts::where('product_id', $request->product_id)->delete();
        foreach ($request->adicionais_id as $key => $adicional_id) {
            AdditionalHasProducts::firstOrCreate([
                'product_id' => $request->product_id,
                'additional_product_id' => $adicional_id,
                'store_id' => auth()->user()->store_has_user->store->id
            ]);
        }

        return redirect()
            ->route('painel.lojista.produtos-com-adicionais.index')
            ->withSuccess('Produto com adicionais foi gravado com sucesso');
    }

    /**
     * Obter json de produtos
     *
     * @param  mixed $request
     * @return void
     */
    public function jsonProductList(Request $request)
    {
        $this->authorize('adicionar produtos');
        $store_id = auth()->user()->store_has_user->store->id;

        $data = [];
        if ($request->has('q')) :
            $str_filter = "%" . implode('%', explode(' ', $request->q)) . "%";
            $data = Product::where('store_id', $store_id)
                ->where('tipo', '!=', 'ADICIONAL')
                ->where('nome', 'like', $str_filter)
                ->where('ativo', 'S')
                ->limit(30)
                ->orderBy('nome')
                ->get();
        else :
            $data = Product::where('store_id', $store_id)
                ->where('tipo', '!=', 'ADICIONAL')
                ->where('ativo', 'S')
                ->limit(30)
                ->orderBy('nome')
                ->get();
        endif;

        return response()->json($data);
    }

    /**
     * Obter json de adicionais
     *
     * @param  mixed $request
     * @return void
     */
    public function jsonAdditionalList(Request $request)
    {
        $this->authorize('adicionar produtos');

        $store_id = auth()->user()->store_has_user->store->id;
        $grupoAdicionalId = $request->grupo_adicional_id;

        $data = [];
        if ($request->has('q')) :

            $str_filter = "%" . implode('%', explode(' ', $request->q)) . "%";
            $data = Product::where('store_id', $store_id)
                ->where('tipo', 'ADICIONAL')
                ->where('ativo', 'S')
                ->whereHas('additional_group', function ($query) use ($grupoAdicionalId) {
                    return $query->where('id', $grupoAdicionalId);
                })
                ->where('nome', 'like', $str_filter)
                ->limit(30)
                ->orderBy('nome')
                ->get();
        else :
            $data = Product::where('store_id', $store_id)
                ->where('tipo', 'ADICIONAL')
                ->where('ativo', 'S')
                ->whereHas('additional_group', function ($query) use ($grupoAdicionalId) {
                    return $query->where('id', $grupoAdicionalId);
                })
                ->limit(30)
                ->orderBy('nome')
                ->get();
        endif;

        return response()->json($data);
    }

    /**
     * Obter json de grupos de adicionais
     *
     * @param  mixed $request
     * @return void
     */
    public function jsonAdditionalGroupList(Request $request)
    {
        $this->authorize('adicionar produtos');

        $store_id = auth()->user()->store_has_user->store->id;

        $data = [];
        if ($request->has('q')) :
            $str_filter = "%" . implode('%', explode(' ', $request->q)) . "%";
            $data = AdditionalGroup::where('store_id', $store_id)
                ->where('nome', 'like', $str_filter)
                ->limit(30)
                ->orderBy('nome')
                ->get();
        else :
            $data = AdditionalGroup::where('store_id', $store_id)->orderBy('nome')->get();
        endif;

        return response()->json($data);
    }

    public function redirectConfig()
    {
        return redirect()
            ->route('painel.lojista.configuracoes')
            ->withErro('Você precisa adicionar os dados da sua loja antes de adicionar categorias.');
    }

    public function removeAdditionals(Product $product)
    {
        // bloquear modificação se o produto não for da mesmo loja que o usuário
        if (auth()->user()->store_has_user->store->id != $product->store_id)
            abort(403);

        AdditionalHasProducts::where('product_id', $product->id)->delete();
        return redirect()->back()->withSuccess('Adicionais removidos do item selecionado');
    }
}
