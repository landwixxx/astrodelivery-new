<div class="container mt-5">
    <form action="{{ route('loja.index', $store->slug_url) }}" method="get">
        <div class="col-12 col-lg-4 mx-auto">
            <div class="input-group mb-3 shadow-sm rounded-3 ">
                <input name="s" type="search" class="form-control border border-end-0 shadow-none  py-2 ps-3"
                    placeholder="Procurar por produtos" value="{{ request()->get('s') }}">
                <button class="btn btn-white border border-start-0 d-flex align-items-center py-2 pe-3" type="submit"
                    id="button-addon2">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </div>
    </form>
</div>
