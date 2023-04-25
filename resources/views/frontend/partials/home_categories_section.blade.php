@if(get_setting('home_categories') != null) 
    @php $home_categories = json_decode(get_setting('home_categories')); @endphp
    @foreach ($home_categories as $key1 => $value)
        @php $category = \App\Models\Category::find($value); @endphp
        <section class="mb-2 mb-md-3 mt-2 mt-md-3">
            <div class="container">
                <!-- Top Section -->
                <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
                    <!-- Title -->
                    <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                        <span class="">{{ $category->getTranslation('name') }}</span>
                    </h3>
                    <!-- Links -->
                    <div class="d-flex">
                        <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary" href="{{ route('products.category', $category->slug) }}">{{ translate('View All') }}</a>
                    </div>
                </div>
                <!-- Products Section -->
                <div class="row px-3">
                    @foreach (get_cached_products($category->id)->take(12) as $key => $product)
                    <div class="aiz-carousel col-6 col-sm-4 col-md-3 col-lg-3 col-xl-2 col-xxl-2 p-0">
                        <div class="carousel-box p-1 position-relative has-transition hov-animate-outline border-right border-top border-bottom @if($key == 0) border-left @endif">
                            @include('frontend.partials.product_box_1',['product' => $product])
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endforeach
@endif
