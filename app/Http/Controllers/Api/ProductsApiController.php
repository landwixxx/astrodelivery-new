<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use App\Models\Product;
use App\Models\Category;
use App\Traits\StoreApi;
use Illuminate\Http\Request;
use App\Models\AdditionalGroup;
use App\Http\Controllers\Controller;
use App\Models\AdditionalHasProducts;
use Illuminate\Support\Facades\Validator;

class ProductsApiController extends Controller
{
    /**
     * store
     *
     * @var object|null
     */
    public $store;

    public function __construct(Request $request)
    {
        $this->store = StoreApi::get($request->header('token'));
    }

    public function consultar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_adicional' => ['nullable', 'in:S,N'],
            'n_categoria_codigo' => ['nullable', 'exists:categories,codigo', 'max:255'],
            'termo' => ['nullable'],
            'codigo' => ['nullable', 'exists:products,codigo', 'max:255'],
            'codigo_empresa' => ['nullable', 'exists:products,codigo_empresa', 'max:255'],
            'ativo' => ['nullable', 'in:S,N', 'max:255'],
        ], [], [
            'n_categoria_codigo' => 'código da categoria',
            'codigo' => 'código',
            'codigo_empresa' => 'código na empresa',
        ]);
        if ($validator->fails()) {
            return response()->json(['erro' => $validator->errors()], 422);
        }

        $products = Product::where('store_id', $this->store->id);

        // filtrar item adicional S/N
        if ($request->item_adicional != null)
            $products->where('item_adicional', $request->item_adicional);

        // filtrar categoria
        if ($request->n_categoria_codigo != null)
            $products->whereHas('category', function ($query) use ($request) {
                $query->where('codigo', $request->n_categoria_codigo);
            });

        // filtrar termo
        if ($request->termo != null) {
            $strSearch = str_replace(' ', '%', " {$request->termo} ");
            $products->where('nome', 'like', $strSearch);
        }

        // filtrar codigo
        if ($request->codigo != null)
            $products->where('codigo', $request->codigo);

        // filtrar codigo empresa
        if ($request->codigo_empresa != null)
            $products->where('codigo_empresa', $request->codigo_empresa);

        // filtrar ativo
        if ($request->ativo != null)
            $products->where('ativo', $request->ativo);

        $data = [];
        foreach ($products->get() as $key => $product) :
            if ($product->tipo != 'PIZZA') :
                $data[] = [
                    'codigo' => $product->codigo,
                    'categoria_codigo' => $product->category->codigo,
                    'nome' => $product->nome,
                    'descricao' => $product->descricao,
                    'sub_nome' => $product->sub_nome ?? '',
                    'cor_sub_nome' => $product->cor_sub_nome,
                    'valor' => $product->valor,
                    'valor_original' => $product->valor_original,
                    'estoque' => "{$product->estoque}",
                    'limitar_estoque' => $product->limitar_estoque,
                    'fracao' => $product->fracao,
                    'item_adicional' => $product->item_adicional,
                    'item_adicional_obrigar' => $product->item_adicional_obrigar,
                    'adicional_juncao' => $product->adicional_juncao,
                    'item_adicional_multi' => $product->item_adicional_multi,
                    'adicional_qtde_min' => "{$product->adicional_qtde_min}",
                    'adicional_qtde_max' => "$product->adicional_qtde_max",
                    'codigo_empresa' => $product->codigo_empresa ?? '',
                    'codigo_barras' => $product->codigo_barras ?? '',
                    'codigo_barras_padrao' => $product->codigo_barras_padrao ?? '',
                    'usu_alt' => $product->usu_alt ?? '',
                    'dta_alteracao' => $product->updated_at->format('Y-m-d H:i:s'),
                    'ativo' => $product->ativo,
                    'categoria_nome' => $product->category->nome,
                ];
            else :
                /* Organizar dados da pizz */
                $dadosPizza = $product->pizza_product()->where('product_id', $product->id)->get([
                    'valor_minimo',
                    'qtd_min_sabores',
                    'qtd_max_sabores',
                    'sabores',
                    'bordas',
                ])->first()->toArray();

                // Organizar imagens de sabores da pizza
                if (is_array($dadosPizza['sabores']) && count($dadosPizza['sabores']) > 0) :
                    // loop de categorias
                    foreach ($dadosPizza['sabores'] as $keyCat =>  $cat) :
                        // loop de sabores
                        if (is_array($cat['itens']) && count($cat['itens']) > 0) :
                            foreach ($cat['itens'] as $keySabor => $sabor) :
                                $img = $sabor['imagem'] ?? 'assets/img/pizza/pizza-empty.png';
                                $dadosPizza['sabores'][$keyCat]['itens'][$keySabor]['imagem'] = asset($img);
                            endforeach;
                        endif;
                    endforeach;
                endif;
                $dadosPizza['categoria_sabores']= $dadosPizza['sabores'];
                unset($dadosPizza['sabores']);

                // Organizar imagens de bordas da pizza
                if (is_array($dadosPizza['bordas']) && count($dadosPizza['bordas']) > 0) :
                    foreach ($dadosPizza['bordas'] as $key => $borda) :
                        $img = $borda['imagem'] ?? 'assets/img/pizza/pizza-empty.png';
                        $dadosPizza['bordas'][$key]['imagem'] = asset($img);
                    endforeach;
                endif;

                $data[] = [
                    'codigo' => $product->codigo,
                    'categoria_codigo' => $product->category->codigo,
                    'nome' => $product->nome,
                    'descricao' => $product->descricao,
                    'sub_nome' => $product->sub_nome ?? '',
                    'cor_sub_nome' => null,
                    'valor' => $product->valor,
                    'dados_pizza' => $dadosPizza,
                    'valor_original' => null,
                    'estoque' => null,
                    'limitar_estoque' => $product->limitar_estoque,
                    'fracao' => null,
                    'item_adicional' => null,
                    'item_adicional_obrigar' => null,
                    'adicional_juncao' => null,
                    'item_adicional_multi' => null,
                    'adicional_qtde_min' => null,
                    'adicional_qtde_max' => null,
                    'codigo_empresa' => $product->codigo_empresa ?? '',
                    'codigo_barras' => null,
                    'codigo_barras_padrao' => null,
                    'usu_alt' => $product->usu_alt ?? '',
                    'dta_alteracao' => $product->updated_at->format('Y-m-d H:i:s'),
                    'ativo' => $product->ativo,
                    'categoria_nome' => $product->category->nome,
                ];
            endif;
        endforeach;

        return response()->json(['sucesso' => $data]);
    }

    public function gravar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => ['nullable', 'unique:products,codigo', 'max:255'],
            'categoria_codigo' => ['required', 'exists:categories,codigo'],
            'nome' => ['required', 'max:255'],
            'sub_nome' => ['nullable', 'max:255'],
            'cor_sub_nome' => ['required', 'max:255'],
            'codigo_empresa' => ['nullable', 'max:255'],
            'codigo_barras' => ['nullable', 'max:255'],
            'codigo_barras_padrao' => ['nullable', 'max:255'],
            'valor_original' => ['nullable', 'numeric', 'max:999999999'],
            'valor' => ['required', 'numeric', 'max:999999999'],
            'estoque' => ['nullable', 'numeric', 'max:999999999'],
            'limitar_estoque' => ['required', 'in:S,N'],
            'fracao' => ['required', 'in:S,N'],
            'item_adicional' => ['required', 'in:S,N'],
            'item_adicional_obrigar' => ['required', 'in:S,N'],
            'item_adicional_multi' => ['required', 'in:S,N'],
            'adicional_qtde_min' => ['nullable', 'numeric'],
            'adicional_qtde_max' => ['nullable', 'numeric'],
            'adicional_juncao' => ['nullable', 'in:SOMA,DIVIDIR,MEDIA'],
            'ativo' => ['required', 'in:S,N'],
            'descricao' => ['nullable', 'max:5000'],
            'ordem' => ['nullable'],
        ], [], [
            'codigo' => 'código',
            'cor_sub_nome' => 'cor subnome',
            'descricao' => 'descrição',
            'codigo_empresa' => 'código na empresa',
            'codigo_barras' => 'código de barras',
            'codigo_barras_padrao' => 'padrão código barras',
            'categoria_codigo' => 'código da categoria',
            'fracao' => 'fração',
            'item_adicional_obrigar' => 'obrigar item adicional',
            'adicional_qtde_min' => 'adicional qtd. mínima',
            'adicional_qtde_max' => 'adicional qtd. máxima',
            'adicional_juncao' => 'adicional junção',
        ]);
        if ($validator->fails()) {
            return response()->json(['erro' => $validator->errors()], 422);
        }

        // obter categoria do código informado
        $category = Category::where('store_id', $this->store->id)
            ->where('codigo', $request->categoria_codigo)
            ->first();

        if (is_null($category))
            return response()->json(['erro' => 'Você não tem uma categoria com o código informado']);

        $product = new Product;
        $product->codigo = $request->codigo;
        $product->tipo = 'PRODUTO';
        $product->category_id = $category->id;
        $product->nome = $request->nome;
        $product->sub_nome = $request->sub_nome;
        $product->cor_sub_nome = $request->cor_sub_nome;
        $product->descricao = $request->descricao;
        $product->codigo_empresa = $request->codigo_empresa;
        $product->codigo_barras = $request->codigo_barras;
        $product->codigo_barras_padrao = $request->codigo_barras_padrao;
        $product->valor_original = $request->valor_original;
        $product->valor = $request->valor;
        $product->estoque = $request->estoque;
        $product->limitar_estoque = $request->limitar_estoque;
        $product->fracao = $request->fracao;
        $product->item_adicional = $request->item_adicional;
        $product->item_adicional_obrigar = $request->item_adicional_obrigar;
        $product->item_adicional_multi = $request->item_adicional_multi;
        $product->adicional_qtde_min = $request->adicional_qtde_min;
        $product->adicional_qtde_max = $request->adicional_qtde_max;
        $product->adicional_juncao = $request->adicional_juncao;
        $product->ativo = $request->ativo;
        $product->ordem = $request->ordem ?? 1;
        $product->store_id = $this->store->id;
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

        return response()->json(['sucesso' => "{$product->codigo}"]);
    }

    public function gravarProdutoAnexo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'n_produtos_codigo' => ['required', 'exists:products,codigo', 'max:255'],
            'foto' => ['required'],
            'descricao' => ['nullable'],
            'mimetype' => ['nullable'],
            'extensao' => ['nullable'],
            'principal' => ['required', 'in:S,N', 'max:255'],
        ], [], [
            'n_produtos_codigo' => 'código do produto',
            'descricao' => 'descrição',
            'extensao' => 'extensão',
        ]);
        if ($validator->fails()) {
            return response()->json(['erro' => $validator->errors()], 422);
        }

        $product = Product::where('store_id', $this->store->id)->where('codigo', $request->n_produtos_codigo)->first();
        if (is_null($product))
            return response()->json(['erro' => 'O código do produto não foi encontrado'], 404);

        if ($request->principal == 'S') {
            Image::where('store_id', $this->store->id)->where('product_id', $product->id)->update([
                'principal' => 'N'
            ]);
        }

        $image = Image::create([
            'foto' => $request->foto,
            'descricao' => $request->descricao,
            'principal' => $request->principal,
            'extensao' => $request->extensao ?? 'jpg',
            'mimetype' => $request->mimetype ?? 'image/jpeg',
            'product_id' => $product->id,
            'store_id' => $this->store->id,
        ]);

        return response()->json(['sucesso' => "{$image->id}"]);
    }

    public function excluirProdutoAnexo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'n_produtos_codigo' => ['required', 'exists:products,codigo', 'max:255'],
            'n_codigo' => ['required', 'exists:images,id', 'max:255'],
        ], [], [
            'n_produtos_codigo' => 'código do produto',
            'n_codigo' => 'código da foto',
        ]);
        if ($validator->fails()) {
            return response()->json(['erro' => $validator->errors()], 422);
        }

        $product = Product::where('store_id', $this->store->id)
            ->where('codigo', $request->n_produtos_codigo)
            ->first();
        if (is_null($product))
            return response()->json(['erro' => 'O código do produto não foi encontrado'], 404);

        $image = Image::where('store_id', $this->store->id)
            ->where('product_id', $product->id)
            ->where('id', $request->n_codigo);
        if ($image->exists() == false)
            return response()->json(['erro' => 'O código da imagem não pertence ao produto'], 403);

        Image::where('store_id', $this->store->id)
            ->where('product_id', $product->id)
            ->where('id', $request->n_codigo)
            ->delete();
        return response()->json(['sucesso' => '@']);
    }

    public function gravarGrupoAdicional(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => ['nullable', 'unique:additional_groups,codigo'],
            'nome' => ['required', 'max:255'],
            'descricao' => ['nullable', 'max:5000'],
            'adicional_qtde_min' => ['nullable', 'numeric', 'min:0', 'max:999999999'],
            'adicional_qtde_max' => ['nullable', 'numeric', 'min:0', 'max:999999999'],
            'adicional_juncao' => ['nullable', 'in:SOMA,DIVIDIR,MEDIA'],
            'ordem' => ['nullable'],
            'ordem_interna' => ['nullable'],
        ], [], [
            'adicional_juncao' => 'adicional_junção',
            'codigo' => 'código',
            'descricao' => 'descrição',
        ]);
        if ($validator->fails()) {
            return response()->json(['erro' => $validator->errors()], 422);
        }

        $additonalGroup = new AdditionalGroup;
        $additonalGroup->codigo =  $request->codigo;
        $additonalGroup->nome =  $request->nome;
        $additonalGroup->descricao =  $request->descricao;
        $additonalGroup->adicional_qtd_min =  $request->adicional_qtde_min;
        $additonalGroup->adicional_qtd_max =  $request->adicional_qtde_max;
        $additonalGroup->adicional_juncao =  $request->adicional_juncao;
        $additonalGroup->ordem =  $request->ordem;
        $additonalGroup->ordem_interna =  $request->ordem_interna;
        $additonalGroup->store_id =  $this->store->id;
        $additonalGroup->save();

        // salver código do item
        if (is_null($additonalGroup->codigo)) :
            if (AdditionalGroup::where('codigo', $additonalGroup->id)->exists() == false) :
                $additonalGroup->codigo = $additonalGroup->id;
                $additonalGroup->save();
            else :
                $total = AdditionalGroup::count();
                for ($i = 0; $i <= 1000000; $i++) :
                    $total++;
                    if (AdditionalGroup::where('codigo', $total)->exists() == false) {
                        $additonalGroup->codigo = $total;
                        $additonalGroup->save();
                        break;
                    }
                endfor;
            endif;
        endif;

        return response()->json(['sucesso' => "{$additonalGroup->codigo}"]);
    }

    /**
     * Remove vínculo entre o produto com grupo adicional, irá remover todos os produtos do grupo e o grupo
     *
     * @param  mixed $request
     * @return void
     */
    public function excluirGrupoAdicional(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'n_produtos_codigo' => ['required', 'exists:products,codigo', 'max:255'],
            'n_codigo' => ['required', 'exists:additional_groups,codigo', 'max:255'],
        ], [], [
            'n_produtos_codigo' => 'código do produto',
            'n_codigo' => 'código do grupo',
        ]);
        if ($validator->fails()) {
            return response()->json(['erro' => $validator->errors()], 422);
        }

        $additonal = AdditionalGroup::where('store_id', $this->store->id)->where('codigo', $request->n_codigo);
        if ($additonal->exists()) :
            $additonal->delete();
            return response()->json(['sucesso' => '@']);
        endif;

        return response()->json(['erro' => 'O código do grupo não foi encontrado'], 404);
    }

    /**
     * Remove vínculo entre o produto com item adicional
     *
     * @param  mixed $request
     * @return void
     */
    public function excluirProdutoAdicional(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'n_produtos_codigo' => ['required', 'exists:products,codigo', 'max:255'],
            'n_codigo' => ['required', 'exists:products,codigo', 'max:255'],
        ], [], [
            'n_produtos_codigo' => 'código do produto principal',
            'n_codigo' => 'código do produto adicional',
        ]);
        if ($validator->fails()) {
            return response()->json(['erro' => $validator->errors()], 422);
        }

        $productMain = Product::where('store_id', $this->store->id)->where('codigo', $request->n_produtos_codigo)->first();
        if (is_null($productMain))
            return response()->json(['erro' => 'O código do produto principal não foi encontrado'], 404);

        $productAdditional = Product::where('store_id', $this->store->id)->where('codigo', $request->n_codigo)->first();
        if (is_null($productAdditional))
            return response()->json(['erro' => 'O código do produto adicional não foi encontrado'], 404);

        $additonalHasProduct = AdditionalHasProducts::where('store_id', $this->store->id)
            ->where('product_id', $productMain->id)
            ->where('additional_product_id', $productAdditional->id);
        if ($additonalHasProduct->count() == 0)
            return response()->json(['erro' => 'O registro não foi encontrado']);

        $additonalHasProduct->delete();

        return response()->json(['sucesso' => '@']);
    }

    /**
     * Faz vínculo entre o produto com item adicional
     *
     * @param  mixed $request
     * @return void
     */
    public function gravarProdutoAdicional(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'n_produtos_codigo' => ['required', 'exists:products,codigo', 'max:255'], // produto principal
            'n_codigo' => ['required', 'exists:products,codigo', 'max:255'], // adicional
        ], [], [
            'n_produtos_codigo' => 'código do produto principal',
            'n_codigo' => 'código do produto adicional',
        ]);
        if ($validator->fails()) {
            return response()->json(['erro' => $validator->errors()], 422);
        }

        $productMain = Product::where('store_id', $this->store->id)->where('codigo', $request->n_produtos_codigo)->first();
        if (is_null($productMain))
            return response()->json(['erro' => 'O código do produto principal não foi encontrado'], 404);

        $productAdditional = Product::where('store_id', $this->store->id)->where('codigo', $request->n_codigo)->first();
        if (is_null($productAdditional))
            return response()->json(['erro' => 'O código do produto adicional não foi encontrado'], 404);

        $exist = AdditionalHasProducts::where('store_id', $this->store->id)
            ->where('product_id', $productMain->id)
            ->where('additional_product_id', $productAdditional->id)->exists();
        if ($exist)
            return response()->json(['erro' => 'O vínculo entre produto e adicional já existe'], 403);

        if (is_null($productAdditional->additional_group))
            return response()
                ->json(['erro' => "O adicional '{$productAdditional->nome}' precisa estar vínculado a um grupo de adicional"], 403);

        $additonalHasProduct = new AdditionalHasProducts;
        $additonalHasProduct->product_id = $productMain->id;
        $additonalHasProduct->additional_product_id = $productAdditional->id;
        $additonalHasProduct->store_id = $this->store->id;
        $additonalHasProduct->save();

        return response()->json(['sucesso' => '@']);
    }

    /**
     * Consulta  adicionais do produto 
     *
     * @param  mixed $request
     * @return void
     */
    public function pesquisarProdutoAdicional(Request $request)
    {
        $product = Product::where('store_id', $this->store->id)->where('codigo', $request->n_produtos_codigo)->first();

        if (is_null($product))
            return response()->json(['erro' => 'Produto não foi encontrado'], 404);

        if (is_null($product->additional_has_products))
            return response()->json(['erro' => 'O produto não tem adicionais'], 404);

        $data = [];
        foreach ($product->additional_has_products as $additional_has_product) {
            $itemAdditional = Product::find($additional_has_product->additional_product_id);

            $data[] = [
                'produtos_codigo' => $product->codigo,
                'codigo' => $itemAdditional->codigo,
                'categoria_codigo' => $itemAdditional->category->codigo,
                'grupo_adicional_codigo' => $itemAdditional->additional_group->codigo,
                'nome' => $itemAdditional->nome,
                'descricao' => $itemAdditional->descricao,
                'sub_nome' => $itemAdditional->sub_nome,
                'cor_sub_nome' => $itemAdditional->cor_sub_nome,
                'valor' => $itemAdditional->valor,
                'valor_original' => $itemAdditional->valor_original,
                'estoque' => "{$itemAdditional->estoque}",
                'limitar_estoque' => $itemAdditional->limitar_estoque,
                'fracao' => $itemAdditional->fracao,
                'item_adicional' => $itemAdditional->item_adicional,
                'item_adicional_obrigar' => $itemAdditional->item_adicional_obrigar,
                'adicional_juncao' => $itemAdditional->adicional_juncao,
                'item_adicional_multi' => $itemAdditional->item_adicional_multi,
                'adicional_qtde_min' => "{$itemAdditional->adicional_qtde_min}",
                'adicional_qtde_max' => "{$itemAdditional->adicional_qtde_max}",
                'codigo_empresa' => $itemAdditional->codigo_empresa ?? '',
                'codigo_barras' => $itemAdditional->codigo_barras ?? '',
                'codigo_barras_padrao' => $itemAdditional->codigo_barras_padrao ?? '',
                'usu_alt' => $itemAdditional->usu_alt ?? '',
                'dta_alteracao' => $itemAdditional->updated_at->format('Y-m-d H:i:s'),
                'ativo' => $itemAdditional->ativo,
                'categoria_nome' => $itemAdditional->category->nome,
            ];
        }

        return response()->json(['sucesso' => $data]);
    }
}
