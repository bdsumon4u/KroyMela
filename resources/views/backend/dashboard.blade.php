@extends('backend.layouts.app')

@section('content')
@if(auth()->user()->can('smtp_settings') && env('MAIL_USERNAME') == null && env('MAIL_PASSWORD') == null)
    <div class="">
        <div class="alert alert-danger d-flex align-items-center">
            {{translate('Please Configure SMTP Setting to work all email sending functionality')}},
            <a class="alert-link ml-2" href="{{ route('smtp_settings.index') }}">{{ translate('Configure Now') }}</a>
        </div>
    </div>
@endif
@can('admin_dashboard')
<div class="row gutters-10">
    @foreach ($orders as $status => $count)
    <div class="col-md-2" style="flex: 0 0 20%; max-width: 20%;">
        <div class="bg-grad-2 text-white rounded-lg mb-4 overflow-hidden">
            <a class="text-white" href="{{ route('all_orders.index', ['delivery_status' => $status == 'total' ? '' : $status]) }}">
                <div class="px-3 pt-3">
                    <div class="opacity-50">
                        <span class="fs-12 d-block">{{ translate($status) }}</span>
                    </div>
                    <div class="h3 fw-700 mb-3">
                        {{ $count }}
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                    <path fill="rgba(255,255,255,0.3)" fill-opacity="1" d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                </svg>
            </a>
        </div>
    </div>
    @endforeach
</div>
@endcan
@endsection
