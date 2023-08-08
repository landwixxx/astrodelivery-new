<footer>
    <div class="text-white">
        <div class="container py-5 pb-3 text-center">

            <div class="row text-start">
                <div class="col-12 col-lg-4">
                    &copy; {{ date('Y') }} Astro Delivery - Todos os direitos reservados
                </div>
                <div class="col-12 col-lg-3">
                    <h4 class="mb-3 small fw-600 text-uppercase">Astro Delivery</h4>
                    <ul class="list-unstyled">
                        <li class="my-2">
                            <a href="{{ env('APP_URL') }}" class="text-decoration-none text-white">Conheça o
                                Astro Delivery</a>
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-lg-3">
                    <h4 class="mb-3 small fw-600 text-uppercase">Redes Sociais -
                        {{ $store->nome }}</h4>
                    <div class="d-flex gap-2">
                        <a href="{{ $store->url_facebook }}" target="_blank" title="Facebook" class="link-light fs-5"><i
                                class="fa-brands fa-facebook fa-lg"></i></a>
                        <a href="{{ $store->url_twitter }}" target="_blank" title="Twitter" class="link-light fs-5"><i
                                class="fa-brands fa-twitter fa-lg"></i></a>
                        <a href="{{ $store->url_instagram }}" target="_blank" title="Instagram"
                            class="link-light fs-5"><i class="fa-brands fa-instagram fa-lg"></i></a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</footer>
