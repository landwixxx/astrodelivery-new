<!-- Alerta de sucesso com bootstrap -->
@if (session('info'))
    <div class="alert alert-warning alert-dismissible fade show fw-bold mb-3 mb-4" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

        <i class="fa-solid fa-triangle-exclamation fa-lg me-2"></i>
        {!! session('info') !!}
    </div>
@endif
