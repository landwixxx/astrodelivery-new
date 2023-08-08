@extends('layouts.painel.app')
@section('title', 'Horários de atendimento')
@section('content')
    <br>

    {{-- Alertas --}}
    <x-alerts />

    <div class="container-fluid px-6 mx-auto grid horarios-atendimento">
        <h2 class="my-2 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Horários de atendimento
        </h2>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 w-full overflow-x-auto">

            <!-- Formulário -->
            <form action="{{ route('painel.lojista.horario-atendimento.update') }}" method="post">
                @csrf
                @method('PUT')

                <!-- Horários -->
                <div class="dark:text-gray-200">

                    <!-- Segunda -->
                    <div class="mb-3">
                        <label for="">Segunda-feira</label>
                        <!-- Horários  -->
                        <div class="d-flex gap-3 align-items-center">
                            <div class=" mt-1">
                                <div class="d-flex gap-3 align-items-center">
                                    <input type="time"
                                        class="@error('seg_hora_inicio1') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="seg_hora_inicio1"
                                        value="{{ old('seg_hora_inicio1', $hours->seg->seg_hora_inicio1) }}"
                                        style="max-width: 150px">
                                    às
                                    <input type="time"
                                        class="@error('seg_hora_fim1') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="seg_hora_fim1" value="{{ old('seg_hora_fim1', $hours->seg->seg_hora_fim1) }}"
                                        style="max-width: 150px">
                                </div>
                                @error('seg_hora_inicio1')
                                    <div class="text-danger small fw-bold">{{ $message }}</div>
                                @enderror
                                @error('seg_hora_fim1')
                                    <div class="text-danger small fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Hora opcional -->
                            <div class=" alert alert-warning py-1 m-0 position-relative p-0">
                                <span class="text-muted fs-11px position-absolute "
                                    style="top: -16px; left: 0px">(opcional)</span>
                                <div class=" px-3">
                                    <div class="d-flex gap-3 align-items-center">

                                        <div class="lh-sm">
                                            e de
                                        </div>
                                        <div class=" mt-1">
                                            <div class="d-flex gap-3 align-items-center">
                                                <input type="time"
                                                    class="@error('seg_hora_inicio2') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                                    name="seg_hora_inicio2"
                                                    value="{{ old('seg_hora_inicio2', $hours->seg->seg_hora_inicio2) }}"
                                                    style="max-width: 150px">
                                                às
                                                <input type="time"
                                                    class="@error('seg_hora_fim2') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                                    name="seg_hora_fim2"
                                                    value="{{ old('seg_hora_fim2', $hours->seg->seg_hora_fim2) }}"
                                                    style="max-width: 150px">
                                            </div>
                                        </div>
                                    </div>
                                    @error('seg_hora_inicio2')
                                        <div class="text-danger small fw-bold">{{ $message }}</div>
                                    @enderror
                                    @error('seg_hora_fim2')
                                        <div class="text-danger small fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="">
                                <button type="button" class="btn btn-none text-danger p-1 btn-sm d-flex align-items-center"
                                    onclick="resetInput('seg')">
                                    <span class="material-symbols-outlined">
                                        cancel
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Terça -->
                    <div class="mb-3">
                        <label for="">Terça-feira</label>
                        <!-- Horários  -->
                        <div class="d-flex gap-3 align-items-center">
                            <div class=" mt-1">
                                <div class="d-flex gap-3 align-items-center">
                                    <input type="time"
                                        class="@error('ter_hora_inicio1') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="ter_hora_inicio1"
                                        value="{{ old('ter_hora_inicio1', $hours->ter->ter_hora_inicio1) }}"
                                        style="max-width: 150px">
                                    às
                                    <input type="time"
                                        class="@error('ter_hora_fim1') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="ter_hora_fim1" value="{{ old('ter_hora_fim1', $hours->ter->ter_hora_fim1) }}"
                                        style="max-width: 150px">
                                </div>
                                @error('ter_hora_inicio1')
                                    <div class="text-danger small fw-bold">{{ $message }}</div>
                                @enderror
                                @error('ter_hora_fim1')
                                    <div class="text-danger small fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Hora opcional -->
                            <div class=" alert alert-warning py-1 m-0 position-relative p-0">
                                <span class="text-muted fs-11px position-absolute "
                                    style="top: -16px; left: 0px">(opcional)</span>
                                <div class=" px-3">
                                    <div class="d-flex gap-3 align-items-center">

                                        <div class="lh-sm">
                                            e de
                                        </div>
                                        <div class=" mt-1">
                                            <div class="d-flex gap-3 align-items-center">
                                                <input type="time"
                                                    class="@error('ter_hora_inicio2') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                                    name="ter_hora_inicio2"
                                                    value="{{ old('ter_hora_inicio2', $hours->ter->ter_hora_inicio2) }}"
                                                    style="max-width: 150px">
                                                às
                                                <input type="time"
                                                    class="@error('ter_hora_fim2') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                                    name="ter_hora_fim2"
                                                    value="{{ old('ter_hora_fim2', $hours->ter->ter_hora_fim2) }}"
                                                    style="max-width: 150px">
                                            </div>
                                        </div>
                                    </div>
                                    @error('ter_hora_inicio2')
                                        <div class="text-danger small fw-bold">{{ $message }}</div>
                                    @enderror
                                    @error('ter_hora_fim2')
                                        <div class="text-danger small fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="">
                                <button type="button" class="btn btn-none text-danger p-1 btn-sm d-flex align-items-center"
                                    onclick="resetInput('ter')">
                                    <span class="material-symbols-outlined">
                                        cancel
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Quarta -->
                    <div class="mb-3">
                        <label for="">Quarta-feira</label>
                        <!-- Horários  -->
                        <div class="d-flex gap-3 align-items-center">
                            <div class=" mt-1">
                                <div class="d-flex gap-3 align-items-center">
                                    <input type="time"
                                        class="@error('qua_hora_inicio1') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="qua_hora_inicio1"
                                        value="{{ old('qua_hora_inicio1', $hours->qua->qua_hora_inicio1) }}"
                                        style="max-width: 150px">
                                    às
                                    <input type="time"
                                        class="@error('qua_hora_fim1') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="qua_hora_fim1"
                                        value="{{ old('qua_hora_fim1', $hours->qua->qua_hora_fim1) }}"
                                        style="max-width: 150px">
                                </div>
                                @error('qua_hora_inicio1')
                                    <div class="text-danger small fw-bold">{{ $message }}</div>
                                @enderror
                                @error('qua_hora_fim1')
                                    <div class="text-danger small fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Hora opcional -->
                            <div class=" alert alert-warning py-1 m-0 position-relative p-0">
                                <span class="text-muted fs-11px position-absolute "
                                    style="top: -16px; left: 0px">(opcional)</span>
                                <div class=" px-3">
                                    <div class="d-flex gap-3 align-items-center">

                                        <div class="lh-sm">
                                            e de
                                        </div>
                                        <div class=" mt-1">
                                            <div class="d-flex gap-3 align-items-center">
                                                <input type="time"
                                                    class="@error('qua_hora_inicio2') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                                    name="qua_hora_inicio2"
                                                    value="{{ old('qua_hora_inicio2', $hours->qua->qua_hora_inicio2) }}"
                                                    style="max-width: 150px">
                                                às
                                                <input type="time"
                                                    class="@error('qua_hora_fim2') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                                    name="qua_hora_fim2"
                                                    value="{{ old('qua_hora_fim2', $hours->qua->qua_hora_fim2) }}"
                                                    style="max-width: 150px">
                                            </div>
                                        </div>
                                    </div>
                                    @error('qua_hora_inicio2')
                                        <div class="text-danger small fw-bold">{{ $message }}</div>
                                    @enderror
                                    @error('qua_hora_fim2')
                                        <div class="text-danger small fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="">
                                <button type="button"
                                    class="btn btn-none text-danger p-1 btn-sm d-flex align-items-center"
                                    onclick="resetInput('qua')">
                                    <span class="material-symbols-outlined">
                                        cancel
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Quinta -->
                    <div class="mb-3">
                        <label for="">Quinta-feira</label>
                        <!-- Horários  -->
                        <div class="d-flex gap-3 align-items-center">
                            <div class=" mt-1">
                                <div class="d-flex gap-3 align-items-center">
                                    <input type="time"
                                        class="@error('qui_hora_inicio1') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="qui_hora_inicio1"
                                        value="{{ old('qui_hora_inicio1', $hours->qui->qui_hora_inicio1) }}"
                                        style="max-width: 150px">
                                    às
                                    <input type="time"
                                        class="@error('qui_hora_fim1') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="qui_hora_fim1"
                                        value="{{ old('qui_hora_fim1', $hours->qui->qui_hora_fim1) }}"
                                        style="max-width: 150px">
                                </div>
                                @error('qui_hora_inicio1')
                                    <div class="text-danger small fw-bold">{{ $message }}</div>
                                @enderror
                                @error('qui_hora_fim1')
                                    <div class="text-danger small fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Hora opcional -->
                            <div class=" alert alert-warning py-1 m-0 position-relative p-0">
                                <span class="text-muted fs-11px position-absolute "
                                    style="top: -16px; left: 0px">(opcional)</span>
                                <div class=" px-3">
                                    <div class="d-flex gap-3 align-items-center">

                                        <div class="lh-sm">
                                            e de
                                        </div>
                                        <div class=" mt-1">
                                            <div class="d-flex gap-3 align-items-center">
                                                <input type="time"
                                                    class="@error('qui_hora_inicio2') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                                    name="qui_hora_inicio2"
                                                    value="{{ old('qui_hora_inicio2', $hours->qui->qui_hora_inicio2) }}"
                                                    style="max-width: 150px">
                                                às
                                                <input type="time"
                                                    class="@error('qui_hora_fim2') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                                    name="qui_hora_fim2"
                                                    value="{{ old('qui_hora_fim2', $hours->qui->qui_hora_fim2) }}"
                                                    style="max-width: 150px">
                                            </div>
                                        </div>
                                    </div>
                                    @error('qui_hora_inicio2')
                                        <div class="text-danger small fw-bold">{{ $message }}</div>
                                    @enderror
                                    @error('qui_hora_fim2')
                                        <div class="text-danger small fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Resetar Input -->
                            <div class="">
                                <button type="button"
                                    class="btn btn-none text-danger p-1 btn-sm d-flex align-items-center"
                                    onclick="resetInput('qui')">
                                    <span class="material-symbols-outlined">
                                        cancel
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Sexta -->
                    <div class="mb-3">
                        <label for="">Sexta-feira</label>
                        <!-- Horários  -->
                        <div class="d-flex gap-3 align-items-center">
                            <div class=" mt-1">
                                <div class="d-flex gap-3 align-items-center">
                                    <input type="time"
                                        class="@error('sex_hora_inicio1') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="sex_hora_inicio1"
                                        value="{{ old('sex_hora_inicio1', $hours->sex->sex_hora_inicio1) }}"
                                        style="max-width: 150px">
                                    às
                                    <input type="time"
                                        class="@error('sex_hora_fim1') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="sex_hora_fim1"
                                        value="{{ old('sex_hora_fim1', $hours->sex->sex_hora_fim1) }}"
                                        style="max-width: 150px">
                                </div>
                                @error('sex_hora_inicio1')
                                    <div class="text-danger small fw-bold">{{ $message }}</div>
                                @enderror
                                @error('sex_hora_fim1')
                                    <div class="text-danger small fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Hora opcional -->
                            <div class=" alert alert-warning py-1 m-0 position-relative p-0">
                                <span class="text-muted fs-11px position-absolute "
                                    style="top: -16px; left: 0px">(opcional)</span>
                                <div class=" px-3">
                                    <div class="d-flex gap-3 align-items-center">

                                        <div class="lh-sm">
                                            e de
                                        </div>
                                        <div class=" mt-1">
                                            <div class="d-flex gap-3 align-items-center">
                                                <input type="time"
                                                    class="@error('sex_hora_inicio2') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                                    name="sex_hora_inicio2"
                                                    value="{{ old('sex_hora_inicio2', $hours->sex->sex_hora_inicio2) }}"
                                                    style="max-width: 150px">
                                                às
                                                <input type="time"
                                                    class="@error('sex_hora_fim2') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                                    name="sex_hora_fim2"
                                                    value="{{ old('sex_hora_fim2', $hours->sex->sex_hora_fim2) }}"
                                                    style="max-width: 150px">
                                            </div>
                                        </div>
                                    </div>
                                    @error('sex_hora_inicio2')
                                        <div class="text-danger small fw-bold">{{ $message }}</div>
                                    @enderror
                                    @error('sex_hora_fim2')
                                        <div class="text-danger small fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Resetar Input -->
                            <div class="">
                                <button type="button"
                                    class="btn btn-none text-danger p-1 btn-sm d-flex align-items-center"
                                    onclick="resetInput('sex')">
                                    <span class="material-symbols-outlined">
                                        cancel
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Sábado -->
                    <div class="mb-3">
                        <label for="">Sábado</label>
                        <!-- Horários  -->
                        <div class="d-flex gap-3 align-items-center">
                            <div class=" mt-1">
                                <div class="d-flex gap-3 align-items-center">
                                    <input type="time"
                                        class="@error('sab_hora_inicio1') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="sab_hora_inicio1"
                                        value="{{ old('sab_hora_inicio1', $hours->sab->sab_hora_inicio1) }}"
                                        style="max-width: 150px">
                                    às
                                    <input type="time"
                                        class="@error('sab_hora_fim1') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="sab_hora_fim1"
                                        value="{{ old('sab_hora_fim1', $hours->sab->sab_hora_fim1) }}"
                                        style="max-width: 150px">
                                </div>
                                @error('sab_hora_inicio1')
                                    <div class="text-danger small fw-bold">{{ $message }}</div>
                                @enderror
                                @error('sab_hora_fim1')
                                    <div class="text-danger small fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Hora opcional -->
                            <div class=" alert alert-warning py-1 m-0 position-relative p-0">
                                <span class="text-muted fs-11px position-absolute "
                                    style="top: -16px; left: 0px">(opcional)</span>
                                <div class=" px-3">
                                    <div class="d-flex gap-3 align-items-center">

                                        <div class="lh-sm">
                                            e de
                                        </div>
                                        <div class=" mt-1">
                                            <div class="d-flex gap-3 align-items-center">
                                                <input type="time"
                                                    class="@error('sab_hora_inicio2') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                                    name="sab_hora_inicio2"
                                                    value="{{ old('sab_hora_inicio2', $hours->sab->sab_hora_inicio2) }}"
                                                    style="max-width: 150px">
                                                às
                                                <input type="time"
                                                    class="@error('sab_hora_fim2') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                                    name="sab_hora_fim2"
                                                    value="{{ old('sab_hora_fim2', $hours->sab->sab_hora_fim2) }}"
                                                    style="max-width: 150px">
                                            </div>
                                        </div>
                                    </div>
                                    @error('sab_hora_inicio2')
                                        <div class="text-danger small fw-bold">{{ $message }}</div>
                                    @enderror
                                    @error('sab_hora_fim2')
                                        <div class="text-danger small fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Resetar Input -->
                            <div class="">
                                <button type="button"
                                    class="btn btn-none text-danger p-1 btn-sm d-flex align-items-center"
                                    onclick="resetInput('sab')">
                                    <span class="material-symbols-outlined">
                                        cancel
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Domingo -->
                    <div class="mb-3">
                        <label for="">Domingo</label>
                        <!-- Horários  -->
                        <div class="d-flex gap-3 align-items-center">
                            <div class=" mt-1">
                                <div class="d-flex gap-3 align-items-center">
                                    <input type="time"
                                        class="@error('dom_hora_inicio1') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="dom_hora_inicio1"
                                        value="{{ old('dom_hora_inicio1', $hours->dom->dom_hora_inicio1) }}"
                                        style="max-width: 150px">
                                    às
                                    <input type="time"
                                        class="@error('dom_hora_fim1') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                        name="dom_hora_fim1"
                                        value="{{ old('dom_hora_fim1', $hours->dom->dom_hora_fim1) }}"
                                        style="max-width: 150px">
                                </div>
                                @error('dom_hora_inicio1')
                                    <div class="text-danger small fw-bold">{{ $message }}</div>
                                @enderror
                                @error('dom_hora_fim1')
                                    <div class="text-danger small fw-bold">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Hora opcional -->
                            <div class=" alert alert-warning py-1 m-0 position-relative p-0">
                                <span class="text-muted fs-11px position-absolute "
                                    style="top: -16px; left: 0px">(opcional)</span>
                                <div class=" px-3">
                                    <div class="d-flex gap-3 align-items-center">

                                        <div class="lh-sm">
                                            e de
                                        </div>
                                        <div class=" mt-1">
                                            <div class="d-flex gap-3 align-items-center">
                                                <input type="time"
                                                    class="@error('dom_hora_inicio2') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                                    name="dom_hora_inicio2"
                                                    value="{{ old('dom_hora_inicio2', $hours->dom->dom_hora_inicio2) }}"
                                                    style="max-width: 150px">
                                                às
                                                <input type="time"
                                                    class="@error('dom_hora_fim2') is-invalid @enderror form-control w-full pl-3 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-1 dark:border-none rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                                    name="dom_hora_fim2"
                                                    value="{{ old('dom_hora_fim2', $hours->dom->dom_hora_fim2) }}"
                                                    style="max-width: 150px">
                                            </div>
                                        </div>
                                    </div>
                                    @error('dom_hora_inicio2')
                                        <div class="text-danger small fw-bold">{{ $message }}</div>
                                    @enderror
                                    @error('dom_hora_fim2')
                                        <div class="text-danger small fw-bold">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Resetar Input -->
                            <div class="">
                                <button type="button"
                                    class="btn btn-none text-danger p-1 btn-sm d-flex align-items-center"
                                    onclick="resetInput('dom')">
                                    <span class="material-symbols-outlined">
                                        cancel
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>



                </div>

                <button type="submit"
                    class="btn btn-primary bg-primary mt-3">
                    Salvar
                </button>
            </form>
        </div>
    </div>


@endsection

@section('scripts')
    <script>
        function resetInput(day) {
            let inputs = document.querySelectorAll('input')
            for (let i in inputs) {
                if (inputs[i].name != undefined && inputs[i].name.indexOf(day) != -1)
                    inputs[i].value = '';
            }
        }
    </script>
@endsection
