<style>
    .bg-img-loja {
        background: -webkit-gradient(linear, left top, left bottom, from(rgba(0, 0, 0, .3)), to(rgba(0, 0, 0, .3))), url("{{ asset('storage/' . $store->imagem_bg) }}");
        background: -o-linear-gradient(rgba(0, 0, 0, .3), rgba(0, 0, 0, .3)), url("{{ asset('storage/' . $store->imagem_bg) }}");
        background: linear-gradient(rgba(0, 0, 0, .3), rgba(0, 0, 0, .3)), url("{{ asset('storage/' . $store->imagem_bg) }}");
    }
</style>
<div class="pt-5 mt-5">

    <!-- Banner 1 -->
    <x-loja.banner_1 :store="$store" />

    <div class=" bg-img-loja text-white d-flex align-items-center">
        <div class="container  text-center">
            <span class="display-4 fw-500"> {{ $store->nome }} </span>
            <p class="col-12 col-lg-8 mx-auto  fs-5">
                {{ $store->descricao }}
            </p>
        </div>
    </div>

    <!-- Banner 2 -->
    <x-loja.banner_2 :store="$store" />

</div>
