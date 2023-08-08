<?php

namespace App\Http\Controllers\Api;

use App\Traits\StoreApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiTokenController extends Controller
{
    public $store = null;

    public function __construct(Request $request)
    {
        $this->store = StoreApi::get($request->header('token'));
    }

    public function verificarToken(Request $request)
    {
        return response()->json(['sucesso' => 'Token Verificado']);
    }
}
