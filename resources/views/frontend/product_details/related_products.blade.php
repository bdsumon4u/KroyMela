<div class="bg-white border">
    <div class="p-3 p-sm-4">
        <h3 class="fs-16 fw-700 mb-0">
            <span class="mr-4">{{ translate('Related products') }}</span>
        </h3>
    </div>
    <div class="px-4">
        <div class="row">
            @foreach (filter_products(\App\Models\Product::where('category_id', $detailedProduct->category_id))->limit(12)->get() as $key => $product)
                <div class="aiz-carousel col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 col-xxl-2 p-0">
                    <div class="carousel-box p-1 position-relative has-transition hov-animate-outline border-right border-top border-bottom @if($key == 0) border-left @endif">
                        @include('frontend.partials.product_box_1',['product' => $product])
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>