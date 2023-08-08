<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $contacts = Contact::latest()->paginate(10);
        return view('painel.admin.contatos.index', compact('contacts'));
    }

    public function destroy(Contact $contato)
    {
        $contato->delete();
        return redirect()->back()->withSuccess('Contato removido com sucesso');
    }

    public function markAllRead()
    {
        Contact::where('status', 'pendente')->update([
            'status' => 'visualizado'
        ]);
        return redirect()->back()->withSuccess('Todos os contatos foram visualizados');
    }

    public function markRead(Contact $contato)
    {
        $contato->status = 'visualizado';
        $contato->save();
        return back()->withSuccess('Contato marcado como lido.');
    }
}
