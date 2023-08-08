<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Models\Edge;
use App\Models\Size;
use App\Models\Image;
use App\Models\Flavor;
use App\Models\Product;
use App\Models\Category;
use App\Models\MontarPizza;
use App\Models\PizzaProduct;
use Illuminate\Http\Request;
use App\Models\PizzaAdditional;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PizzaProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:lojista|funcionario', 'can:visualizar produtos']);
    }

    public function create()
    {
        $this->authorize('adicionar produtos');
        if (is_null(auth()->user()->store_has_user))
            return $this->redirectConfig();

        $store_id = auth()->user()->store_has_user->store->id;
        $categories = Category::where('store_id', $store_id)->orderBy('nome')->get();

        return view('painel.lojista.produtos.pizza.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sabores' => ['required'],
        ], [
            'sabores.required' => 'É obrigatório adiconar pelo menos um sabor',
        ]);

        $this->authorize('adicionar produtos');
        if (is_null(auth()->user()->store_has_user))
            return $this->redirectConfig();

        $store_id = auth()->user()->store_has_user->store->id;
        $valueMin = currency_to_decimal($request['valor_minimo']);

        $productMain = (new Product)->fill($request->all());
        $productMain->tipo = 'PIZZA';
        $productMain->valor = $valueMin;
        $productMain->ordem = $request->ordem ?? 1;
        $productMain->store_id = $store_id;
        $productMain->save();

        // salver código do item
        $this->saveCodProduct($productMain);

        // salvar imagem
        if ($request->hasFile('imagem_prod')) :
            $productController = new ProductController;
            $productController->saveImagesProduct($request, $productMain->id, $productMain->store_id);
        endif;

        // salvar produto pizza
        $productPizza = (new PizzaProduct)->fill($request->all());
        $productPizza->valor_minimo = $valueMin;
        $productPizza->product_id = $productMain->id;

        $productPizza->sabores = $this->organizeFlavorData($request);
        $productPizza->bordas = $this->organizeEdgeData($request);

        $productPizza->save();

        return redirect()->route('painel.lojista.produtos.index')->withSuccess('Cadastro realizado com sucesso.');
    }

    public function edit(Product $product)
    {
        $this->authorize('editar produtos');
        if (is_null(auth()->user()->store_has_user))
            return $this->redirectConfig();

        $store_id = auth()->user()->store_has_user->store->id;
        $categories = Category::where('store_id', $store_id)->orderBy('nome')->get();

        // dd($product->pizza_product->bordas);
        return view('painel.lojista.produtos.pizza.edit', compact('categories', 'product'));
    }

    public function show(Product $product)
    {
        return view('painel.lojista.produtos.pizza.show', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        // dd($request->all());
        $request->validate([
            'sabores' => ['required'],
            'bordas' => ['required'],
        ], [
            'sabores.required' => 'É obrigatório adiconar pelo menos um sabor',
            'bordas.required' => 'É obrigatório adiconar pelo menos uma borda',
        ]);

        $this->authorize('adicionar produtos');
        if (is_null(auth()->user()->store_has_user))
            return $this->redirectConfig();

        $valueMin = currency_to_decimal($request['valor_minimo']);

        $productMain = $product->fill($request->all());
        $productMain->valor = $valueMin;
        $productMain->ordem = $request->ordem ?? 1;
        $productMain->tipo = "PIZZA";
        $productMain->save();

        // salvar imagem
        if ($request->hasFile('imagem_prod')) :
            Image::where('product_id', $productMain->id)->delete();
            $productController = new ProductController;
            $productController->saveImagesProduct($request, $productMain->id, $productMain->store_id);
        endif;

        // salvar produto pizza
        if (is_null($product->pizza_product)) : // se não tiver sido criado
            $productPizza = (new PizzaProduct)->fill($request->all());
            $productPizza->product_id = $productMain->id;
        else :
            $productPizza = $product->pizza_product->fill($request->all());
        endif;
        $productPizza->valor_minimo = $valueMin;
        $productPizza->product_id = $productMain->id;

        $productPizza->sabores = $this->organizeFlavorData($request, true);
        $productPizza->bordas = $this->organizeEdgeData($request, true);

        $productPizza->save();

        return redirect()->back()->withSuccess('Atualizado com sucesso.');
    }

    public function organizeFlavorData($request, $edit = false)
    {
        $sabores = [];
        // organizar sabores
        foreach ($request->sabores as $keyTimestamp => $itemCategoria) :
            $itemCategoriaFormatado = [
                'categoria' => $itemCategoria['categoria'],
                'itens' => []
            ];
            foreach ($itemCategoria['itens']['sabor'] as $key => $sabor) :

                // salvar a imagem do sabor
                if (isset($itemCategoria['itens']['img'][$key]) && $itemCategoria['itens']['img'][$key] != null) :
                    $pathImgBorda = $request->file("sabores.$keyTimestamp.itens.img.$key")->store('public/monta-pizza');
                    $pathImgBorda = str_replace('/storage', 'storage/public', Storage::url($pathImgBorda));

                    if ($edit) :
                        if (isset($itemCategoria['itens']['img_edit'][$key]) && $itemCategoria['itens']['img_edit'][$key] != null) :
                            $pathDelete = $itemCategoria['itens']['img_edit'][$key];
                            Storage::disk('public')->delete(str_replace("storage/public", '', $pathDelete));
                        endif;
                    endif;
                else :
                    if ($edit) :
                        if (isset($itemCategoria['itens']['img_edit'][$key]) && $itemCategoria['itens']['img_edit'][$key] != null) :
                            $pathImgBorda = $itemCategoria['itens']['img_edit'][$key];
                        else :
                            $pathImgBorda = null;
                        endif;
                    else :
                        $pathImgBorda = null;
                    endif;
                endif;

                if ($edit && $request->has('imgs_deletar')) :
                    foreach ($request->imgs_deletar as $pathImgDelete) :
                        Storage::disk('public')->delete(str_replace("storage/public", '', $pathImgDelete));
                    endforeach;
                endif;

                // organizar dados
                $itemCategoriaFormatado['itens'][] = [
                    'sabor' => isset($itemCategoria['itens']['sabor'][$key]) ? $itemCategoria['itens']['sabor'][$key] : '',
                    'descricao' => isset($itemCategoria['itens']['descricao'][$key]) ? $itemCategoria['itens']['descricao'][$key] : '',
                    'valor' => isset($itemCategoria['itens']['valor'][$key]) ? currency_to_decimal($itemCategoria['itens']['valor'][$key]) : '',
                    'imagem' => $pathImgBorda,
                ];

            endforeach;
            array_push($sabores, $itemCategoriaFormatado);
        endforeach;

        return $sabores;
    }

    public function organizeEdgeData($request, $edit = false)
    {
        $bordas = [];
        // organizar bordas
        if (isset($request->bordas['borda']))
            foreach ($request->bordas['borda'] as $key => $nomeBorda) :

                // salvar a imagem do borda
                if (isset($request->bordas['img'][$key]) && $request->bordas['img'][$key] != null) :
                    $pathImgBorda = $request->file("bordas.img.$key")->store('public/monta-pizza');
                    $pathImgBorda = str_replace('/storage', 'storage/public', Storage::url($pathImgBorda));

                    if (isset($request->bordas['img_edit'][$key]) && $request->bordas['img_edit'][$key] != '') :
                        $pathImgBordaDeletar = $request->bordas['img_edit'][$key];
                        Storage::disk('public')->delete(str_replace("storage/public", '', $pathImgBordaDeletar));
                    endif;

                else :
                    // se uma nova img não for atualizada vai continuar a mesma
                    if (isset($request->bordas['img_edit'][$key]) && $request->bordas['img_edit'][$key] != '') :
                        $pathImgBorda = $request->bordas['img_edit'][$key];
                    else :
                        $pathImgBorda = null;
                    endif;
                endif;

                // organizar dados
                $itemFormatado = [
                    'borda' => isset($request->bordas['borda'][$key]) ? $request->bordas['borda'][$key] : '',
                    'descricao' => isset($request->bordas['descricao'][$key]) ? $request->bordas['descricao'][$key] : '',
                    'valor' => isset($request->bordas['valor'][$key]) ? currency_to_decimal($request->bordas['valor'][$key]) : '',
                    'imagem' => $pathImgBorda,
                ];

                array_push($bordas, $itemFormatado);

            endforeach;

        return $bordas;
    }

    public function saveCodProduct($productMain)
    {
        if (is_null($productMain->codigo)) :
            if (Product::where('codigo', $productMain->id)->exists() == false) :
                $productMain->codigo = $productMain->id;
                $productMain->save();
            else :
                $total = Product::count();
                for ($i = 0; $i <= 1000000; $i++) :
                    $total++;
                    if (Product::where('codigo', $total)->exists() == false) {
                        $productMain->codigo = $total;
                        $productMain->save();
                        break;
                    }
                endfor;
            endif;
        endif;
    }

    public function redirectConfig()
    {
        return redirect()
            ->route('painel.lojista.configuracoes')
            ->withErro('Você precisa adicionar os dados da sua loja antes de adicionar categorias.');
    }
}
