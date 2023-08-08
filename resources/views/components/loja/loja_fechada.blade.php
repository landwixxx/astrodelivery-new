    <!-- Modal loja fechada -->
    <div class="modal fade" id="modal-loja-fechada" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId"><i
                            class="fa-solid fa-triangle-exclamation fa-sm text-warning"></i> Fechado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    No momento estamos fechados, mas você pode visualizar nossos produtos e voltar em outra hora
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary fw-semiboldd d-flex align-items-center"
                        data-bs-dismiss="modal" id="fechar-modal-loja-fechada">OK</button>
                </div>
            </div>
        </div>
    </div>

    @if ($store->empresa_aberta == 'nao')
        <!-- Ativar modal loja fechada -->
        @if (session('abrir_modal_loja_fechada'))
            <script>
                const myModal = new bootstrap.Modal(document.getElementById('modal-loja-fechada'))
                myModal.show();
            </script>
        @else
            <script>
                if (document.cookie.indexOf('loja_fechada=true') === -1) {
                    const myModal = new bootstrap.Modal(document.getElementById('modal-loja-fechada'))
                    myModal.show();
                }
            </script>
        @endif
    @endif
