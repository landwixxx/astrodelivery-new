@php
    $banner2 = $store
        ->promotional_banners()
        ->where('posicao', 2)
        ->where('status', 'ativo')
        ->first();
@endphp
@if (!is_null($banner2))
    <!-- Banner 2 -->
    <div class="text-center mt-3 mt-lg-5">
        <a href="{{ $banner2->link }}" class="">
            <img src="{{ asset($banner2->img) }}" alt="" class="banner">
        </a>
    </div>
@endif
