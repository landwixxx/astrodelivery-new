<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Requests\SendContactRequest;

class SendContactController extends Controller
{
    /**
     * Armazenar dados de contato enviado
     *
     * @param  mixed $request
     * @return void
     */
    public function store(SendContactRequest $request)
    {
        $contact = Contact::create([
            'nome' => $request->nome,
            'meio_contato' => $request->meio_contato,
            'msg' => $request->msg,
        ]);

        return redirect()->back()->with('contact_success', true);
    }
}
