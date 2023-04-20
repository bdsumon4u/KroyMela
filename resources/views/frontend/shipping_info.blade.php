@extends('frontend.layouts.app')

@section('content')

    <!-- Steps -->
    <section class="pt-5 mb-4">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 mx-auto">
                    <div class="row gutters-5 sm-gutters-10">
                        <div class="col done">
                            <div class="text-center border border-bottom-6px p-2 text-success">
                                <i class="la-3x mb-2 las la-shopping-cart"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('1. My Cart') }}</h3>
                            </div>
                        </div>
                        <div class="col active">
                            <div class="text-center border border-bottom-6px p-2 text-primary">
                                <i class="la-3x mb-2 las la-map cart-animate" style="margin-right: -100px; transition: 2s;"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block">{{ translate('2. Shipping info') }}
                                </h3>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center border border-bottom-6px p-2">
                                <i class="la-3x mb-2 opacity-50 las la-truck"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50">{{ translate('3. Delivery info') }}
                                </h3>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center border border-bottom-6px p-2">
                                <i class="la-3x mb-2 opacity-50 las la-credit-card"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50">{{ translate('4. Payment') }}</h3>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-center border border-bottom-6px p-2">
                                <i class="la-3x mb-2 opacity-50 las la-check-circle"></i>
                                <h3 class="fs-14 fw-600 d-none d-lg-block opacity-50">{{ translate('5. Confirmation') }}
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
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-xxl-8 col-xl-10 mx-auto">
                    <form class="form-default" data-toggle="validator" action="{{ route('checkout.store_shipping_infostore') }}" role="form" method="POST">
                        @csrf
                        @if(Auth::check())
                            <div class="border bg-white p-4 mb-4">
                                @foreach (Auth::user()->addresses as $key => $address)
                                <div class="border mb-4">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label class="aiz-megabox d-block bg-white mb-0">
                                                <input type="radio" name="address_id" value="{{ $address->id }}" @if ($address->set_default)
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
                                                        {{-- <div class="row">
                                                            <span class="fs-14 text-secondary col-3">{{ translate('Postal Code') }}</span>
                                                            <span class="fs-14 text-dark fw-500 ml-2 col">{{ $address->postal_code }}</span>
                                                        </div> --}}
                                                        <div class="row">
                                                            <span class="fs-14 text-secondary col-3">{{ translate('City') }}</span>
                                                            <span class="fs-14 text-dark fw-500 ml-2 col">{{ optional($address->city)->name }}</span>
                                                        </div>
                                                        <div class="row">
                                                            <span class="fs-14 text-secondary col-3">{{ translate('State') }}</span>
                                                            <span class="fs-14 text-dark fw-500 ml-2 col">{{ optional($address->state)->name }}</span>
                                                        </div>
                                                        <div class="row">
                                                            <span class="fs-14 text-secondary col-3">{{ translate('Country') }}</span>
                                                            <span class="fs-14 text-dark fw-500 ml-2 col">{{ optional($address->country)->name }}</span>
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
                                    <div class="border p-3 c-pointer text-center bg-light has-transition hov-bg-soft-light h-100 d-flex flex-column justify-content-center" onclick="add_new_address()">
                                        <i class="las la-plus la-2x mb-3"></i>
                                        <div class="alpha-7 fw-700">{{ translate('Add New Address') }}</div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="shadow-sm bg-white rounded mb-4">
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

                                    <div class="row d-none">
                                        <div class="col-md-2">
                                            <label>{{ translate('Country')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="mb-3">
                                                <select class="form-control aiz-selectpicker" data-live-search="true" data-placeholder="{{ translate('Select your country') }}" name="country_id" required>
                                                    <option value="">{{ translate('Select your country') }}</option>
                                                    @foreach (\App\Models\Country::where('status', 1)->get() as $key => $country)
                                                        <option value="{{ $country->id }}" @if($country->name == 'Bangladesh') selected @endif>{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{ translate('District')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <select class="form-control mb-3 aiz-selectpicker" data-live-search="true" name="state_id" required>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{ translate('Thana')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <select class="form-control mb-3 aiz-selectpicker" data-live-search="true" name="city_id" required>

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
                                                {{-- <li style="display: none;">Postal Code: <span id="postal_code"></span></li> --}}
                                                <li style="display: none;">Country: <span id="country"></span></li>
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

                                    <input type="hidden" class="form-control mb-3" name="postal_code" value="">
                                </div>
                            </div>
                            <input type="hidden" name="checkout_type" value="guest">
                        @endif
                        <div class="row align-items-center">
                            <!-- Return to shop -->
                            <div class="col-md-6 text-center text-md-left order-1 order-md-0">
                                <a href="{{ route('home') }}" class="btn btn-link fs-14 fw-700 px-0">
                                    <i class="las la-arrow-left fs-16"></i>
                                    {{ translate('Return to shop')}}
                                </a>
                            </div>
                            <!-- Continue to Delivery Info -->
                            <div class="col-md-6 text-center text-md-right">
                                <button type="submit" class="btn btn-primary fs-14 fw-700 rounded-0 px-4">{{ translate('Continue to Delivery Info')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('modal')
    <!-- Address Modal -->
    @include('frontend.partials.address_modal')
@endsection