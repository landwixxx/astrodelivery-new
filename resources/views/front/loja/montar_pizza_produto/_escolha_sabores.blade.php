 <!-- Escolha os sabores -->
 <div class="col-4 col-lg-4 col-sabores" id="tamanho">
     <div class="border overflow-hidden bg-light rounded-3 p-0 h-100 d-flex flex-column">
         <div class="p-3">
             <h2 class="h6 mb-3 text-center">
                 Escolha os sabores
             </h2>
             <hr>

             <div class="mb-2 text-cesnter">
                 <div class="mb-2">Total de sabores:</div>

                 @for ($i = $min_sabores; $i <= $max_sabores; $i++)
                     <div class="form-check form-check-inline">
                         <input class="form-check-input" type="radio" name="total" id="total-sab-{{ $i }}"
                             value="{{ $i }}" onchange="setTotaSabores({{ $i }})"
                             @if ($i == $min_sabores) checked @endif>
                         <label class="form-check-label" for="total-sab-{{ $i }}">{{ $i }}</label>
                     </div>
                 @endfor
             </div>

             <ul class="list-group list-group-flush " id="lista-sabores-previa">
                 @for ($i = 1; $i <= $min_sabores; $i++)
                     <li class="list-group-item bg-light px-0 pt-3 sabores" id="li-sabor-{{ $i }}">
                         {{ $i }}º Sabor
                         <div class="mt-2">
                             <button type="button"
                                 class="btn btn-sm fw-semibold btn-outline-success rounded-1 gap-1 d-flex align-items-center pb-0 "
                                 onclick="exibirModal({{ $i }})">
                                 Selecionar
                             </button>
                         </div>
                     </li>
                 @endfor
             </ul>
         </div>
     </div>
 </div>
