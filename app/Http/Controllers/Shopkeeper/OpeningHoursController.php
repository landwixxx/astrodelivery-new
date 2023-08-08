<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Http\Controllers\Controller;
use App\Models\OpeningHours;
use Illuminate\Http\Request;

class OpeningHoursController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:lojista|funcionario', 'can:horario atendimento']);
    }

    public function index()
    {
        /* Se não tiver dados de loja */
        if (!isset(auth()->user()->store_has_user->store->id))
            return redirect()
                ->route('painel.lojista.configuracoes')
                ->withErro('Você precisa adicionar os dados da sua loja primeiro.');

        $hours = $this->getHours();
        return view('painel.lojista.horario_atendimento', compact('hours'));
    }

    /**
     * Obeter horários de atendimentos
     *
     * @return object
     */
    public function getHours(): object
    {
        $store = auth()->user()->store_has_user->store;
        $hours = [];

        /* Se tiver horários cadastrados */
        if ($store->opening_hours) :
            foreach ($store->opening_hours->toArray() as $key => $day) {
                $hours[$key] = json_decode($day);
            }
        else :
            foreach (['seg', 'ter', 'qua', 'qui', 'sex', 'sab', 'dom'] as $key => $day) {
                $hours[$day] = (object) [
                    $day . '_hora_inicio1' => null,
                    $day . '_hora_fim1' => null,
                    $day . '_hora_inicio2' => null,
                    $day . '_hora_fim2' => null,
                ];
            }
        endif;

        return (object) $hours;
    }

    public function updateHours(Request $request)
    {
        $validate = [];
        foreach (['seg', 'ter', 'qua', 'qui', 'sex', 'sab', 'dom'] as $day) {
            $validate['rules'][$day . '_hora_inicio1'] = ['nullable', 'date_format:H:i'];
            $validate['rules'][$day . '_hora_fim1'] = ['nullable', 'date_format:H:i', 'after:' . $day . '_hora_inicio1'];
            $validate['rules'][$day . '_hora_inicio2'] = ['nullable', 'date_format:H:i'];
            $validate['rules'][$day . '_hora_fim2'] = ['nullable', 'date_format:H:i', 'after:' . $day . '_hora_inicio2'];

            $validate['attributes'][$day . '_hora_inicio1'] = 'hora inicial';
            $validate['attributes'][$day . '_hora_fim1'] = 'hora final';
            $validate['attributes'][$day . '_hora_inicio2'] = 'hora inicial';
            $validate['attributes'][$day . '_hora_fim2'] = 'hora final';
        }

        $request->validate(
            $validate['rules'],
            [],
            $validate['attributes'],
        );

        $this->createHours($request);

        return redirect()->back()->withSuccess('Horários atualizados com sucesso.');
    }

    public function createHours($request)
    {
        $data = [];
        foreach (['seg', 'ter', 'qua', 'qui', 'sex', 'sab', 'dom'] as $day) {
            $hours = [
                $day . '_hora_inicio1' => $request->input($day . '_hora_inicio1'),
                $day . '_hora_fim1' => $request->input($day . '_hora_fim1'),
                $day . '_hora_inicio2' => $request->input($day . '_hora_inicio2'),
                $day . '_hora_fim2' => $request->input($day . '_hora_fim2'),
            ];
            $data[$day] = json_encode($hours);
        }

        $store = auth()->user()->store_has_user->store;
        $data['store_id'] = $store->id;

        $result = OpeningHours::updateOrCreate(
            ['store_id' => $store->id],
            $data
        );

        return $result;
    }
}
