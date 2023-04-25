<!-- Top Bar Banner -->
@if(get_setting('topbar_banner') != null)
<div class="position-relative top-banner removable-session z-1035 d-none" data-key="top-banner" data-value="removed">
    <a href="{{ get_setting('topbar_banner_link') }}" class="d-block text-reset">
        <img src="{{ uploaded_asset(get_setting('topbar_banner')) }}" class="d-none d-xl-block img-fit"> <!-- For Large device -->
        <img src="{{ get_setting('topbar_banner_medium') != null ? uploaded_asset(get_setting('topbar_banner_medium')) : uploaded_asset(get_setting('topbar_banner')) }}" class="d-none d-md-block d-xl-none img-fit"> <!-- For Medium device -->
        <img src="{{ get_setting('topbar_banner_small') != null ? uploaded_asset(get_setting('topbar_banner_small')) : uploaded_asset(get_setting('topbar_banner')) }}" class="d-md-none img-fit"> <!-- For Small device -->
    </a>
    <button class="btn text-white h-100 absolute-top-right set-session" data-key="top-banner" data-value="removed" data-toggle="remove-parent" data-parent=".top-banner">
        <i class="la la-close la-2x"></i>
    </button>
</div>
@endif

<!-- Top Bar -->
<div class="top-navbar z-1035 h-35px h-sm-auto" style="background-color: #008acf;">
    <div class="container">
        <div class="row">
            <div class="col">
                <ul class="list-inline d-flex justify-content-between mb-0 align-items-center">
                    <li class="list-inline-item dropdown mr-2" id="lang-change">
                        <a href="{{ route(auth()->check() ? (isAdmin() ? 'admin.dashboard' : 'dashboard') : 'user.login') }}" class="text-white fs-12 py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" height="20" width="20"><path d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H18C18 18.6863 15.3137 16 12 16C8.68629 16 6 18.6863 6 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13ZM12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11Z"></path></svg>
                        </a>
                    </li>
                    <!-- Language switcher -->
                    @if(get_setting('show_language_switcher') == 'on')
                    <li class="list-inline-item dropdown mr-2" id="lang-change">
                        @php
                            if(Session::has('locale')){
                                $locale = Session::get('locale', Config::get('app.locale'));
                            }
                            else{
                                $locale = 'en';
                            }
                        @endphp
                        <a href="javascript:void(0)" class="dropdown-toggle text-white fs-12 py-2" data-toggle="dropdown" data-display="static">
                            <span class="">{{ \App\Models\Language::where('code', $locale)->first()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            @foreach (\App\Models\Language::where('status', 1)->get() as $key => $language)
                                <li>
                                    <a href="javascript:void(0)" data-flag="{{ $language->code }}" class="dropdown-item @if($locale == $language) active @endif">
                                        <img src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" class="mr-1 lazyload" alt="{{ $language->name }}" height="11">
                                        <span class="language">{{ $language->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif

                    <!-- Currency Switcher -->
                    @if(get_setting('show_currency_switcher') == 'on')
                    <li class="list-inline-item dropdown ml-auto ml-lg-0 mr-0" id="currency-change">
                        @php
                            if(Session::has('currency_code')){
                                $currency_code = Session::get('currency_code');
                            }
                            else{
                                $currency_code = \App\Models\Currency::findOrFail(get_setting('system_default_currency'))->code;
                            }
                        @endphp
                        <a href="javascript:void(0)" class="dropdown-toggle text-white fs-12 py-2" data-toggle="dropdown" data-display="static">
                            {{ \App\Models\Currency::where('code', $currency_code)->first()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                            @foreach (\App\Models\Currency::where('status', 1)->get() as $key => $currency)
                                <li>
                                    <a class="dropdown-item @if($currency_code == $currency->code) active @endif" href="javascript:void(0)" data-currency="{{ $currency->code }}">{{ $currency->name }} ({{ $currency->symbol }})</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif
                    <li class="list-inline-item dropdown mr-2" id="lang-change">
                        <div class="d-flex align-items-center">
                            <marquee class="text-white fw-800">{{ get_setting('topbar_scroll') }}</marquee>
                        </div>
                    </li>
                    <li class="list-inline-item mr-0 pl-0 py-2">
                        <a href="{{ route('orders.track') }}" class="-dropdown-toggle text-white fs-12">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" height="20" width="20"><path d="M8 4H21V6H8V4ZM5 3V6H6V7H3V6H4V4H3V3H5ZM3 14V11.5H5V11H3V10H6V12.5H4V13H6V14H3ZM5 19.5H3V18.5H5V18H3V17H6V21H3V20H5V19.5ZM8 11H21V13H8V11ZM8 18H21V20H8V18Z"></path></svg>
                        </a>
                    </li>
                    {{-- @if (get_setting('helpline_number'))
                        <!-- Helpline -->
                        <li class="list-inline-item ml-3 pl-3 mr-0 pr-0">
                            <a href="tel:{{ get_setting('helpline_number') }}" class="text-secondary fs-12 d-inline-block py-2">
                                <span>{{ translate('Helpline')}}</span>  
                                <span>{{ get_setting('helpline_number') }}</span>    
                            </a>
                        </li>
                    @endif --}}
                </ul>
            </div>
        </div>
    </div>
</div>

<header class="@if(get_setting('header_stikcy') == 'on') sticky-top @endif z-1020" style="background-color: #0083C4;">
    <!-- Search Bar -->
    <div class="position-relative logo-bar-area border-bottom border-primary border-md-nonea z-1025">
        <div class="container">
            <div class="d-flex align-items-center">
                <!-- top menu sidebar button -->
                <button type="button" class="btn d-lg-none mr-3 mr-sm-4 p-0 active" data-toggle="class-toggle" data-target=".aiz-top-menu-sidebar">
                    <svg id="Component_43_1" data-name="Component 43 – 1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <rect id="Rectangle_19062" data-name="Rectangle 19062" width="16" height="2" transform="translate(0 7)" fill="#fff"/>
                        <rect id="Rectangle_19063" data-name="Rectangle 19063" width="16" height="2" fill="#fff"/>
                        <rect id="Rectangle_19064" data-name="Rectangle 19064" width="16" height="2" transform="translate(0 14)" fill="#fff"/>
                    </svg>
                    
                </button>
                <!-- Header Logo -->
                <div class="col-auto pl-0 pr-3 d-flex align-items-center">
                    <a class="d-block py-10px mr-3 ml-0" href="{{ route('home') }}">
                        @php
                            $header_logo = get_setting('header_logo');
                        @endphp
                        @if($header_logo != null)
                            <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}" class="mw-100 h-40px" height="40">
                        @else
                            <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}" class="mw-100 h-40px" height="40">
                        @endif
                    </a>
                </div>
                <!-- Search Icon for small device -->
                <div class="d-lg-none ml-auto mr-0">
                    <a class="p-2 d-block text-white" href="javascript:void(0);" data-toggle="class-toggle" data-target=".front-header-search">
                        <i class="las la-search la-flip-horizontal la-2x"></i>
                    </a>
                </div>
                <!-- Search field -->
                <div class="flex-grow-1 front-header-search d-flex align-items-center mx-xl-5">
                    <div class="position-relative flex-grow-1 px-3 px-lg-0">
                        <form action="{{ route('search') }}" method="GET" class="stop-propagation">
                            <div class="d-flex position-relative align-items-center bg-primary p-1">
                                <div class="d-lg-none" data-toggle="class-toggle" data-target=".front-header-search">
                                    <button class="btn px-2" type="button"><i class="la la-2x la-long-arrow-left text-white"></i></button>
                                </div>
                                <div class="search-input-box">
                                    <input type="text" class="border border-soft-light form-control fs-14 hov-animate-outline rounded-sm" id="search" name="keyword" @isset($query)
                                        value="{{ $query }}"
                                    @endisset placeholder="{{translate('I am shopping for...')}}" autocomplete="off">

                                    <svg id="Group_723" data-name="Group 723" xmlns="http://www.w3.org/2000/svg" width="20.001" height="20" viewBox="0 0 20.001 20">
                                        <path id="Path_3090" data-name="Path 3090" d="M9.847,17.839a7.993,7.993,0,1,1,7.993-7.993A8,8,0,0,1,9.847,17.839Zm0-14.387a6.394,6.394,0,1,0,6.394,6.394A6.4,6.4,0,0,0,9.847,3.453Z" transform="translate(-1.854 -1.854)" fill="#b5b5bf"/>
                                        <path id="Path_3091" data-name="Path 3091" d="M24.4,25.2a.8.8,0,0,1-.565-.234l-6.15-6.15a.8.8,0,0,1,1.13-1.13l6.15,6.15A.8.8,0,0,1,24.4,25.2Z" transform="translate(-5.2 -5.2)" fill="#b5b5bf"/>
                                    </svg>                    
                                </div>
                            </div>
                        </form>
                        <div class="typed-search-box stop-propagation document-click-d-none d-none bg-white rounded shadow-lg position-absolute left-0 top-100 w-100" style="min-height: 200px">
                            <div class="search-preloader absolute-top-center">
                                <div class="dot-loader"><div></div><div></div><div></div></div>
                            </div>
                            <div class="search-nothing d-none p-3 text-center fs-16">

                            </div>
                            <div id="search-content" class="text-left">

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Search box -->
                <div class="d-none d-lg-none ml-3 mr-0">
                    <div class="nav-search-box">
                        <a href="#" class="nav-box-link">
                            <i class="la la-search la-flip-horizontal d-inline-block nav-box-icon"></i>
                        </a>
                    </div>
                </div>
                {{-- <!-- Compare -->
                <div class="d-none d-lg-block ml-3 mr-0">
                    <div class="" id="compare">
                        @include('frontend.partials.compare')
                    </div>
                </div>
                <!-- Wishlist -->
                <div class="d-none d-lg-block mr-3" style="margin-left: 36px;">
                    <div class="" id="wishlist">
                        @include('frontend.partials.wishlist')
                    </div>
                </div> --}}

                <div class="d-none d-lg-block ml-3 mr-0">
                    <div class="" id="phone">
                        <a href="tel:{{ get_setting('helpline_number') }}" class="d-flex align-items-center text-white" data-toggle="tooltip" data-title="{{ translate('Phone') }}" data-placement="top">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" height="24" width="24"><path d="M9.36556 10.6821C10.302 12.3288 11.6712 13.698 13.3179 14.6344L14.2024 13.3961C14.4965 12.9845 15.0516 12.8573 15.4956 13.0998C16.9024 13.8683 18.4571 14.3353 20.0789 14.4637C20.599 14.5049 21 14.9389 21 15.4606V19.9234C21 20.4361 20.6122 20.8657 20.1022 20.9181C19.5723 20.9726 19.0377 21 18.5 21C9.93959 21 3 14.0604 3 5.5C3 4.96227 3.02742 4.42771 3.08189 3.89776C3.1343 3.38775 3.56394 3 4.07665 3H8.53942C9.0611 3 9.49513 3.40104 9.5363 3.92109C9.66467 5.54288 10.1317 7.09764 10.9002 8.50444C11.1427 8.9484 11.0155 9.50354 10.6039 9.79757L9.36556 10.6821ZM6.84425 10.0252L8.7442 8.66809C8.20547 7.50514 7.83628 6.27183 7.64727 5H5.00907C5.00303 5.16632 5 5.333 5 5.5C5 12.9558 11.0442 19 18.5 19C18.667 19 18.8337 18.997 19 18.9909V16.3527C17.7282 16.1637 16.4949 15.7945 15.3319 15.2558L13.9748 17.1558C13.4258 16.9425 12.8956 16.6915 12.3874 16.4061L12.3293 16.373C10.3697 15.2587 8.74134 13.6303 7.627 11.6707L7.59394 11.6126C7.30849 11.1044 7.05754 10.5742 6.84425 10.0252Z"></path></svg>
                        </a>
                    </div>
                </div>
                <div class="d-none d-lg-block mr-3" style="margin-left: 36px;">
                    <div class="" id="whatsapp">
                        <a href="https://wa.me/{{ get_setting('helpline_number') }}" class="d-flex align-items-center text-white" data-toggle="tooltip" data-title="{{ translate('Whatsapp') }}" data-placement="top">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" height="24" width="24"><path d="M7.25361 18.4944L7.97834 18.917C9.18909 19.623 10.5651 20 12.001 20C16.4193 20 20.001 16.4183 20.001 12C20.001 7.58172 16.4193 4 12.001 4C7.5827 4 4.00098 7.58172 4.00098 12C4.00098 13.4363 4.37821 14.8128 5.08466 16.0238L5.50704 16.7478L4.85355 19.1494L7.25361 18.4944ZM2.00516 22L3.35712 17.0315C2.49494 15.5536 2.00098 13.8345 2.00098 12C2.00098 6.47715 6.47813 2 12.001 2C17.5238 2 22.001 6.47715 22.001 12C22.001 17.5228 17.5238 22 12.001 22C10.1671 22 8.44851 21.5064 6.97086 20.6447L2.00516 22ZM8.39232 7.30833C8.5262 7.29892 8.66053 7.29748 8.79459 7.30402C8.84875 7.30758 8.90265 7.31384 8.95659 7.32007C9.11585 7.33846 9.29098 7.43545 9.34986 7.56894C9.64818 8.24536 9.93764 8.92565 10.2182 9.60963C10.2801 9.76062 10.2428 9.95633 10.125 10.1457C10.0652 10.2428 9.97128 10.379 9.86248 10.5183C9.74939 10.663 9.50599 10.9291 9.50599 10.9291C9.50599 10.9291 9.40738 11.0473 9.44455 11.1944C9.45903 11.25 9.50521 11.331 9.54708 11.3991C9.57027 11.4368 9.5918 11.4705 9.60577 11.4938C9.86169 11.9211 10.2057 12.3543 10.6259 12.7616C10.7463 12.8783 10.8631 12.9974 10.9887 13.108C11.457 13.5209 11.9868 13.8583 12.559 14.1082L12.5641 14.1105C12.6486 14.1469 12.692 14.1668 12.8157 14.2193C12.8781 14.2457 12.9419 14.2685 13.0074 14.2858C13.0311 14.292 13.0554 14.2955 13.0798 14.2972C13.2415 14.3069 13.335 14.2032 13.3749 14.1555C14.0984 13.279 14.1646 13.2218 14.1696 13.2222V13.2238C14.2647 13.1236 14.4142 13.0888 14.5476 13.097C14.6085 13.1007 14.6691 13.1124 14.7245 13.1377C15.2563 13.3803 16.1258 13.7587 16.1258 13.7587L16.7073 14.0201C16.8047 14.0671 16.8936 14.1778 16.8979 14.2854C16.9005 14.3523 16.9077 14.4603 16.8838 14.6579C16.8525 14.9166 16.7738 15.2281 16.6956 15.3913C16.6406 15.5058 16.5694 15.6074 16.4866 15.6934C16.3743 15.81 16.2909 15.8808 16.1559 15.9814C16.0737 16.0426 16.0311 16.0714 16.0311 16.0714C15.8922 16.159 15.8139 16.2028 15.6484 16.2909C15.391 16.428 15.1066 16.5068 14.8153 16.5218C14.6296 16.5313 14.4444 16.5447 14.2589 16.5347C14.2507 16.5342 13.6907 16.4482 13.6907 16.4482C12.2688 16.0742 10.9538 15.3736 9.85034 14.402C9.62473 14.2034 9.4155 13.9885 9.20194 13.7759C8.31288 12.8908 7.63982 11.9364 7.23169 11.0336C7.03043 10.5884 6.90299 10.1116 6.90098 9.62098C6.89729 9.01405 7.09599 8.4232 7.46569 7.94186C7.53857 7.84697 7.60774 7.74855 7.72709 7.63586C7.85348 7.51651 7.93392 7.45244 8.02057 7.40811C8.13607 7.34902 8.26293 7.31742 8.39232 7.30833Z"></path></svg>
                        </a>
                    </div>
                </div>
                {{-- @if(!isAdmin())
                <!-- Notifications -->
                <ul class="list-inline mb-0 h-100 d-none d-xl-flex justify-content-end align-items-center">
                    <li class="list-inline-item ml-3 mr-3 pr-3 pl-0 dropdown">
                        <a class="dropdown-toggle no-arrow text-secondary fs-12" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                            <span class="">
                                <span class="position-relative d-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14.668" height="16" viewBox="0 0 14.668 16">
                                        <path id="_26._Notification" data-name="26. Notification" d="M8.333,16A3.34,3.34,0,0,0,11,14.667H5.666A3.34,3.34,0,0,0,8.333,16ZM15.06,9.78a2.457,2.457,0,0,1-.727-1.747V6a6,6,0,1,0-12,0V8.033A2.457,2.457,0,0,1,1.606,9.78,2.083,2.083,0,0,0,3.08,13.333H13.586A2.083,2.083,0,0,0,15.06,9.78Z" transform="translate(-0.999)" fill="#91919b"/>
                                    </svg>
                                    @if(Auth::check() && count(Auth::user()->unreadNotifications) > 0)
                                        <span class="badge badge-primary badge-inline badge-pill absolute-top-right--10px">{{ count(Auth::user()->unreadNotifications) }}</span>
                                    @endif
                            </span>
                        </a>

                        @auth
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg py-0 rounded-0">
                                <div class="p-3 bg-light border-bottom">
                                    <h6 class="mb-0">{{ translate('Notifications') }}</h6>
                                </div>
                                <div class="px-3 c-scrollbar-light overflow-auto " style="max-height:300px;">
                                    <ul class="list-group list-group-flush" >
                                        @forelse(Auth::user()->unreadNotifications as $notification)
                                            <li class="list-group-item">
                                                @if($notification->type == 'App\Notifications\OrderNotification')
                                                    @if(Auth::user()->user_type == 'customer')
                                                    <a href="{{route('purchase_history.details', encrypt($notification->data['order_id']))}}" class="text-secondary fs-12">
                                                        <span class="ml-2">
                                                            {{translate('Order code: ')}} {{$notification->data['order_code']}} {{ translate('has been '. ucfirst(str_replace('_', ' ', $notification->data['status'])))}}
                                                        </span>
                                                    </a>
                                                    @elseif (Auth::user()->user_type == 'seller')
                                                        <a href="{{ route('seller.orders.show', encrypt($notification->data['order_id'])) }}" class="text-secondary fs-12">
                                                            <span class="ml-2">
                                                                {{translate('Order code: ')}} {{$notification->data['order_code']}} {{ translate('has been '. ucfirst(str_replace('_', ' ', $notification->data['status'])))}}
                                                            </span>
                                                        </a>
                                                    @endif
                                                @endif
                                            </li>
                                        @empty
                                            <li class="list-group-item">
                                                <div class="py-4 text-center fs-16">
                                                    {{ translate('No notification found') }}
                                                </div>
                                            </li>
                                        @endforelse
                                    </ul>
                                </div>
                                <div class="text-center border-top">
                                    <a href="{{ route('all-notifications') }}" class="text-secondary fs-12 d-block py-2">
                                        {{translate('View All Notifications')}}
                                    </a>
                                </div>
                            </div>
                        @endauth
                    </li>
                </ul>
                @endif

                <div class="ml-auto mr-0">
                    @auth
                        <span class="d-none d-xl-flex align-items-center nav-user-info py-20px @if(isAdmin()) ml-5 @endif" id="nav-user-info">
                            <!-- Image -->
                            <span class="size-40px rounded-circle overflow-hidden border border-transparent nav-user-img">
                                @if (Auth::user()->avatar_original != null)
                                    <img src="{{ uploaded_asset(Auth::user()->avatar_original) }}" class="img-fit h-100"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                @else
                                    <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="image"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                                @endif
                            </span>
                            <!-- Name -->
                            <h4 class="h5 fs-14 fw-700 text-dark ml-2 mb-0">{{ Auth::user()->name }}</h4>
                        </span>
                    @else
                        <!--Login & Registration -->
                        <span class="d-none d-xl-flex align-items-center nav-user-info ml-3">
                            <!-- Image -->
                            <span class="size-40px rounded-circle overflow-hidden border d-flex align-items-center justify-content-center nav-user-img">
                                <svg xmlns="http://www.w3.org/2000/svg" width="19.902" height="20.012" viewBox="0 0 19.902 20.012">
                                    <path id="fe2df171891038b33e9624c27e96e367" d="M15.71,12.71a6,6,0,1,0-7.42,0,10,10,0,0,0-6.22,8.18,1.006,1.006,0,1,0,2,.22,8,8,0,0,1,15.9,0,1,1,0,0,0,1,.89h.11a1,1,0,0,0,.88-1.1,10,10,0,0,0-6.25-8.19ZM12,12a4,4,0,1,1,4-4A4,4,0,0,1,12,12Z" transform="translate(-2.064 -1.995)" fill="#91919b"/>
                                </svg>
                            </span>
                            <a href="{{ route('user.login') }}" class="text-reset opacity-60 hov-opacity-100 hov-text-primary fs-12 d-inline-block border-right border-soft-light border-width-2 pr-2 ml-3">{{ translate('Login')}}</a>
                            <a href="{{ route('user.registration') }}" class="text-reset opacity-60 hov-opacity-100 hov-text-primary fs-12 d-inline-block py-2 pl-2">{{ translate('Registration')}}</a>
                        </span>
                    @endauth
                </div> --}}
            </div>
        </div>

        <!-- Loged in user Menus -->
        <div class="hover-user-top-menu position-absolute top-100 left-0 right-0 z-3">
            <div class="container">
                <div class="position-static float-right">
                    <div class="aiz-user-top-menu bg-white rounded-0 border-top shadow-sm" style="width:220px;">
                        <ul class="list-unstyled no-scrollbar mb-0 text-left">
                            @if(isAdmin())
                                <li class="user-top-nav-element border border-top-0" data-id="1">
                                    <a href="{{ route('admin.dashboard') }}" class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                            <path id="Path_2916" data-name="Path 2916" d="M15.3,5.4,9.561.481A2,2,0,0,0,8.26,0H7.74a2,2,0,0,0-1.3.481L.7,5.4A2,2,0,0,0,0,6.92V14a2,2,0,0,0,2,2H14a2,2,0,0,0,2-2V6.92A2,2,0,0,0,15.3,5.4M10,15H6V9A1,1,0,0,1,7,8H9a1,1,0,0,1,1,1Zm5-1a1,1,0,0,1-1,1H11V9A2,2,0,0,0,9,7H7A2,2,0,0,0,5,9v6H2a1,1,0,0,1-1-1V6.92a1,1,0,0,1,.349-.76l5.74-4.92A1,1,0,0,1,7.74,1h.52a1,1,0,0,1,.651.24l5.74,4.92A1,1,0,0,1,15,6.92Z" fill="#b5b5c0"/>
                                        </svg>
                                        <span class="user-top-menu-name has-transition ml-3">{{ translate('Dashboard') }}</span>
                                    </a>
                                </li>
                            @else
                                <li class="user-top-nav-element border border-top-0" data-id="1">
                                    <a href="{{ route('dashboard') }}" class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                            <path id="Path_2916" data-name="Path 2916" d="M15.3,5.4,9.561.481A2,2,0,0,0,8.26,0H7.74a2,2,0,0,0-1.3.481L.7,5.4A2,2,0,0,0,0,6.92V14a2,2,0,0,0,2,2H14a2,2,0,0,0,2-2V6.92A2,2,0,0,0,15.3,5.4M10,15H6V9A1,1,0,0,1,7,8H9a1,1,0,0,1,1,1Zm5-1a1,1,0,0,1-1,1H11V9A2,2,0,0,0,9,7H7A2,2,0,0,0,5,9v6H2a1,1,0,0,1-1-1V6.92a1,1,0,0,1,.349-.76l5.74-4.92A1,1,0,0,1,7.74,1h.52a1,1,0,0,1,.651.24l5.74,4.92A1,1,0,0,1,15,6.92Z" fill="#b5b5c0"/>
                                        </svg>
                                        <span class="user-top-menu-name has-transition ml-3">{{ translate('Dashboard') }}</span>
                                    </a>
                                </li>
                            @endif
                            
                            @if(isCustomer())
                                <li class="user-top-nav-element border border-top-0" data-id="1">
                                    <a href="{{ route('purchase_history.index') }}" class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                            <g id="Group_25261" data-name="Group 25261" transform="translate(-27.466 -542.963)">
                                            <path id="Path_2953" data-name="Path 2953" d="M14.5,5.963h-4a1.5,1.5,0,0,0,0,3h4a1.5,1.5,0,0,0,0-3m0,2h-4a.5.5,0,0,1,0-1h4a.5.5,0,0,1,0,1" transform="translate(22.966 537)" fill="#b5b5bf"/>
                                            <path id="Path_2954" data-name="Path 2954" d="M12.991,8.963a.5.5,0,0,1,0-1H13.5a2.5,2.5,0,0,1,2.5,2.5v10a2.5,2.5,0,0,1-2.5,2.5H2.5a2.5,2.5,0,0,1-2.5-2.5v-10a2.5,2.5,0,0,1,2.5-2.5h.509a.5.5,0,0,1,0,1H2.5a1.5,1.5,0,0,0-1.5,1.5v10a1.5,1.5,0,0,0,1.5,1.5h11a1.5,1.5,0,0,0,1.5-1.5v-10a1.5,1.5,0,0,0-1.5-1.5Z" transform="translate(27.466 536)" fill="#b5b5bf"/>
                                            <path id="Path_2955" data-name="Path 2955" d="M7.5,15.963h1a.5.5,0,0,1,.5.5v1a.5.5,0,0,1-.5.5h-1a.5.5,0,0,1-.5-.5v-1a.5.5,0,0,1,.5-.5" transform="translate(23.966 532)" fill="#b5b5bf"/>
                                            <path id="Path_2956" data-name="Path 2956" d="M7.5,21.963h1a.5.5,0,0,1,.5.5v1a.5.5,0,0,1-.5.5h-1a.5.5,0,0,1-.5-.5v-1a.5.5,0,0,1,.5-.5" transform="translate(23.966 529)" fill="#b5b5bf"/>
                                            <path id="Path_2957" data-name="Path 2957" d="M7.5,27.963h1a.5.5,0,0,1,.5.5v1a.5.5,0,0,1-.5.5h-1a.5.5,0,0,1-.5-.5v-1a.5.5,0,0,1,.5-.5" transform="translate(23.966 526)" fill="#b5b5bf"/>
                                            <path id="Path_2958" data-name="Path 2958" d="M13.5,16.963h5a.5.5,0,0,1,0,1h-5a.5.5,0,0,1,0-1" transform="translate(20.966 531.5)" fill="#b5b5bf"/>
                                            <path id="Path_2959" data-name="Path 2959" d="M13.5,22.963h5a.5.5,0,0,1,0,1h-5a.5.5,0,0,1,0-1" transform="translate(20.966 528.5)" fill="#b5b5bf"/>
                                            <path id="Path_2960" data-name="Path 2960" d="M13.5,28.963h5a.5.5,0,0,1,0,1h-5a.5.5,0,0,1,0-1" transform="translate(20.966 525.5)" fill="#b5b5bf"/>
                                            </g>
                                        </svg>
                                        <span class="user-top-menu-name has-transition ml-3">{{ translate('Purchase History') }}</span>
                                    </a>
                                </li>
                                <li class="user-top-nav-element border border-top-0" data-id="1">
                                    <a href="{{ route('digital_purchase_history.index') }}" class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16.001" height="16" viewBox="0 0 16.001 16">
                                            <g id="Group_25262" data-name="Group 25262" transform="translate(-1388.154 -562.604)">
                                            <path id="Path_2963" data-name="Path 2963" d="M77.864,98.69V92.1a.5.5,0,1,0-1,0V98.69l-1.437-1.437a.5.5,0,0,0-.707.707l1.851,1.852a1,1,0,0,0,.707.293h.172a1,1,0,0,0,.707-.293l1.851-1.852a.5.5,0,0,0-.7-.713Z" transform="translate(1318.79 478.5)" fill="#b5b5bf"/>
                                            <path id="Path_2964" data-name="Path 2964" d="M67.155,88.6a3,3,0,0,1-.474-5.963q-.009-.089-.015-.179a5.5,5.5,0,0,1,10.977-.718,3.5,3.5,0,0,1-.989,6.859h-1.5a.5.5,0,0,1,0-1l1.5,0a2.5,2.5,0,0,0,.417-4.967.5.5,0,0,1-.417-.5,4.5,4.5,0,1,0-8.908.866.512.512,0,0,1,.009.121.5.5,0,0,1-.52.479,2,2,0,1,0-.162,4l.081,0h2a.5.5,0,0,1,0,1Z" transform="translate(1324 486)" fill="#b5b5bf"/>
                                            </g>
                                        </svg>
                                        <span class="user-top-menu-name has-transition ml-3">{{ translate('Downloads') }}</span>
                                    </a>
                                </li>
                                @if (get_setting('conversation_system') == 1)
                                <li class="user-top-nav-element border border-top-0" data-id="1">
                                    <a href="{{ route('conversations.index') }}" class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                            <g id="Group_25263" data-name="Group 25263" transform="translate(1053.151 256.688)">
                                            <path id="Path_3012" data-name="Path 3012" d="M134.849,88.312h-8a2,2,0,0,0-2,2v5a2,2,0,0,0,2,2v3l2.4-3h5.6a2,2,0,0,0,2-2v-5a2,2,0,0,0-2-2m1,7a1,1,0,0,1-1,1h-8a1,1,0,0,1-1-1v-5a1,1,0,0,1,1-1h8a1,1,0,0,1,1,1Z" transform="translate(-1178 -341)" fill="#b5b5bf"/>
                                            <path id="Path_3013" data-name="Path 3013" d="M134.849,81.312h8a1,1,0,0,1,1,1v5a1,1,0,0,1-1,1h-.5a.5.5,0,0,0,0,1h.5a2,2,0,0,0,2-2v-5a2,2,0,0,0-2-2h-8a2,2,0,0,0-2,2v.5a.5.5,0,0,0,1,0v-.5a1,1,0,0,1,1-1" transform="translate(-1182 -337)" fill="#b5b5bf"/>
                                            <path id="Path_3014" data-name="Path 3014" d="M131.349,93.312h5a.5.5,0,0,1,0,1h-5a.5.5,0,0,1,0-1" transform="translate(-1181 -343.5)" fill="#b5b5bf"/>
                                            <path id="Path_3015" data-name="Path 3015" d="M131.349,99.312h5a.5.5,0,1,1,0,1h-5a.5.5,0,1,1,0-1" transform="translate(-1181 -346.5)" fill="#b5b5bf"/>
                                            </g>
                                        </svg>
                                        <span class="user-top-menu-name has-transition ml-3">{{ translate('Conversations') }}</span>
                                    </a>
                                </li>
                                @endif

                                @if (get_setting('wallet_system') == 1)
                                <li class="user-top-nav-element border border-top-0" data-id="1">
                                    <a href="{{ route('wallet.index') }}" class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16" height="16" viewBox="0 0 16 16">
                                            <defs>
                                              <clipPath id="clip-path1">
                                                <rect id="Rectangle_1386" data-name="Rectangle 1386" width="16" height="16" fill="#b5b5bf"/>
                                              </clipPath>
                                            </defs>
                                            <g id="Group_8102" data-name="Group 8102" clip-path="url(#clip-path1)">
                                              <path id="Path_2936" data-name="Path 2936" d="M13.5,4H13V2.5A2.5,2.5,0,0,0,10.5,0h-8A2.5,2.5,0,0,0,0,2.5v11A2.5,2.5,0,0,0,2.5,16h11A2.5,2.5,0,0,0,16,13.5v-7A2.5,2.5,0,0,0,13.5,4M2.5,1h8A1.5,1.5,0,0,1,12,2.5V4H2.5a1.5,1.5,0,0,1,0-3M15,11H10a1,1,0,0,1,0-2h5Zm0-3H10a2,2,0,0,0,0,4h5v1.5A1.5,1.5,0,0,1,13.5,15H2.5A1.5,1.5,0,0,1,1,13.5v-9A2.5,2.5,0,0,0,2.5,5h11A1.5,1.5,0,0,1,15,6.5Z" fill="#b5b5bf"/>
                                            </g>
                                        </svg>
                                        <span class="user-top-menu-name has-transition ml-3">{{ translate('My Wallet') }}</span>
                                    </a>
                                </li>
                                @endif
                                <li class="user-top-nav-element border border-top-0" data-id="1">
                                    <a href="{{ route('support_ticket.index') }}" class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16.001" viewBox="0 0 16 16.001">
                                            <g id="Group_25259" data-name="Group 25259" transform="translate(-316 -1066)">
                                            <path id="Subtraction_184" data-name="Subtraction 184" d="M16427.109,902H16420a8.015,8.015,0,1,1,8-8,8.278,8.278,0,0,1-1.422,4.535l1.244,2.132a.81.81,0,0,1,0,.891A.791.791,0,0,1,16427.109,902ZM16420,887a7,7,0,1,0,0,14h6.283c.275,0,.414,0,.549-.111s-.209-.574-.34-.748l0,0-.018-.022-1.064-1.6A6.829,6.829,0,0,0,16427,894a6.964,6.964,0,0,0-7-7Z" transform="translate(-16096 180)" fill="#b5b5bf"/>
                                            <path id="Union_12" data-name="Union 12" d="M16414,895a1,1,0,1,1,1,1A1,1,0,0,1,16414,895Zm.5-2.5V891h.5a2,2,0,1,0-2-2h-1a3,3,0,1,1,3.5,2.958v.54a.5.5,0,1,1-1,0Zm-2.5-3.5h1a.5.5,0,1,1-1,0Z" transform="translate(-16090.998 183.001)" fill="#b5b5bf"/>
                                            </g>
                                        </svg>
                                        <span class="user-top-menu-name has-transition ml-3">{{ translate('Support Ticket') }}</span>
                                    </a>
                                </li>
                            @endif
                            <li class="user-top-nav-element border border-top-0" data-id="1">
                                <a href="{{ route('logout') }}" class="text-truncate text-dark px-4 fs-14 d-flex align-items-center hov-column-gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15.999" viewBox="0 0 16 15.999">
                                        <g id="Group_25503" data-name="Group 25503" transform="translate(-24.002 -377)">
                                          <g id="Group_25265" data-name="Group 25265" transform="translate(-216.534 -160)">
                                            <path id="Subtraction_192" data-name="Subtraction 192" d="M12052.535,2920a8,8,0,0,1-4.569-14.567l.721.72a7,7,0,1,0,7.7,0l.721-.72a8,8,0,0,1-4.567,14.567Z" transform="translate(-11803.999 -2367)" fill="#d43533"/>
                                          </g>
                                          <rect id="Rectangle_19022" data-name="Rectangle 19022" width="1" height="8" rx="0.5" transform="translate(31.5 377)" fill="#d43533"/>
                                        </g>
                                    </svg>
                                    <span class="user-top-menu-name text-primary has-transition ml-3">{{ translate('Logout') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Bar -->
    <div class="d-none d-lg-block position-relative bg-primary h-50px">
        <div class="container h-100">
            <div class="d-flex h-100">
                <!-- Categoty Menu Button -->
                <div class="d-none d-xl-block all-category has-transition bg-black-10" id="category-menu-bar">
                    <div class="px-3 h-100" style="padding-top: 12px;padding-bottom: 12px; width:270px; cursor: pointer;">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="fw-700 fs-16 text-white mr-3">{{ translate('Categories') }}</span>
                                <a href="{{ route('categories.all') }}" class="text-reset">
                                    <span class="d-none d-lg-inline-block text-white hov-opacity-80">({{ translate('See All') }})</span>
                                </a>
                            </div>
                            <i class="las la-angle-down text-white has-transition" id="category-menu-bar-icon" style="font-size: 1.2rem !important"></i>
                        </div>
                    </div>
                </div>
                <!-- Header Menus -->
                <div class="ml-xl-4 w-100 overflow-hidden">
                    <div class="d-flex align-items-center justify-content-center justify-content-xl-start h-100">
                        <ul class="list-inline mb-0 pl-0 hor-swipe c-scrollbar-light">
                            @if (get_setting('header_menu_labels') != null)
                                @foreach (json_decode( get_setting('header_menu_labels'), true) as $key => $value)
                                <li class="list-inline-item mr-0 animate-underline-white">
                                    <a href="{{ json_decode( get_setting('header_menu_links'), true)[$key] }}" 
                                        class="fs-13 px-3 py-3 d-inline-block fw-700 text-white header_menu_links hov-bg-black-10
                                        @if (url()->current() == json_decode( get_setting('header_menu_links'), true)[$key]) active @endif">
                                        {{ translate($value) }}
                                    </a>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <!-- Cart -->
                <div class="d-none d-xl-block align-self-stretch ml-5 mr-0 has-transition bg-black-10" data-hover="dropdown">
                    <div class="nav-cart-box dropdown h-100" id="cart_items" style="width: max-content;">
                        @include('frontend.partials.cart')
                    </div>
                </div>
            </div>
        </div>
        <!-- Categoty Menus -->
        <div class="hover-category-menu position-absolute w-100 top-100 left-0 right-0 z-3 d-none" id="click-category-menu">
            <div class="container">
                <div class="d-flex position-relative">
                    <div class="position-static">
                        @include('frontend.partials.category_menu')
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Top Menu Sidebar -->
<div class="aiz-top-menu-sidebar collapse-sidebar-wrap sidebar-xl sidebar-left d-lg-none z-1035">
    <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle" data-target=".aiz-top-menu-sidebar" data-same=".hide-top-menu-bar"></div>
    <div class="collapse-sidebar c-scrollbar-light text-left">
        <button type="button" class="btn btn-sm p-4 hide-top-menu-bar" data-toggle="class-toggle" data-target=".aiz-top-menu-sidebar" >
            <i class="las la-times la-2x text-primary"></i>
        </button>
        @auth
            <span class="d-flex align-items-center nav-user-info pl-4">
                <!-- Image -->
                <span class="size-40px rounded-circle overflow-hidden border border-transparent nav-user-img">
                    @if (Auth::user()->avatar_original != null)
                        <img src="{{ uploaded_asset(Auth::user()->avatar_original) }}" class="img-fit h-100"
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                    @else
                        <img src="{{ static_asset('assets/img/avatar-place.png') }}" class="image"
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                    @endif
                </span>
                <!-- Name -->
                <h4 class="h5 fs-14 fw-700 text-dark ml-2 mb-0">{{ Auth::user()->name }}</h4>
            </span>
        @else
            <!--Login & Registration -->
            <span class="d-flex align-items-center nav-user-info pl-4">
                <!-- Image -->
                <span class="size-40px rounded-circle overflow-hidden border d-flex align-items-center justify-content-center nav-user-img">
                    <svg xmlns="http://www.w3.org/2000/svg" width="19.902" height="20.012" viewBox="0 0 19.902 20.012">
                        <path id="fe2df171891038b33e9624c27e96e367" d="M15.71,12.71a6,6,0,1,0-7.42,0,10,10,0,0,0-6.22,8.18,1.006,1.006,0,1,0,2,.22,8,8,0,0,1,15.9,0,1,1,0,0,0,1,.89h.11a1,1,0,0,0,.88-1.1,10,10,0,0,0-6.25-8.19ZM12,12a4,4,0,1,1,4-4A4,4,0,0,1,12,12Z" transform="translate(-2.064 -1.995)" fill="#91919b"/>
                    </svg>
                </span>
                <a href="{{ route('user.login') }}" class="text-reset opacity-60 hov-opacity-100 hov-text-primary fs-12 d-inline-block border-right border-soft-light border-width-2 pr-2 ml-3">{{ translate('Login')}}</a>
                <a href="{{ route('user.registration') }}" class="text-reset opacity-60 hov-opacity-100 hov-text-primary fs-12 d-inline-block py-2 pl-2">{{ translate('Registration')}}</a>
            </span>
        @endauth
        <hr>
        <ul class="mb-0 pl-3 pb-3 h-100">
            @if (get_setting('header_menu_labels') != null)
                @foreach (json_decode( get_setting('header_menu_labels'), true) as $key => $value)
                <li class="mr-0">
                    <a href="{{ json_decode( get_setting('header_menu_links'), true)[$key] }}" 
                        class="fs-13 px-3 py-3 w-100 d-inline-block fw-700 text-dark header_menu_links
                        @if (url()->current() == json_decode( get_setting('header_menu_links'), true)[$key]) active @endif">
                        {{ translate($value) }}
                    </a>
                </li>
                @endforeach
            @endif
            @auth
                @if(isAdmin())
                    <hr>
                    <li class="mr-0">
                        <a href="{{ route('admin.dashboard') }}" 
                            class="fs-13 px-3 py-3 w-100 d-inline-block fw-700 text-dark header_menu_links">
                            {{ translate('My Account') }}
                        </a>
                    </li>
                @else
                    <hr>
                    <li class="mr-0">
                        <a href="{{ route('dashboard') }}" 
                            class="fs-13 px-3 py-3 w-100 d-inline-block fw-700 text-dark header_menu_links
                            {{ areActiveRoutes(['dashboard'],' active')}}">
                            {{ translate('My Account') }}
                        </a>
                    </li>
                @endif
                @if(isCustomer())
                    <li class="mr-0">
                        <a href="{{ route('all-notifications') }}" 
                            class="fs-13 px-3 py-3 w-100 d-inline-block fw-700 text-dark header_menu_links
                            {{ areActiveRoutes(['all-notifications'],' active')}}">
                            {{ translate('Notifications') }}
                        </a>
                    </li>
                    <li class="mr-0">
                        <a href="{{ route('wishlists.index') }}" 
                            class="fs-13 px-3 py-3 w-100 d-inline-block fw-700 text-dark header_menu_links
                            {{ areActiveRoutes(['wishlists.index'],' active')}}">
                            {{ translate('Wishlist') }}
                        </a>
                    </li>
                    <li class="mr-0">
                        <a href="{{ route('compare') }}" 
                            class="fs-13 px-3 py-3 w-100 d-inline-block fw-700 text-dark header_menu_links
                            {{ areActiveRoutes(['compare'],' active')}}">
                            {{ translate('Compare') }}
                        </a>
                    </li>
                @endif
                <hr>
                <li class="mr-0">
                    <a href="{{ route('logout') }}" 
                        class="fs-13 px-3 py-3 w-100 d-inline-block fw-700 text-primary header_menu_links">
                        {{ translate('Logout') }}
                    </a>
                </li>
            @endauth
        </ul>
        <br>
        <br>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="order_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div id="order-details-modal-body">

            </div>
        </div>
    </div>
</div>

@section('script')
    <script type="text/javascript">
        function show_order_details(order_id)
        {
            $('#order-details-modal-body').html(null);

            if(!$('#modal-size').hasClass('modal-lg')){
                $('#modal-size').addClass('modal-lg');
            }

            $.post('{{ route('orders.details') }}', { _token : AIZ.data.csrf, order_id : order_id}, function(data){
                $('#order-details-modal-body').html(data);
                $('#order_details').modal();
                $('.c-preloader').hide();
                AIZ.plugins.bootstrapSelect('refresh');
            });
        }
    </script>
@endsection
