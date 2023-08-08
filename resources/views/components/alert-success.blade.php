<!-- Alerta de sucesso com bootstrap -->
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show fw-bold mb-3 mb-4" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

        <i class="fa-regular fa-circle-check fa-lg me-2"></i>
        {!! session('success') !!}
    </div>
@endif
