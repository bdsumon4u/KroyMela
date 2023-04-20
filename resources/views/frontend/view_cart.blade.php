@extends('frontend.layouts.app')

@section('content')
    <!-- Steps -->
    <section class="pt-5 mb-4">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 mx-auto">
                    <div class="row gutters-5 sm-gutters-10">
                        <div class="col active">
                            <div class="text-center border border-bottom-6px p-2 text-primary">
                                <i class="la-3x mb-2 las la-shopping-cart cart-animate" style="margin-left: -100px; transition: 2s;"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('1. Checkout') }}</h3>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center border border-bottom-6px p-2">
                                <i class="la-3x mb-2 opacity-50 las la-check-circle"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50">{{ translate('2. Confirmation') }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Shipping Info -->
    <section class="mb-4 gry-bg">
        <div class="container">
            <form class="checkout-form" data-toggle="validator" id="checkout-form" action="{{ route('checkout.store_delivery_info') }}" role="form" method="POST">
                @csrf
                <input type="hidden" name="payment_option" value="cash_on_delivery">
                
                <div class="row">
                    @if( $carts && count($carts) > 0 )
                    <div class="col-md-8 mx-auto">
                        <div class="border bg-white p-4 mb-4">
                        @if(Auth::check())
                            @foreach (Auth::user()->addresses as $key => $address)
                            <div class="border mb-4">
                                <div class="row">
                                    <div class="col-md-8">
                                        <label class="aiz-megabox d-block bg-white mb-0">
                                            <input type="radio" name="address_id" value="{{ $address->id }}" city="{{ optional($address->city)->id }}" @if ($address->set_default)
                                                checked
                                            @endif required>
                                            <span class="d-flex p-3 aiz-megabox-elem border-0">
                                                <!-- Checkbox -->
                                                <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                <!-- Address -->
                                                <span class="flex-grow-1 pl-3 text-left">
                                                    <div class="row">
                                                        <span class="fs-14 text-secondary col-3">{{ translate('Address') }}</span>
                                                        <span class="fs-14 text-dark fw-500 ml-2 col">{{ $address->address }}</span>
                                                    </div>
                                                    <div class="row">
                                                        <span class="fs-14 text-secondary col-3">{{ translate('City') }}</span>
                                                        <span class="fs-14 text-dark fw-500 ml-2 col">{{ optional($address->city)->name }}</span>
                                                    </div>
                                                    <div class="row">
                                                        <span class="fs-14 text-secondary col-3">{{ translate('Phone') }}</span>
                                                        <span class="fs-14 text-dark fw-500 ml-2 col">{{ $address->phone }}</span>
                                                    </div>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <!-- Edit Address Button -->
                                    <div class="col-md-4 p-3 text-right">
                                        <a class="btn btn-sm btn-warning text-white mr-4 rounded-0 px-4" onclick="edit_address('{{$address->id}}')">{{ translate('Change') }}</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                            <input type="hidden" name="checkout_type" value="logged">
                            <!-- Add New Address -->
                            <div class="mb-5" >
                                <div class="border p-3 c-pointer text-center bg-light has-transition hov-bg-soft-light d-flex flex-column justify-content-center" onclick="add_new_address()">
                                    <i class="las la-plus la-2x mb-3"></i>
                                    <div class="alpha-7 fw-700">{{ translate('Add New Address') }}</div>
                                </div>
                            </div>
                        @else
                            <div class="p-3">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>{{ translate('Name')}}</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control mb-3" id="name" name="name" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label>{{ translate('Phone')}}</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control mb-3" placeholder="{{ translate('+880')}}" name="phone" value="" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label>{{ translate('Thana')}}</label>
                                    </div>
                                    <div class="col-md-10">
                                        <select class="form-control mb-3 aiz-selectpicker" data-live-search="true" name="city_id" required>
                                            <option value="">{{ translate('Select your city') }}</option>
                                            @foreach (\App\Models\City::where('status', 1)->get() as $key => $city)
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <label>{{ translate('Address')}}</label>
                                    </div>
                                    <div class="col-md-10">
                                        <textarea class="form-control mb-3" placeholder="{{ translate('Your Address')}}" rows="2" name="address" required></textarea>
                                    </div>
                                </div>

                                @if (get_setting('google_map') == 1)
                                    <div class="row">
                                        <input id="searchInput" class="controls" type="text" placeholder="{{translate('Enter a location')}}">
                                        <div id="map"></div>
                                        <ul id="geoData">
                                            <li style="display: none;">Full Address: <span id="location"></span></li>
                                            <li style="display: none;">Latitude: <span id="lat"></span></li>
                                            <li style="display: none;">Longitude: <span id="lon"></span></li>
                                        </ul>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2" id="">
                                            <label for="exampleInputuname">Longitude</label>
                                        </div>
                                        <div class="col-md-10" id="">
                                            <input type="text" class="form-control mb-3" id="longitude" name="longitude" readonly="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2" id="">
                                            <label for="exampleInputuname">Latitude</label>
                                        </div>
                                        <div class="col-md-10" id="">
                                            <input type="text" class="form-control mb-3" id="latitude" name="latitude" readonly="">
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <input type="hidden" name="checkout_type" value="guest">
                            @endif

                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('Any additional info?') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea name="additional_info" rows="5" class="form-control" placeholder="{{ translate('Type your text') }}"></textarea>
                                </div>
                            </div>
                            <input type="hidden" class="form-control mb-3" name="postal_code" value="">


                            {{-- ... --}}
                            <div class="pt-3">
                                <label class="aiz-checkbox">
                                    <input type="checkbox" required id="agree_checkbox" checked>
                                    <span class="aiz-square-check"></span>
                                    <span>{{ translate('I agree to the') }}</span>
                                </label>
                                <a href="{{ route('terms') }}">{{ translate('terms and conditions') }}</a>,
                                <a href="{{ route('returnpolicy') }}">{{ translate('return policy') }}</a> &
                                <a href="{{ route('privacypolicy') }}">{{ translate('privacy policy') }}</a>
                            </div>

                            <div class="row align-items-center pt-3">
                                <div class="col-6">
                                    <a href="{{ route('home') }}" class="link link--style-3">
                                        <i class="las la-arrow-left"></i>
                                        {{ translate('Return to shop') }}
                                    </a>
                                </div>
                                <div class="col-6 text-right">
                                    <button type="button" onclick="submitOrder(this)"
                                        class="btn btn-primary fw-600">{{ translate('Complete Order') }}</button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Cart Details -->
                        <section class="mb-4" id="cart-summary">
                            @include('frontend.partials.cart_details', ['carts' => $carts])
                        </section>
                    </div>
                    @endif
                    <div class="col-md-4 mx-auto">
                        <div id="cart_summary">
                            @include('frontend.partials.cart_summary')
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

