<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Traits\StoreApi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryApi extends Controller
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
        $categories = Category::where('store_id', $this->store->id);
        $strSearch = str_replace(' ', '%', " {$request->termo} ");

        // pesquisa nome
        if ($request->has('termo') && $request->termo != null)
            $categories->where('nome', 'like', $strSearch);

        // pesquisa ativo
        if ($request->has('ativo') && $request->ativo != null)
            $categories->where('ativo', $request->ativo);

        return response()->json([
            'sucesso' => $categories->get([
                'codigo', 'nome', 'descricao', 'ativo', 'updated_at', 'usu_alt', 'ordem', 'ordem_produtos'
            ])
        ]);
    }

    public function gravar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'n_codigo' => ['nullable', 'unique:categories,codigo', 'max:255'],
            'ativo' => ['required', 'in:S,N', 'max:255'],
            'nome' => ['required', 'max:255'],
            'descricao' => ['nullable', 'max:1000'],
            'foto' => ['nullable'],
            'ordem' => ['nullable'],
            'ordem_produtos' => ['nullable'],
        ], [], [
            'n_codigo' => 'código',
            'descricao' => 'descrição',
        ]);
        if ($validator->fails()) {
            return response()->json(['erro' => $validator->errors()], 422);
        }

        $slug = Str::slug($request->nome);
        if (Category::where('slug', $slug)->exists())
            $slug = $slug . '-' . time();

        $category = new Category;
        $category->slug = $slug;
        $category->nome = $request->nome;
        $category->ativo = $request->ativo;
        $category->descricao = $request->descricao;
        $category->foto = $request->foto;
        $category->ordem = $request->ordem;
        $category->ordem_produtos = $request->ordem_produtos;
        $category->codigo = $request->n_codigo;
        $category->store_id = $this->store->id;
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

        return response()->json(['sucesso' => "{$category->codigo}"]);
    }
}
