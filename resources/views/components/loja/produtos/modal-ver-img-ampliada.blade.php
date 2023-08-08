<!-- Modal exibir img -->
<div class="modal-exibir-img d-none align-items-center justify-content-center p-3" id="modal-exibir-img">
    <!-- Close -->
    <button type="button" onclick="fecharPreviaIMG()"
        class="btn btn-light modal-img-close d-flex align-items-center justify-content-center p-0 border-0"
        title="Fechar">
        <i class="fa-solid fa-xmark textg-white fs-5"></i>
    </button>
    <!-- Conteúdo -->
    <div class="modal-contente bg-white shadow col-12 col-md-6 p-0 bg-white text-center p-2 overflow-hidden "
        style="max-height: 90vh">
        <img src="{{ asset('assets/img/ilu-cardapio.png') }}" alt="" class="mx-auto" id="exibir-img-modal">
    </div>
</div>