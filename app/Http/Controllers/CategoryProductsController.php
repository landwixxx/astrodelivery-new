<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['verify-shopkeeper-disabled']);
    }

    public function index($slug_store, $slug_category)
    {
        $store = Store::where('slug_url', $slug_store)->first();
        $category = Category::where('store_id', $store->id)->where('slug', $slug_category)->first();
        if (is_null($category))
            return redirect()->route('loja.index', $slug_store)->withError('Categoria não encontrada');

        $data = [
            'store' => $store,
            'category' => $category,
            'products' => $this->getProducts($store, $slug_category),
            'categories' => $this->getCategories($store),
        ];

        return view('front.loja.categorias.index', $data);
    }

    public function getCategories(Store $store): array
    {
        $dataCategories = [];
        foreach ($store->categories as $cate) { //gambiarra pra ordenar categoria por total de produtos
            $dataCategories[] = [
                $cate->products()->count(), // total de produtos
                'nome' => $cate->nome,
                'slug' => $cate->slug,
            ];
        }
        rsort($dataCategories); //ordenar categoria por total de produtos

        return $dataCategories;
    }

    public function getProducts(Store $store, String $slug_category): ?object
    {
        $products = $store
            ->categories()
            ->where('slug', $slug_category)
            ->first()
            ->products()
            ->where('ativo', 'S')
            ->with('image');

        // remover item se for adicional e se a coluna 'item_adicional' é 'S'
        $arrayRemoveIds = [];
        foreach ($products->get(['id', 'tipo', 'item_adicional']) as $item) :
            if ($item->tipo == 'ADICIONAL' && $item->item_adicional == 'S') {
                $arrayRemoveIds[] = $item->id;
            }
        endforeach;
        $products->whereNotIn('id', $arrayRemoveIds);

        return $products->orderBy('ordem')->latest()->paginate(5);
    }
}
