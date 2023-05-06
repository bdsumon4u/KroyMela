@extends('backend.layouts.app')

@section('content')

<div class="card">
    <form class="" action="" id="sort_orders" method="GET">
        <div class="card-header row gutters-5">
            <div class="col-sm-10 col-md-11">
                <div class="row">
                    <div class="col-md-3">
                        <select class="form-control aiz-selectpicker" name="courier" id="courier">
                            <option value="">{{translate('Courier')}}</option>
                            @foreach (config('order.couriers') as $name)
                                <option value="{{ $name }}" @if ($name == $courier) selected @endif>{{translate($name)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control aiz-selectpicker" name="delivery_status" id="delivery_status">
                            <option value="">{{translate('D. Status')}}</option>
                            @foreach (config('order.statuses') as $status)
                                <option value="{{ $status }}" @if ($delivery_status == $status) selected @endif>{{translate($status)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control aiz-selectpicker" name="payment_status" id="payment_status">
                            <option value="">{{translate('P. Status')}}</option>
                            <option value="paid"  @isset($payment_status) @if($payment_status == 'paid') selected @endif @endisset>{{translate('Paid')}}</option>
                            <option value="unpaid"  @isset($payment_status) @if($payment_status == 'unpaid') selected @endif @endisset>{{translate('Un-Paid')}}</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control aiz-selectpicker" name="payment_method" id="payment_method">
                            <option value="">{{translate('P. Method')}}</option>
                            @foreach (config('order.payments') as $method)
                                <option value="{{ $method }}" @if ($payment_method == $method) selected @endif>{{translate($method)}}</option>
                            @endforeach
                        </select>
                    </div>
                    @can('delete_order')
                        <div class="col-md-3 d-flex align-items-center justify-content-center dropdown">
                            <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
                                {{translate('Bulk Action')}}
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#" onclick="bulk_delete()"> {{translate('Delete selection')}}</a>
                            </div>
                        </div>
                    @endcan
                    <div class="col-md-3">
                        <div class="form-group mb-0">
                            <input type="text" class="aiz-date-range form-control" value="{{ $date }}" name="date" placeholder="{{ translate('Order Date') }}" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-0">
                            <input type="text" class="aiz-date-range form-control" value="{{ $shipping_date }}" name="shipping_date" placeholder="{{ translate('Shipping Date') }}" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-0">
                            <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Search') }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-2 col-md-1 d-flex align-items-center justify-content-center">
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">{{ translate('Filter') }}</button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <!--<th>#</th>-->
                        @if(auth()->user()->can('delete_order'))
                            <th>
                                <div class="form-group">
                                    <div class="aiz-checkbox-inline">
                                        <label class="aiz-checkbox">
                                            <input type="checkbox" class="check-all">
                                            <span class="aiz-square-check"></span>
                                        </label>
                                    </div>
                                </div>
                            </th>
                        @else
                            <th data-breakpoints="lg">#</th>
                        @endif
                        
                        <th>{{ translate('Code') }}</th>
                        <th data-breakpoints="md">{{ translate('DateTime') }}</th>
                        <th data-breakpoints="md">{{ translate('No. Products') }}</th>
                        <th data-breakpoints="md">{{ translate('Customer') }}</th>
                        {{-- <th data-breakpoints="md">{{ translate('Seller') }}</th> --}}
                        <th data-breakpoints="md">{{ translate('Amount') }}</th>
                        <th data-breakpoints="md">{{ translate('D. Status') }}</th>
                        <th data-breakpoints="md">{{ translate('P. Method') }}</th>
                        {{-- <th data-breakpoints="md">{{ translate('P. Status') }}</th> --}}
                        @if (addon_is_activated('refund_request'))
                        <th>{{ translate('Refund') }}</th>
                        @endif
                        <th class="text-right" width="15%">{{translate('options')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $key => $order)
                    <tr>
                        @if(auth()->user()->can('delete_order'))
                            <td>
                                <div class="form-group">
                                    <div class="aiz-checkbox-inline">
                                        <label class="aiz-checkbox">
                                            <input type="checkbox" class="check-one" name="id[]" value="{{$order->id}}">
                                            <span class="aiz-square-check"></span>
                                        </label>
                                    </div>
                                </div>
                            </td>
                        @else
                            <td>{{ ($key+1) + ($orders->currentPage() - 1)*$orders->perPage() }}</td>
                        @endif
                        <td>
                            {{ $order->code }}@if($order->viewed == 0) <span class="badge badge-inline badge-info">{{translate('New')}}</span>@endif
                        </td>
                        <td>
                            <div class='text-nowrap'>{{$order->created_at->format('d-M-Y')}}<br>{{$order->created_at->format('h:i A')}}</div>
                        </td>
                        <td>
                            {{ $order->order_details_count }}
                        </td>
                        <td>
                            @php $shipping_address = json_decode($order->shipping_address) @endphp
                            <span>{{ $shipping_address->name }}</span> <br>
                            <span>{{ $shipping_address->phone }}</span> <br>
                            <span class="text-danger">{{ $order->additional_info }}</span>
                        </td>
                        {{-- <td>
                            @if($order->shop)
                                {{ $order->shop->name }}
                            @else
                                {{ translate('Inhouse Order') }}
                            @endif
                        </td> --}}
                        <td>
                            {{ single_price($order->grand_total) }}
                        </td>
                        <td>
                            {{ translate(ucfirst(str_replace('_', ' ', $order->delivery_status))) }}
                        </td>
                        <td>
                            {{ translate(ucfirst(str_replace('_', ' ', $order->payment_type))) }}
                        </td>
                        {{-- <td>
                            @if ($order->payment_status == 'paid')
                            <span class="badge badge-inline badge-success">{{translate('Paid')}}</span>
                            @else
                            <span class="badge badge-inline badge-danger">{{translate('Unpaid')}}</span>
                            @endif
                        </td> --}}
                        @if (addon_is_activated('refund_request'))
                        <td>
                            @if (count($order->refund_requests) > 0)
                                {{ count($order->refund_requests) }} {{ translate('Refund') }}
                            @else
                                {{ translate('No Refund') }}
                            @endif
                        </td>
                        @endif
                        <td class="text-right">

                            @can('view_order_details')
                                @php
                                    $order_detail_route = route('orders.show', encrypt($order->id));
                                    if(Route::currentRouteName() == 'seller_orders.index') {
                                        $order_detail_route = route('seller_orders.show', encrypt($order->id));
                                    }
                                    else if(Route::currentRouteName() == 'pick_up_point.index') {
                                        $order_detail_route = route('pick_up_point.order_show', encrypt($order->id));
                                    }
                                    if(Route::currentRouteName() == 'inhouse_orders.index') {
                                        $order_detail_route = route('inhouse_orders.show', encrypt($order->id));
                                    }
                                @endphp
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ $order_detail_route }}" title="{{ translate('View') }}">
                                    <i class="las la-eye"></i>
                                </a>
                            @endcan
                            <a class="btn btn-soft-info btn-icon btn-circle btn-sm" href="{{ route('invoice.download', $order->id) }}" title="{{ translate('Download Invoice') }}">
                                <i class="las la-download"></i>
                            </a>
                            @can('delete_order')
                                <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('orders.destroy', $order->id)}}" title="{{ translate('Delete') }}">
                                    <i class="las la-trash"></i>
                                </a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="aiz-pagination">
                {{ $orders->appends(request()->input())->links() }}
            </div>

        </div>
        <div class="card-footer">
            <div class="fs-16 text-center">Total received amount is <strong>{{ $received_amount }}</strong> taka in <strong>{{ $payment_method ?: 'all' }}</strong> payment method.</div>
        </div>
    </form>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
    <script type="text/javascript">
        $(document).on("change", ".check-all", function() {
            if(this.checked) {
                // Iterate each checkbox
                $('.check-one:checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $('.check-one:checkbox').each(function() {
                    this.checked = false;
                });
            }

        });

//        function change_status() {
//            var data = new FormData($('#order_form')[0]);
//            $.ajax({
//                headers: {
//                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                },
//                url: "{{route('bulk-order-status')}}",
//                type: 'POST',
//                data: data,
//                cache: false,
//                contentType: false,
//                processData: false,
//                success: function (response) {
//                    if(response == 1) {
//                        location.reload();
//                    }
//                }
//            });
//        }

        function bulk_delete() {
            var data = new FormData($('#sort_orders')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('bulk-order-delete')}}",
                type: 'POST',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if(response == 1) {
                        location.reload();
                    }
                }
            });
        }
    </script>
@endsection
