<!-- Alerta de sucesso com bootstrap -->
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show fw-bold mb-3 mb-4" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

        <i class="fa-solid fa-triangle-exclamation fa-lg me-2"></i>
        {!! session('error') !!}
    </div>
@endif
