@php
    $banner1 = $store
        ->promotional_banners()
        ->where('posicao', 1)
        ->where('status', 'ativo')
        ->first();
@endphp
@if (!is_null($banner1))
    <!-- Banner 1 -->
    <div class="text-center mb-3 mb-lg-5">
        <a href="{{ $banner1->link }}" class="">
            <img src="{{ asset($banner1->img) }}" alt="" class="banner">
        </a>
    </div>
@endif
