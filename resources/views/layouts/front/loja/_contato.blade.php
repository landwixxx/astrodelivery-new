<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvas-contato"
    aria-labelledby="Enable both scrolling & backdrop">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title fs-6" id="Enable both scrolling & backdrop">Meios de contato</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="text-centder lh-1">
            <div class="text-muted small fw-600">E-mail</div>
            <div class="fs-4 fw-bold mb-3">
                {{ $store->email }}
                <a href="mailto:{{ $store->email }}" target="_blank" class="small" title="Conversar">
                    <i class="fa-solid fa-arrow-up-right-from-square fa-sm"></i>
                </a>
            </div>
            <div class="text-muted small fw-600">Telefone</div>
            <div class="fs-4 fw-bold mb-3">
                {{ str_replace(')', ') ', $store->telefone) }}
                {{-- <a href="tel:+55{{ str_replace(['(', ')', '-', ' '], [''], $store->telefone) }}" target="_blank"
                    class="small" title="Conversar">
                    <i class="fa-solid fa-arrow-up-right-from-square fa-sm"></i>
                </a> --}}
            </div>
            <div class="text-muted small fw-600">WhatsApp</div>
            <div class="fs-4 fw-bold mb-3">
                {{ str_replace(')', ') ', $store->whatsapp) }}
                <a href="https://wa.me/55{{ str_replace(['(', ')', '-', ' '], [''], $store->whatsapp) }}"
                    target="_blank" class="small" title="Conversar">
                    <i class="fa-solid fa-arrow-up-right-from-square fa-sm"></i>
                </a>
            </div>
        </div>
    </div>
</div>
