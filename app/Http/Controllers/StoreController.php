<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\PromotionalBanner;

class StoreController extends Controller
{
    public function __construct()
    {
        $this->middleware(['verify-shopkeeper-disabled'], ['except' => ['storeDisabled']]);
    }

    public function home(Request $request, $slug_store = null, Product $product)
    {
        $store = Store::where('slug_url', $slug_store)->first();


        if (is_null($store))
            return abort(404);

        $products = $this->getProducts($request, $store);
        $categories = $this->getCategories($store);
        $additionals = Product::where('store_id', $store->id)->where('tipo', 'ADICIONAL')->get();
        $banners=PromotionalBanner::where('store_id', $store->id)->get();

          $categorias=Category::all();
        foreach ($products as $productt) {
            $productt->additionals = $additionals;
        }
        if ($product->ativo == 'N')
            abort(403);

        $store = Store::where('slug_url', $slug_store)->first();
        $categories = $this->getCategories($store);

        $product = Product::where('id', $product->id)->with('additional_has_products')->with('image')->first();





        return view('front.loja.home', compact('store', 'products', 'categories','banners','categorias', 'product'));

    }

    public function redirectToHome($slug_store = null)
    {
        return redirect()->route('loja.index', $slug_store);
    }

    public function storeDisabled($slug_store)
    {
        return response()->view('front.loja.loja_desativada', ['error' => 404], 404);
    }

    public function getCategories(Store $store): array
    {
        $dataCategories = [];
        foreach ($store->categories as $cate) { //gambiarra pra ordenar categoria por total de produtos
            $dataCategories[] = [
                $cate->products()->count(), // total de produtos
                'nome' => $cate->nome,
                'slug' => $cate->slug,
                'codigo'=>$cate->id,
                'foto'=>$cate->foto,
            ];
        }
        rsort($dataCategories); //ordenar categoria por total de produtos

        return $dataCategories;
    }

    public function getProducts(Request $request, Store $store): ?object
    {
        $products = $store->products()
            ->where('ativo', 'S')
            ->with(['image']);

        // remover item se for adicional e se a coluna 'item_adicional' é 'S'
        $arrayRemoveIds = [];
        foreach ($products->get(['id', 'tipo', 'item_adicional']) as $item) :
            if ($item->tipo == 'ADICIONAL' && $item->item_adicional == 'S') {
                $arrayRemoveIds[] = $item->id;
            }
        endforeach;
        $products->whereNotIn('id', $arrayRemoveIds);

        if ($request->has('s')) //pesquisa
            $products = $this->searchProduct($products, $request['s']);

        return $products->orderBy('ordem')->latest()->paginate(12);
    }

    public function searchProduct($products, String $value): ?object
    {
        $strSearchArr = explode(' ', " $value ");
        $strSearch =  implode('%', $strSearchArr);
        $products->where('nome', 'like', $strSearch)->orWhereHas('category', function ($query) use ($strSearch) {
            return $query->where('nome', 'like', $strSearch);
        });

        return $products;
    }
}
