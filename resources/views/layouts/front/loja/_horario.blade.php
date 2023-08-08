<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvas-horario"
    aria-labelledby="Enable both scrolling & backdrop">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="Enable both scrolling & backdrop">Horário de atendimento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="list-group list-group-flush">
            @php
                $dias = $store
                    ->opening_hours()
                    ->get(['seg', 'ter', 'qua', 'qui', 'sex', 'sab', 'dom'])
                    ->first();
                    $dias= is_null($dias) ? [] : $dias->toArray();
                $dias_da_semana = [
                    'seg' => 'Segunda-Feira',
                    'ter' => 'Terça-Feira',
                    'qua' => 'Quarta-Feira',
                    'qui' => 'Quinta-Feira',
                    'sex' => 'Sexta-Feira',
                    'sab' => 'Sábado',
                    'dom' => 'Domingo',
                ];
                $numero_dias_da_semana = [
                    'seg' => 1,
                    'ter' => 2,
                    'qua' => 3,
                    'qui' => 4,
                    'sex' => 5,
                    'sab' => 6,
                    'dom' => 7,
                ];
            @endphp
            @foreach ($dias as $key => $horarios)
                @php
                    $horarios = (array) json_decode($horarios);
                    $hora_inicio_1 = $horarios[$key . '_hora_inicio1'];
                    $hora_fim_1 = $horarios[$key . '_hora_fim1'];
                    $hora_inicio_2 = $horarios[$key . '_hora_inicio2'];
                    $hora_fim_2 = $horarios[$key . '_hora_fim2'];
                @endphp
                @if ($hora_inicio_1 && $hora_fim_1)
                    <li
                        class="list-group-item d-flex justify-content-between fw-500 flex-column 
                        @if ($numero_dias_da_semana[$key] == date('N')) border rounded-3 border-1  border-danger border-bottdom-0 text-danger @endif">

                        <div class="fs-18px d-flex align-items-center gap-1">
                            <!-- Ícones -->
                            @if ($numero_dias_da_semana[$key] == date('N'))
                                <i class="fa-regular fa-calendar-check fs-12px me-1"></i>
                            @else
                                <i class="fa-regular fa-calendar fs-12px me-1"></i>
                            @endif
                            <!-- Dia da semana -->
                            {{ $dias_da_semana[$key] }}
                        </div>
                        <!-- Horários -->
                        <div class="fw-light">
                            De <span class="fw-bold"> {{ $hora_inicio_1 }}</span> às <span class="fw-bold">{{ $hora_fim_1 }} </span>
                            @if ($hora_inicio_2 && $hora_fim_2)
                                e de <span class="fw-bold"> {{ $hora_inicio_2 }}</span> às  <span class="fw-bold">{{ $hora_fim_2 }} </span>
                            @endif
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
