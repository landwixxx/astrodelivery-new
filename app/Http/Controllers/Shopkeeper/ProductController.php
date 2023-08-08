<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Models\Image;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\AdditionalGroup;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:lojista|funcionario', 'can:visualizar produtos']);
    }

    public function index(Request $request)
    {
        if (is_null(auth()->user()->store_has_user))
            return $this->redirectConfig();
        $store_id = auth()->user()->store_has_user->store->id;
        $products = Product::where('store_id', $store_id)->with('category')->with('image');
        if ($request->has('v')) :
            $products->where('nome', 'like', '%' . $request->v . '%');
        endif;

        $products = $products->latest()->paginate(10);

        $all_products = Product::where('store_id', $store_id)->orderby('nome')->get();
        return view('painel.lojista.produtos.index', compact('products', 'all_products'));
    }

    public function create()
    {
        $this->authorize('adicionar produtos');
        if (is_null(auth()->user()->store_has_user))
            return $this->redirectConfig();
        $store_id = auth()->user()->store_has_user->store->id;

        $categories = Category::where('store_id', $store_id)->orderBy('nome')->get();
        $additional_groups = AdditionalGroup::where('store_id', $store_id)->orderBy('nome')->get();

        return view('painel.lojista.produtos.create', compact('categories', 'additional_groups'));
    }

    public function store(ProductStoreRequest $request)
    {
        $this->authorize('adicionar produtos');

        if (is_null(auth()->user()->store_has_user))
            return $this->redirectConfig();

        $product = (new Product)->fill($request->all());
        $product->valor_original = currency_to_decimal($product->valor_original);
        $product->valor = currency_to_decimal($product->valor);
        $product->ordem = is_null($request->ordem) ? 1 : $request->ordem;
        $product->store_id = auth()->user()->store_has_user->store->id;
        $product->save();

        // salver código do item
        if (is_null($product->codigo)) :
            if (Product::where('codigo', $product->id)->exists() == false) :
                $product->codigo = $product->id;
                $product->save();
            else :
                $total = Product::count();
                for ($i = 0; $i <= 1000000; $i++) :
                    $total++;
                    if (Product::where('codigo', $total)->exists() == false) {
                        $product->codigo = $total;
                        $product->save();
                        break;
                    }
                endfor;
            endif;
        endif;

        if ($request->hasFile('imagem_prod'))
            $this->saveImagesProduct($request, $product->id, $product->store_id);

        return redirect()->route('painel.lojista.produtos.index')->withSuccess('Produto adicionado com sucesso');
    }

    public function show(Product $produto)
    {
        $this->authorize('visualizar produtos');

        if (is_null(auth()->user()->store_has_user))
            return $this->redirectConfig();

        if (auth()->user()->store_has_user->store->id != $produto->store_id)
            abort(403);

        return view("painel.lojista.produtos.show", compact('produto'));
    }

    public function edit($produto)
    {
        $this->authorize('editar produtos');
        if (is_null(auth()->user()->store_has_user))
            return $this->redirectConfig();

        $product = Product::where('id', $produto)->with('category')->with('image')->with('additional_group')->first();

        if (auth()->user()->store_has_user->store->id != $product->store_id)
            abort(403);

        $store_id = auth()->user()->store_has_user->store->id;
        $categories = Category::where('store_id', $store_id)->orderBy('nome')->get();
        $additional_groups = AdditionalGroup::where('store_id', $store_id)->orderBy('nome')->get();

        return view("painel.lojista.produtos.edit", compact('product', 'categories', 'additional_groups'));
    }

    public function update(ProductUpdateRequest $request, Product $produto)
    {
        $this->authorize('editar produtos');
        if (is_null(auth()->user()->store_has_user))
            return $this->redirectConfig();

        $store_id = auth()->user()->store_has_user->store->id;

        if ($store_id != $produto->store_id)
            abort(403);

        $produto->fill($request->all());
        $produto->ordem = is_null($request->ordem) ? 1 : $request->ordem;
        $produto->save();

        // Remover imagens
        if ($request->has('imgs_removidas_id'))
            foreach ($request->imgs_removidas_id as $key => $image_id) {
                Image::where('product_id', $produto->id)->where('id', $image_id)->delete();
            }

        // salvar imagem
        $this->saveImagesProduct($request, $produto->id, $produto->store_id);

        return redirect()->back()->withSuccess('Produto editado com sucesso');
    }

    public function desativar($product_id)
    {
        $this->authorize('editar produtos');
        if (is_null(auth()->user()->store_has_user))
            return $this->redirectConfig();

        $product = Product::where('id', $product_id)->first();
        if (auth()->user()->store_has_user->store->id != $product->store_id)
            abort(403);

        if ($product->ativo === 'S') {
            $product->update(['ativo' => 'N']);
            return redirect()->back()->withSuccess('Produto desativado com sucesso');
        }
        return redirect()->route('painel.lojista.produtos.index')->withErrors('Produto já está desativado');
    }

    public function ativar($product_id)
    {
        $this->authorize('editar produtos');
        if (is_null(auth()->user()->store_has_user))
            return $this->redirectConfig();

        $product = Product::where('id', $product_id)->first();
        if (auth()->user()->store_has_user->store->id != $product->store_id)
            abort(403);

        if ($product->ativo === 'N') {
            $product->update(['ativo' => 'S']);
            return redirect()->back()->withSuccess('Produto ativado com sucesso');
        }
        return redirect()->route('painel.lojista.produtos.index')->withErrors('Produto já está ativo');
    }

    public function destroy(Product $produto)
    {
        $this->authorize('excluir produtos');
        if (is_null(auth()->user()->store_has_user))
            return $this->redirectConfig();

        if (auth()->user()->store_has_user->store->id != $produto->store_id)
            abort(403);

        $produto->delete();
        return redirect()->back()->withSuccess('Produto removido com sucesso');
    }

    public function saveImagesProduct($request, $product_id, $store_id)
    {
        // Salvar imagem
        if ($request->hasFile('imagem_prod')) {
            foreach ($request->file('imagem_prod') as $key => $file_request) {
                ImageController::store($file_request, $product_id, $store_id, 'N');
            }
        }
        // Atualizar imagem principal
        if (Image::where('product_id', $product_id)->exists()) {
            Image::where('product_id', $product_id)->update(['principal' => 'N']);
            Image::where('product_id', $product_id)->first()->update(['principal' => 'S']);
        }
    }

    public function redirectConfig()
    {
        return redirect()
            ->route('painel.lojista.configuracoes')
            ->withErro('Você precisa adicionar os dados da sua loja antes de adicionar categorias.');
    }
}
