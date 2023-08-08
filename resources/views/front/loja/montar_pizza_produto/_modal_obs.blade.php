<!-- Modal obs -->
<div class="modal fade" id="modal-obs" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
    aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0 px-4">
                <div class="fs-5 text-start fw-semibold">
                    <label for="" class="form-label mb-1 small fw-semibold">
                        Observação:
                    </label>
                    <textarea class="form-control mb-3" name="observacao" id="observacao" maxlength="2000" rows="3"></textarea>

                    <div class="mt-3">
                        <button type="button" class="btn btn-primary px-3" data-bs-dismiss="modal" onclick="addObs()">
                            Salvar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
