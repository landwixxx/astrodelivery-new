<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\TreatImageProduct;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:lojista|funcionario', 'can:visualizar categorias']);
    }

    public function index(Request $request)
    {
        if (is_null(auth()->user()->store_has_user))
            return $this->redirectConfig();

        $store_id = auth()->user()->store_has_user->store->id;

        $categories = Category::where('store_id', $store_id);

        if ($request->has('v')) :
            $categories->where('nome', 'like', '%' . $request->v . '%');
        endif;
        $categories = $categories->latest()->paginate(10);

        $all_categories = Category::where('store_id', $store_id)->orderBy('nome')->get();

        return view('painel.lojista.categorias.index', compact('categories', 'all_categories'));
    }

    public function create()
    {
        $this->authorize('adicionar categorias');
        return view('painel.lojista.categorias.create');
    }

    public function store(CategoryStoreRequest $request)
    {

        $this->authorize('adicionar categorias');

        if (is_null(auth()->user()->store_has_user))
            return $this->redirectConfig();

        $category = (new Category)->fill($request->all());
        $category->slug = Str::slug($request->nome);
        $category->store_id = auth()->user()->store_has_user->store->id;

        $pathImage = TreatImageProduct::save($request->file('foto'));
        $imageBase64 = TreatImageProduct::imageToBase64(public_path($pathImage));
        TreatImageProduct::delete($pathImage);

        $category->foto = $imageBase64;
        $category->save();

        // salver código do item
        if (is_null($category->codigo)) :
            if (Category::where('codigo', $category->id)->exists() == false) :
                $category->codigo = $category->id;
                $category->save();
            else :
                $total = Category::count();
                for ($i = 0; $i <= 1000000; $i++) :
                    $total++;
                    if (Category::where('codigo', $total)->exists() == false) {
                        $category->codigo = $total;
                        $category->save();
                        break;
                    }
                endfor;
            endif;
        endif;

        return redirect()->route('painel.lojista.categorias.index')->withSuccess('Categoria adicionada com sucesso');
    }

    public function edit(Category $category)
    {
        $this->authorize('editar categorias');
        // Se o usuário não estiver associado a loja da categoria
        if (auth()->user()->store_has_user->store->id != $category->store_id)
            abort(403);

        return view('painel.lojista.categorias.edit', compact('category'));
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $this->authorize('editar categorias');

        // Se o usuário não estiver associado a loja da categoria
        if (auth()->user()->store_has_user->store->id != $category->store_id)
            abort(403);

        $request['slug'] = Str::slug($request->slug);
        $category->fill($request->all());
        if ($request->hasFile('foto')) :

            $pathImage = TreatImageProduct::save($request->file('foto'));
            $imageBase64 = TreatImageProduct::imageToBase64(public_path($pathImage));
            TreatImageProduct::delete($pathImage);

            $category->foto = $imageBase64;

        endif;
        $category->save();

        return redirect()->back()->withSuccess('Categoria editada com sucesso');
    }

    public function destroy(Request $request, Category $category)
    {
        $this->authorize('excluir categorias');
        if (auth()->user()->store_has_user->store->id != $category->store_id)
            abort(403);

        if ($request->category_id == $category->id)
            return redirect()->back()->with('erro', 'A categoria que você selecionou é a mesma que será removida');

        // atualizar categoria de produtos
        if ($request->remover_produtos == 'nao')
            Product::where('category_id', $category->id)->update(['category_id' => $request->category_id]);

        $category->delete();
        return redirect()->back()->withSuccess('Categoria removida com sucesso');
    }

    public function redirectConfig()
    {
        return redirect()
            ->route('painel.lojista.configuracoes')
            ->withErro('Você precisa adicionar os dados da sua loja antes de adicionar categorias.');
    }
}
