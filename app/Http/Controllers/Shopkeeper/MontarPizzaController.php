<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Models\Edge;
use App\Models\Size;
use App\Models\Flavor;
use App\Models\Product;
use App\Models\MontarPizza;
use Illuminate\Http\Request;
use App\Models\PizzaAdditional;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class MontarPizzaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:lojista|funcionario', 'can:visualizar produtos']);
    }

    public function index()
    {
        if (is_null(auth()->user()->store_has_user))
            return $this->redirectConfig();

        $store_id = auth()->user()->store_has_user->store->id;
        $montarPizza = MontarPizza::where('store_id', $store_id)->first();
        $sabores = Flavor::where('store_id', $store_id)->get();
        $bordas = Edge::where('store_id', $store_id)->get();
        $tamanhos = Size::where('store_id', $store_id)->get();
        $adicionais = PizzaAdditional::where('store_id', $store_id)->whereHas('adicional')->get();

        return view('painel.lojista.montar_pizza.index', compact('montarPizza', 'sabores', 'bordas', 'tamanhos', 'adicionais'));
    }

    public function createOrUpdate(Request $request)
    {
        $store_id = auth()->user()->store_has_user->store->id;

        if (MontarPizza::where('store_id', $store_id)->exists()) :
            $montarPizza = MontarPizza::where('store_id', $store_id)->first();
            $montarPizza = $montarPizza->fill($request->all());
        else :
            $montarPizza = (new MontarPizza)->fill($request->all());
        endif;

        $montarPizza->store_id = $store_id;
        $montarPizza->save();

        // salvar sabores
        $this->setFlavors($request);

        // salvar sabores
        $this->setEdges($request);

        // salvar sabores
        $this->setSizes($request);

        // salvar adicionais
        $this->setAdditionals($request);

        // dd($request->all());
        return redirect()->back()->withSuccess('Salvo com sucesso');
    }

    public function setAdditionals($request)
    {
        $store_id = auth()->user()->store_has_user->store->id;

        PizzaAdditional::where('store_id', $store_id)->delete();
        if (is_array($request->adicionais_id)) :
            foreach ($request->adicionais_id as $key => $product_id) :
                Product::findOrFail($product_id);
                PizzaAdditional::firstOrCreate([
                    'store_id' => $store_id,
                    'product_id' => $product_id
                ]);
            endforeach;
        endif;
    }

    public function setSizes($request)
    {
        $store_id = auth()->user()->store_has_user->store->id;

        $request->validate([
            'tamanhos' => ['required']
        ]);

        if (is_array($request->tamanhos)) :
            if (isset($request->tamanhos['tamanho'])) :
                if (isset($request->tamanhos['id'])) :
                    $flavorsDeletar = Size::where('store_id', $store_id)->whereNotIn('id', $request->tamanhos['id']);
                    $flavorsDeletar->delete();
                else :
                    Size::where('store_id', $store_id)->delete();
                endif;
                foreach ($request->tamanhos['tamanho'] as $key => $tamanho) :

                    if (isset($request->tamanhos['id'][$key])) :
                        if (isset($request->tamanhos['id'][$key])) :
                            $flavor = Size::where('id', $request->tamanhos['id'][$key])->first();
                        endif;

                        if ($flavor != null) :
                            $flavor->update([
                                'tamanho' => $tamanho,
                                'max_sabores' => $request->tamanhos['max_sabores'][$key],
                                'valor' => currency_to_decimal($request->tamanhos['valor'][$key]),
                            ]);
                        endif;

                    else :
                        Size::create([
                            'tamanho' => $tamanho,
                            'max_sabores' => $request->tamanhos['max_sabores'][$key],
                            'valor' => currency_to_decimal($request->tamanhos['valor'][$key]),
                            'store_id' => $store_id,
                        ]);
                    endif;
                endforeach;
            endif;
        endif;
    }

    public function setEdges($request)
    {
        $store_id = auth()->user()->store_has_user->store->id;

        $request->validate([
            'bordas' => ['required']
        ]);

        if (is_array($request->bordas)) :
            if (isset($request->bordas['borda'])) :
                if (isset($request->bordas['id'])) :
                    $edgesDeletar = Edge::where('store_id', $store_id)->whereNotIn('id', $request->bordas['id']);
                    foreach ($edgesDeletar->get() as $key => $value) :
                        Storage::disk('public')->delete(str_replace("storage/public", '', $value->img));
                    endforeach;
                    $edgesDeletar->delete();
                else :
                    Edge::where('store_id', $store_id)->delete();
                endif;
                foreach ($request->bordas['borda'] as $key => $borda) :

                    // salvar a imagem do borda
                    if (isset($request->bordas['img'][$key]) && $request->bordas['img'][$key] != null) :
                        $path = $request->file("bordas.img.$key")->store('public/monta-pizza');
                        $path = str_replace('/storage', 'storage/public', Storage::url($path));
                    else :
                        $path = null;
                    endif;

                    if (isset($request->bordas['id'][$key])) :
                        if (isset($request->bordas['id'][$key])) :
                            $edge = Edge::where('id', $request->bordas['id'][$key])->first();
                        endif;
                        if ($edge != null) :
                            if ($edge->img != null && $path == null) :
                                $path = $edge->img;
                            endif;
                            $edge->update([
                                'borda' => $borda,
                                'valor' => currency_to_decimal($request->bordas['valor'][$key]),
                                'descricao' => $request->bordas['descricao'][$key],
                                'img' => $path
                            ]);
                        endif;
                    else :
                        Edge::create([
                            'borda' => $borda,
                            'valor' => currency_to_decimal($request->bordas['valor'][$key]),
                            'store_id' => $store_id,
                            'descricao' => $request->bordas['descricao'][$key],
                            'img' => $path,
                        ]);
                    endif;
                endforeach;
                return true;
            endif;
        endif;

        return false;
    }

    /**
     * Salvar sabores
     *
     * @param  mixed $request
     * @return void
     */
    public function setFlavors($request)
    {
        $store_id = auth()->user()->store_has_user->store->id;

        $request->validate([
            'sabores' => ['required']
        ]);

        if (is_array($request->sabores)) :
            if (isset($request->sabores['sabor'])) :
                if (isset($request->sabores['id'])) :
                    $flavorsDeletar = Flavor::where('store_id', $store_id)->whereNotIn('id', $request->sabores['id']);
                    foreach ($flavorsDeletar->get() as $key => $value) :
                        Storage::disk('public')->delete(str_replace("storage/public", '', $value->img));
                    endforeach;
                    $flavorsDeletar->delete();
                else :
                    Flavor::where('store_id', $store_id)->delete();
                endif;
                foreach ($request->sabores['sabor'] as $key => $sabor) :

                    // salvar a imagem do sabor
                    if (isset($request->sabores['img'][$key]) && $request->sabores['img'][$key] != null) :
                        $path = $request->file("sabores.img.$key")->store('public/monta-pizza');
                        $path = str_replace('/storage', 'storage/public', Storage::url($path));
                    else :
                        $path = null;
                    endif;

                    if (isset($request->sabores['id'][$key])) :
                        if (isset($request->sabores['id'][$key])) :
                            $flavor = Flavor::where('id', $request->sabores['id'][$key])->first();
                        endif;

                        if ($flavor != null) :

                            if ($flavor->img != null && $path == null) :
                                $path = $flavor->img;
                            endif;

                            $flavor->update([
                                'sabor' => $sabor,
                                'descricao' => isset($request->sabores['descricao'][$key]) ? $request->sabores['descricao'][$key] : '',
                                'valor' => currency_to_decimal($request->sabores['valor'][$key]),
                                'img' => $path
                            ]);
                        endif;
                    else :
                        Flavor::create([
                            'sabor' => $sabor,
                            'descricao' => isset($request->sabores['descricao'][$key]) ? $request->sabores['descricao'][$key] : '',
                            'valor' => currency_to_decimal($request->sabores['valor'][$key]),
                            'store_id' => $store_id,
                            'img' => $path,
                        ]);
                    endif;
                endforeach;
                return true;
            endif;
        endif;

        return false;
    }

    public function jsonAdditionals(Request $request)
    {
        $store_id = auth()->user()->store_has_user->store->id;
        $data = [];
        if ($request->has('q')) :

            $str_filter = "%" . implode('%', explode(' ', $request->q)) . "%";
            $data = Product::where('store_id', $store_id)
                ->where('tipo', 'ADICIONAL')
                ->where('ativo', 'S')
                ->where('nome', 'like', $str_filter)
                ->limit(30)
                ->orderBy('nome');

            foreach ($data->get() as $key => $value) :
                if ($value->limitar_estoque == 'S' && $value->estoque <= 0) {
                    $data->where('id', '!=', $value->id);
                }
            endforeach;
            $data = $data->get();
        else :
            $data = Product::where('store_id', $store_id)
                ->where('tipo', 'ADICIONAL')
                ->where('ativo', 'S')
                ->limit(30)
                ->orderBy('nome');

            foreach ($data->get() as $key => $value) :
                if ($value->limitar_estoque == 'S' && $value->estoque <= 0) {
                    $data->where('id', '!=', $value->id);
                }
            endforeach;
            $data = $data->get();
        endif;

        return response()->json($data);
    }

    public function redirectConfig()
    {
        return redirect()
            ->route('painel.lojista.configuracoes')
            ->withErro('Você precisa adicionar os dados da sua loja antes de adicionar categorias.');
    }
}
