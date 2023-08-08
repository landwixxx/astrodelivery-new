<?php

namespace App\Http\Controllers\Customer;

use App\Models\Edge;
use App\Models\Size;
use App\Models\Store;
use App\Models\Flavor;
use App\Models\Product;
use App\Models\MontarPizza;
use Illuminate\Http\Request;
use App\Models\PizzaAdditional;
use App\Http\Controllers\Controller;

class AssemblePizzaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth_customer']);
    }

    public function flavors($slug_store, Request $request)
    {
        // dd(session('items_cart'));

        if ($this->checkDeleted()) :
            return $this->redirectMod($slug_store);
        endif;

        $store = Store::where('slug_url', $slug_store)->first();
        $montarPizza = MontarPizza::where('store_id', $store->id)->first();
        $flavors = Flavor::where('store_id', $store->id)->orderBy('sabor')->get();

        if ($montarPizza->status != 'ativo')
            abort(403);

        $max_sabores = 0;
        $min_sabores = 0;
        if (session('tamanho_id')) :
            $tamanho = Size::find(session('tamanho_id'));
            $max_sabores = $tamanho->max_sabores;
            $min_sabores = 1;
        else :
            return redirect()
                ->route('loja.montar-pizza.tamanhos', ['slug_store' => $slug_store])
                ->withError('Selecione o tamanho');
        endif;

        return view('front.loja.montar_pizza.sabores', compact('store', 'flavors', 'montarPizza', 'max_sabores', 'min_sabores'));
    }

    public function flavorsSave($slug_store, Request $request)
    {
        if ($this->checkDeleted()) :
            return $this->redirectMod($slug_store);
        endif;

        $ids = [];
        foreach (json_decode($request->sabores_id) as $key => $value) :
            $ids[] = intval($value);
        endforeach;
        $request->session()->put('sabores_id', $ids);

        return redirect()->route('loja.montar-pizza.bordas', ['slug_store' => $slug_store]);
    }

    public function edge($slug_store, Request $request)
    {
        if ($this->checkDeleted()) :
            return $this->redirectMod($slug_store);
        endif;

        $store = Store::where('slug_url', $slug_store)->first();
        $montarPizza = MontarPizza::where('store_id', $store->id)->first();
        $flavors = Flavor::where('store_id', $store->id)->orderBy('sabor')->get();
        $edges = Edge::where('store_id', $store->id)->orderBy('borda')->get();

        if ($montarPizza->status != 'ativo')
            abort(403);

        $max_bordas = 0;
        $min_bordas = 0;
        if (session('sabores_id')) :
            $max_bordas = count(session('sabores_id'));
            $min_bordas = 1;
            if (session('bordas_id') && count(session('bordas_id')) > $max_bordas) :
                session()->forget('bordas_id');
                return redirect()
                    ->route('loja.montar-pizza.bordas', ['slug_store' => $slug_store]);
            endif;
        else :
            return redirect()
                ->route('loja.montar-pizza.sabores', ['slug_store' => $slug_store])
                ->withError('Selecione o sabor');
        endif;

        return view('front.loja.montar_pizza.bordas', compact('store', 'flavors', 'montarPizza', 'edges', 'max_bordas', 'min_bordas'));
    }

    public function edgeSave($slug_store, Request $request)
    {
        if ($this->checkDeleted()) :
            return $this->redirectMod($slug_store);
        endif;

        $ids = [];
        if (is_array($request->bordas)) :
            foreach ($request->bordas as $key => $value) {
                $ids[] = intval($value);
            }
        endif;
        $request->session()->put('bordas_id', $ids);

        return redirect()->route('loja.montar-pizza.adicionais', ['slug_store' => $slug_store]);
    }

    public function size($slug_store, Request $request)
    {
        // session()->forget('items_cart_pizza');
        if ($this->checkDeleted()) :
            return $this->redirectMod($slug_store);
        endif;

        $store = Store::where('slug_url', $slug_store)->first();
        $montarPizza = MontarPizza::where('store_id', $store->id)->first();
        $flavors = Flavor::where('store_id', $store->id)->orderBy('sabor')->get();
        $sizes = Size::where('store_id', $store->id)->orderBy('tamanho')->get();

        if ($montarPizza->status != 'ativo')
            abort(403);

        return view('front.loja.montar_pizza.tamanhos', compact('store', 'flavors', 'sizes', 'montarPizza'));
    }

    public function sizeSave($slug_store, Request $request)
    {
        if ($this->checkDeleted()) :
            return $this->redirectMod($slug_store);
        endif;

        // resetar sabores e bordas
        if (session('tamanho_id') != $request->tamanho) :
            session()->forget('sabores_id');
            session()->forget('bordas_id');
        endif;

        $request->session()->put('tamanho_id', $request->tamanho);
        return redirect()->route('loja.montar-pizza.sabores', ['slug_store' => $slug_store]);
    }

    public function revision($slug_store, Request $request)
    {
        if ($this->checkDeleted()) :
            return $this->redirectMod($slug_store);
        endif;

        $store = Store::where('slug_url', $slug_store)->first();
        $montarPizza = MontarPizza::where('store_id', $store->id)->first();
        $flavors = Flavor::where('store_id', $store->id)->orderBy('sabor')->get();
        $sizes = Size::where('store_id', $store->id)->orderBy('tamanho')->get();
        $edges = Edge::where('store_id', $store->id)->orderBy('borda')->get();

        if ($montarPizza->status != 'ativo')
            abort(403);

        if (is_null(session('tamanho_id')))
            return redirect()->route('loja.montar-pizza.tamanhos', ['slug_store' => $slug_store])->withError('Selecione o tamanho');
        if (is_null(session('bordas_id')))
            return redirect()->route('loja.montar-pizza.bordas', ['slug_store' => $slug_store])->withError('Selecione a borda');
        if (is_null(session('sabores_id')))
            return redirect()->route('loja.montar-pizza.sabores', ['slug_store' => $slug_store])->withError('Selecione o sabor');

        $tamanho = Size::find(session('tamanho_id'));

        $bordas = Edge::whereIn('id', session('bordas_id'))->orderBy('borda')->get();
        $valorBordas = \App\Models\Edge::whereIn('id', session('bordas_id') ?? [])->sum('valor');
        $valorBordas = $valorBordas / count(session('bordas_id') ?? [0]);

        $sabores = Flavor::whereIn('id', session('sabores_id'))->orderBy('sabor')->get();
        $valorSabores = Flavor::whereIn('id', session('sabores_id'))->sum('valor');
        $valorSabores = $valorSabores / count(session('sabores_id') ?? []);

        $adicionais = [];
        $totalValorAdicionais = 0;
        // se existe adicionais
        if (isset(session('adicionais')['itens']) && count(session('adicionais')['itens']) > 0) :
            foreach (session('adicionais')['itens'] as $key => $item) :
                $produto = Product::find($item['id']);
                // se o adicional produto foi removido enquanto esta no carrinho
                if (is_null($produto)) :
                    return redirect()->route('loja.montar-pizza.adicionais', ['slug_store' => $slug_store])->withError('Ouve uma alteração nos adicionais');
                endif;
                $adicionais[] = [
                    'id' => $item['id'],
                    'qtd' => $item['qtd'],
                    'produto' => $produto
                ];

                $totalValorAdicionais += $item['qtd'] * $produto->valor;
            endforeach;
        endif;

        $valorTotalPizza = $totalValorAdicionais + $valorBordas  + $valorSabores + $tamanho->valor;

        return view('front.loja.montar_pizza.revisao', compact(
            'valorTotalPizza',
            'totalValorAdicionais',
            'adicionais',
            'store',
            'flavors',
            'sizes',
            'edges',
            'montarPizza',
            'tamanho',
            'bordas',
            'valorBordas',
            'sabores',
            'valorSabores'
        ));
    }

    public function additionals($slug_store, Request $request)
    {
        if ($this->checkDeleted()) :
            return $this->redirectMod($slug_store);
        endif;

        if (is_null(session('tamanho_id'))) {
            return redirect()
                ->route('loja.montar-pizza.tamanhos', ['slug_store' => $slug_store])
                ->withError('Selecione o tamanho');
        }
        if (is_null(session('bordas_id'))) {
            return redirect()
                ->route('loja.montar-pizza.bordas', ['slug_store' => $slug_store])
                ->withError('Selecione a borda');
        }
        if (is_null(session('sabores_id'))) {
            return redirect()
                ->route('loja.montar-pizza.sabores', ['slug_store' => $slug_store])
                ->withError('Selecione o sabor');
        }

        $store = Store::where('slug_url', $slug_store)->first();
        $adicionais = PizzaAdditional::with('adicional')->whereHas('adicional')->where('store_id', $store->id)->get();
        $valorTamanho = Size::find(session('tamanho_id'))->valor;

        $tBorda = count(session('bordas_id') ?? [1]); //total de bordas
        $tBorda = $tBorda == 0 ? 1 : $tBorda;
        $valorBordas = Edge::whereIn('id', session('bordas_id') ?? [])->sum('valor') / $tBorda;
        $valorSabores = Flavor::whereIn('id', session('sabores_id'))->sum('valor');
        $valorTotal = $valorTamanho + $valorBordas + $valorSabores / count(session('sabores_id') ?? [1]);

        return view('front.loja.montar_pizza.adicionais', compact('store', 'adicionais', 'valorTotal'));
    }

    public function additionalsSave($slug_store, Request $request)
    {
        $data['itens'] = [];
        $data['ids'] = [];
        if (is_array($request->adicionais))
            foreach ($request->adicionais as $key => $item) :
                if (isset($item['qtd']) && $item['qtd'] != '0' && $item['qtd'] != null) :
                    $data['itens'][] = $item;
                    $data['ids'][] = $item['id'];
                endif;
            endforeach;

        $request->session()->put('adicionais', $data);

        return redirect()->route('loja.montar-pizza.revisao', ['slug_store' => $slug_store]);
    }

    /**
     * Verificar se ouve alguma ingrediente deletado
     *
     * @return void
     */
    public function checkDeleted()
    {
        // verificar sabores
        if (is_array(session('sabores_id'))) :
            foreach (session('sabores_id') as $key => $saborId) :
                if (Flavor::find($saborId) == null) :
                    session()->forget('sabores_id');
                    session()->forget('bordas_id');
                    session()->forget('tamanho_id');
                    return true;
                endif;
            endforeach;
        endif;

        // verificar bordas
        if (is_array(session('bordas_id'))) :
            foreach (session('bordas_id') as $key => $bordaId) :
                if (Edge::find($bordaId) == null) :
                    session()->forget('sabores_id');
                    session()->forget('bordas_id');
                    session()->forget('tamanho_id');
                    return true;
                endif;
            endforeach;
        endif;

        if (session('tamanho_id')) :
            if (Size::find(session('tamanho_id')) == null) :
                session()->forget('sabores_id');
                session()->forget('bordas_id');
                session()->forget('tamanho_id');
                return true;
            endif;
        endif;

        return false;
    }

    /**
     * Redireciona para inicio se haver uma modificação nos ingredientes
     *
     * @return void
     */
    public function redirectMod($slug_store)
    {
        return redirect()
            ->route('loja.montar-pizza.tamanhos', ['slug_store' => $slug_store])
            ->withError('Há uma mudança nos ingredientes');
    }
}
