<div class="text-center py-5">
    @php
        if (isset($min_sabores) == false) {
            $min_sabores = 0;
        }
        if (isset($max_sabores) == false) {
            $max_sabores = 0;
        }
    @endphp
    <!-- prévia da pizza -->
    <style>
        @media (max-width: 768px) {
            .previa-pizza {
                -webkit-transform: scale(.8);
                -ms-transform: scale(.8);
                transform: scale(.8)
            }
        }
    </style>
    <div class="previa-pizza">
        <div class="">
            <div class="circle-pizza" style="">
                <div class="local-pizza">
                    <div class="local-pizza-overflow" id="local-pizza-overflow">
                        <div id="local-pizza-overflow-1">
                            <div class="PizzaContainer">
                                <div class="PizzaBackground"></div>
                                <div id="PizzaSliceYellow" class="hold">
                                    <div class="Pizza">
                                        <div class="img-sabor" id="sabor-1"></div>
                                    </div>
                                </div>
                                <div id="PizzaSliceBlue" class="hold">
                                    <div class="Pizza">
                                        <div class="img-sabor" id="sabor-2"></div>
                                    </div>
                                </div>
                                <div id="PizzaSliceRed" class="hold">
                                    <div class="Pizza">
                                        <div class="img-sabor" id="sabor-3"></div>
                                    </div>
                                </div>
                                <div id="PizzaSliceOlive" class="hold">
                                    <div class="Pizza">
                                        <div class="img-sabor" id="sabor-4"></div>
                                    </div>
                                </div>
                                <div id="PizzaSliceOrange" class="hold">
                                    <div class="Pizza">
                                        <div class="img-sabor" id="sabor-5"></div>
                                    </div>
                                </div>
                                <div id="PizzaSliceLime" class="hold">
                                    <div class="Pizza">
                                        <div class="img-sabor" id="sabor-6"></div>
                                    </div>
                                </div>
                                <div id="PizzaSlicePink" class="hold">
                                    <div class="Pizza">
                                        <div class="img-sabor" id="sabor-7"></div>
                                    </div>
                                </div>
                                <div id="PizzaSliceGray" class="hold">
                                    <div class="Pizza">
                                        <div class="img-sabor" id="sabor-8"></div>
                                    </div>
                                </div>
                                <div id="PizzaSliceInfo" class="hold">
                                    <div class="Pizza">
                                        <div class="img-sabor" id="sabor-9"></div>
                                    </div>
                                </div>
                                <div id="PizzaSliceBlack" class="hold">
                                    <div class="Pizza">
                                        <div class="img-sabor" id="sabor-10"></div>
                                    </div>
                                </div>
                                <div id="PizzaSliceBlue2" class="hold">
                                    <div class="Pizza">
                                        <div class="img-sabor" id="sabor-11"></div>
                                    </div>
                                </div>
                                <div id="PizzaSliceGreen2" class="hold">
                                    <div class="Pizza">
                                        <div class="img-sabor" id="sabor-12"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- ========== Início Script sabores ========== -->
<script>
    var sabores = []
    var saboresSelecionados = []
</script>
@if (session('sabores_id'))
    <script>
        saboresSelecionados = @json(session('sabores_id'))
    </script>
@endif
@foreach ($sabores as $sabor)
    <script>
        sabores[{{ $sabor->id }}] = @json($sabor)
    </script>
@endforeach
<script>
    function setSabor(data, input_checkbox) {
        if (saboresSelecionados.length >= {{ $max_sabores }} && input_checkbox.checked == true) {
            alert(
                'Você pode selecionar no máximo {{ $max_sabores }} {{ $max_sabores > 1 ? 'sabores' : 'sabor' }}'
            );
            input_checkbox.checked = false
            return;
        }

        addSelecionadoInput()

        // adicionar sabor
        if (input_checkbox.checked) {
            addSaborPizza(data)
        } else { // remover sabor
            removerSabor(data.id)
            organizarPizza()
        }
    }

    function removerSabor(id) {
        let indice = saboresSelecionados.indexOf(id);
        if (indice !== -1) {
            saboresSelecionados.splice(indice, 1);
        }
    }

    function addSaborPizza(data) {
        saboresSelecionados.push(data.id)
        organizarPizza()
    }

    function organizarPizza() {

        addSelecionadoInput()
        let totalSelecionados = saboresSelecionados.length

        let totalFatias = 12 / totalSelecionados
        totalFatias = parseInt(totalFatias)

        // hiden pizza
        document.getElementById('local-pizza-overflow-1').classList.add('hidden')

        let inicioLoop = 1;

        // show pizza
        setTimeout(() => {

            // remover as imgs de sabores em prévisualizar
            for (let i = 1; i <= 12; i++) {
                document.getElementById('sabor-' + i).style.background = "transparent"
            }

            for (let i in saboresSelecionados) {

                let b_ini = 1;
                let b_fim = totalFatias;
                let img = null
                for (let b in saboresSelecionados) {

                    for (let x = b_ini; x <= 12; x++) {
                        if (sabores[saboresSelecionados[b]].img == null) {
                            img = "{{ asset('assets/img/pizza/pizza-empty.png') }}";
                        } else {
                            img = "{{ asset('/') }}" + sabores[saboresSelecionados[b]].img;
                        }
                        document.getElementById('sabor-' + x).style.background = `url(${img})`
                    }

                    b_ini = b_fim + 1;
                    b_fim = b_fim + totalFatias
                }
            }
            document.getElementById('local-pizza-overflow-1').classList.remove('hidden')
            setValorTotal()
        }, 200);
    }

    function addSelecionadoInput() {
        document.getElementById('sabores_id').value = JSON.stringify(saboresSelecionados);
    }

    window.onload = function() {
        organizarPizza()
        addSelecionadoInput()
        setValorTotal()
    }
</script>
<!-- ========== Fim Script sabores ========== -->
