<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoicingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index(Request $request)
    {
        $shopkeepers = User::whereIn('profile', ['lojista']);

        if ($request->has('v'))
            $shopkeepers->where('name', 'like', '%' . $request->v . '%');

        $shopkeepers = $shopkeepers->latest()->paginate(10);

        return view('painel.admin.faturamento.index', compact('shopkeepers'));
    }
}
