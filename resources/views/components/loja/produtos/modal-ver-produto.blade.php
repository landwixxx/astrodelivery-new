<!-- Modal Adicionar Produto -->
<div class="modal fade" id="modal-add-produto" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">

        <div class="modal-content ">
            <div class="modal-header border-0 p-3">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 px-4 pt-3 pb-0 scroll-width-6px">
                <!-- conteúdo produto -->
                <div class="row gy-3 px-1" id="modal-conteudo">
                    <!-- Imagem -->
                    <div class="col-12 col-lg-6">
                        <div class="img-produdo">
                            <img src="{{ asset('assets/img/ilu-cardapio.png') }}" id="modal-img-produto" alt="" class="w-100" style="cursor: pointer" onclick="abrirPreviaIMG(this)">
                        </div>

                        <!-- Imagens -->
                        <div class="row mt-4 align-items-center" id="imagens-produto-selecionado">
                            <!-- min imagens -->
                        </div>
                    </div>
                    <!-- Dados -->
                    <div class="col-12 col-lg-6">
                        <input type="hidden" id="modal-id-produto">
                        <input type="hidden" id="modal-store-produto" value="{{$store->slug_url}}">
                        <!-- Título e descrição -->
                        <div class="">
                            <h4 class="h4" id="modal-titulo-produto">
                                <!-- título -->
                            </h4>
                            <p class="" id='modal-descricao-produto'>
                                <!-- descrição -->
                            </p>

                        </div>

                        <div class="mb-4" id="modal-adicionais">
                            <!-- Adicionais -->
                        </div>

                        <div class="pb-4">
                            <h5 class="h6 fw-semibold text-muted pt-2 fs-14px">Observação (opcional)</h5>
                            <textarea class="form-control border" id="modal-observacao" rows="3"></textarea>
                        </div>

                        <!-- Footer -->
                        <div class="sticky-bottom bg-white pb-4 pt-1">
                            <div class="">

                                <div class="d-flex justify-content-between align-items-center mb-2 pt-3">
                                    <!-- Total -->
                                    <div class="">
                                        <div class="input-group input-group-sm" style="max-width: 100px">
                                            <!-- Subtrair -->
                                            <button type="button" class="btn btn-light border d-flex align-items-center text-danger">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                            <input type="text" class="form-control shadow-none text-center fs-5 py-0" value="1" readonly>
                                            <button type="button" class="btn btn-light border d-flex align-items-center text-danger">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="fs-4 fw-700 font-open-sans" id="modal-preco-produto">
                                    </div>
                                </div>
                            </div>
                            <a class="btn btn-primary w-100 fw-600" data-bs-dismiss="modal" onclick="add_carrinho()">Adicionar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>