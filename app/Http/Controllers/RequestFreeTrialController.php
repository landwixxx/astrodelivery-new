<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TestOrder;
use App\Mail\SendLoginTest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ShopkeeperToken;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RequestFreeTrialRequest;

class RequestFreeTrialController extends Controller
{
    /**
     * Formulário para envio de solicitações para teste
     *
     * @return void
     */
    public function index()
    {
        return view('front.solicitar_teste.index');
    }

    /**
     * Armazenar dados de solicitações para teste
     *
     * @param  mixed $request
     * @return void
     */
    public function store(RequestFreeTrialRequest $request)
    {
        $pass = Str::random(8);
        $userTest = User::create([
            'name' => $request->nome,
            'email' => $request->email,
            'password' => bcrypt($pass),
            'account_expiration' => now()->addDays(7),
            'profile' => 'lojista'
        ])->assignRole('lojista');

        $test = (new TestOrder)->fill($request->all());
        $test->user_id = $userTest->id;
        $test->save();

        // Criar token para API
        $token = 'TOKEN-' . Str::random(20) . '-' . Str::random(20) . '-' . Str::random(20);
        if (ShopkeeperToken::where('token', $token)->exists()) {
            $token .= '-' . time();
        }
        ShopkeeperToken::create([
            'token' => $token,
            'lojista_id' => $userTest->id
        ]);

        Mail::to($userTest->email)->send(new SendLoginTest($userTest, $pass));

        return back()->withSuccess(true);
    }
}