@endsection

{{-- Pagol --}}
<!-- New Address Modal -->
<div class="modal fade" id="new-address-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ translate('New Address') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-default" role="form" action="{{ route('addresses.store') }}" method="POST">
                @csrf
                <div class="modal-body c-scrollbar-light">
                    <div class="p-3">
                        <!-- Address -->
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('Address')}}</label>
                            </div>
                            <div class="col-md-10">
                                <textarea class="form-control mb-3 rounded-0" placeholder="{{ translate('Your Address')}}" rows="2" name="address" required></textarea>
                            </div>
                        </div>

                        <!-- City -->
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('City')}}</label>
                            </div>
                            <div class="col-md-10">
                                <select class="form-control mb-3 aiz-selectpicker rounded-0" data-live-search="true" name="city_id" required>
                                    <option value="">{{ translate('Select your city') }}</option>
                                    @foreach (\App\Models\City::where('status', 1)->get() as $key => $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @if (get_setting('google_map') == 1)
                            <!-- Google Map -->
                            <div class="row mt-3 mb-3">
                                <input id="searchInput" class="controls" type="text" placeholder="{{translate('Enter a location')}}">
                                <div id="map"></div>
                                <ul id="geoData">
                                    <li style="display: none;">Full Address: <span id="location"></span></li>
                                    <li style="display: none;">Latitude: <span id="lat"></span></li>
                                    <li style="display: none;">Longitude: <span id="lon"></span></li>
                                </ul>
                            </div>
                            <!-- Longitude -->
                            <div class="row">
                                <div class="col-md-2" id="">
                                    <label for="exampleInputuname">{{ translate('Longitude')}}</label>
                                </div>
                                <div class="col-md-10" id="">
                                    <input type="text" class="form-control mb-3 rounded-0" id="longitude" name="longitude" readonly="">
                                </div>
                            </div>
                            <!-- Latitude -->
                            <div class="row">
                                <div class="col-md-2" id="">
                                    <label for="exampleInputuname">{{ translate('Latitude')}}</label>
                                </div>
                                <div class="col-md-10" id="">
                                    <input type="text" class="form-control mb-3 rounded-0" id="latitude" name="latitude" readonly="">
                                </div>
                            </div>
                        @endif

                        <!-- Phone -->
                        <div class="row">
                            <div class="col-md-2">
                                <label>{{ translate('Phone')}}</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control mb-3 rounded-0" placeholder="{{ translate('+880')}}" name="phone" value="" required>
                            </div>
                        </div>
                        <!-- Save button -->
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary rounded-0 w-150px">{{translate('Save')}}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Address Modal -->
<div class="modal fade" id="edit-address-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ translate('New Address') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body c-scrollbar-light" id="edit_modal_body">

            </div>
        </div>
    </div>
</div>
{{-- Pagol --}}
@section('script')
    <script type="text/javascript">
        AIZ.extra.plusMinus();

        function add_new_address(){
            $('#new-address-modal').modal('show');
        }

        function edit_address(address) {
            var url = '{{ route("addresses.edit", ":id") }}';
            url = url.replace(':id', address);
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: 'GET',
                success: function (response) {
                    $('#edit_modal_body').html(response.html);
                    $('#edit-address-modal').modal('show');
                    AIZ.plugins.bootstrapSelect('refresh');

                    @if (get_setting('google_map') == 1)
                        var lat     = -33.8688;
                        var long    = 151.2195;

                        if(response.data.address_data.latitude && response.data.address_data.longitude) {
                            lat     = parseFloat(response.data.address_data.latitude);
                            long    = parseFloat(response.data.address_data.longitude);
                        }

                        initialize(lat, long, 'edit_');
                    @endif
                }
            });
        }

        var minimum_order_amount_check = {{ get_setting('minimum_order_amount_check') == 1 ? 1 : 0 }};
        var minimum_order_amount =
            {{ get_setting('minimum_order_amount_check') == 1 ? get_setting('minimum_order_amount') : 0 }};
        function submitOrder(el) {
            $(el).prop('disabled', true);
            if ($('#agree_checkbox').is(":checked")) {
                if (minimum_order_amount_check && $('#sub_total').val() < minimum_order_amount) {
                    AIZ.plugins.notify('danger',
                        '{{ translate('You order amount is less then the minimum order amount') }}');
                } else {
                    var offline_payment_active = '{{ addon_is_activated('offline_payment') }}';
                    if (offline_payment_active == 'true' && $('.offline_payment_option').is(":checked") && $('#trx_id')
                        .val() == '') {
                        AIZ.plugins.notify('danger',
                            '{{ translate('You need to put Transaction id') }}');
                        $(el).prop('disabled', false);
                    } else {
                        $('#checkout-form').submit();
                    }
                }
            } else {
                AIZ.plugins.notify('danger', '{{ translate('You need to agree with our policies') }}');
                $(el).prop('disabled', false);
            }
        }

        $(document).on('change', '[name=city_id]', function() {
            var city_id = $(this).val();
            $.get('{{ url()->current() }}', {
                city_id,
            }, function(data){
                $('#cart_summary').html(data.cart_summary);
            });
        });

        $(document).on('change', '[name=address_id]', function() {
            var city_id = $(this).attr('city');
            $.get('{{ url()->current() }}', {
                city_id,
            }, function(data){
                $('#cart_summary').html(data.cart_summary);
            });
        });

        function removeFromCartView(e, key) {
            e.preventDefault();
            removeFromCart(key);
        }

        function updateQuantity(key, element) {
            $.post('{{ route('cart.updateQuantity') }}', {
                _token: AIZ.data.csrf,
                id: key,
                quantity: element.value
            }, function(data) {
                updateNavCart(data.nav_cart_view, data.cart_count);
                $('#cart-summary').html(data.cart_view);
                AIZ.extra.plusMinus(); // IMPORTANT
            });

            $.get('{{ url()->current() }}', {
                city_id: $('[name="city_id"]').val() ?? $('[name="address_id"]').attr('city') ?? 0,
            }, function(data){
                $('#cart_summary').html(data.cart_summary);
            });
        }

        function showLoginModal() {
            $('#login_modal').modal();
        }
    </script>

    @if (get_setting('google_map') == 1)
        @include('frontend.partials.google_map')
    @endif
@endsection
