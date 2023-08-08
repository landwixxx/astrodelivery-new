<!-- Modal selecionar sabores -->
<div class="modal fade" id="modal-selecionar-categoria" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="" id="text-modal-categoria"></span>° Sabor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4 pt-2">
                <!-- Categorias -->
                <div class="row gy-3 py-2">

                    @foreach ($listaCat as $key => $item)
                        <div class="col-12 col-lg-4">
                            <div class="card card-body-opcoes-sabores overflow-hidden shadow">
                                <a href="#" class="text-decoration-none text-dark"
                                    onclick="setCategoriaSelecionada({{ $key }})">
                                    <div class="card-body position-relative">
                                        <i class="fa-solid fa-pizza-slice  "
                                            style="position: absolute; left: 8px; bottom: 8px; font-size: 20px; opacity: .1"></i>

                                        <div class="d-flex gap-2 align-itemss-center flex-column text-center">
                                            <div class="w-100">
                                                <h5 class="card-title pt-1">
                                                    {{ $item['categoria'] }}
                                                </h5>
                                                <p class="card-text mb-0 pb-0">
                                                    {{ count($item['itens']) }}
                                                    @if (count($item['itens']) == 0)
                                                        Opção
                                                    @else
                                                        Opções
                                                    @endif
                                                </p>

                                            </div>

                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer d-none">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
