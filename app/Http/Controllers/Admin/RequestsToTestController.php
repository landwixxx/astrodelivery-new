<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\TestOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RequestsToTestController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $testOrders = TestOrder::latest()->paginate(10);
        return view('painel.admin.solicitacoes_teste.index', compact('testOrders'));
    }

    public function makeMainAccount(TestOrder $testOrder)
    {
        $testOrder->user->update([
            'account_expiration' => now()->addYears(100)
        ]);

        $testOrder->delete();
        return redirect()->back()->withSuccess('O registro foi adicionado a lista de lojistas principal');
    }

    public function addExpiredAccount(TestOrder $testOrder)
    {
        $testOrder->user->account_expiration = now()->subSeconds(1);
        $testOrder->user->save();

        return redirect()->back()->withSuccess('O registro foi adicionado como expirado');
    }

    public function destroy(TestOrder $testOrder)
    {
        User::where('email', $testOrder->email)->delete();
        TestOrder::where('email', $testOrder->email)->delete();
        return redirect()->back()->withSuccess('Solicitação removida com sucesso');
    }

    public function markAllRead()
    {
        TestOrder::where('status', 'pendente')->update([
            'status' => 'visualizado'
        ]);
        return redirect()->back()->withSuccess('Todos as solicitações foram visualizados');
    }

    public function markRead(TestOrder $testOrder)
    {
        $testOrder->status = 'visualizado';
        $testOrder->save();
        return back()->withSuccess('Solicitação marcada como visualizada.');
    }
}
