@php
    $banner3 = $store
        ->promotional_banners()
        ->where('posicao', 3)
        ->where('status', 'ativo')
        ->first();
@endphp
@if (!is_null($banner3))
    <!-- Banner 2 -->
    <div class="text-center mb-4 mb-lg-5">
        <a href="{{ $banner3->link }}" class="">
            <img src="{{ asset($banner3->img) }}" alt="" class="banner">
        </a>
    </div>
@endif
