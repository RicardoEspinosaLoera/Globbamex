@extends('layouts.front-end.app')

@section('title', translate('subscription_paid_successfully'))

@section('content')

<div class="container py-5 rtl text-start">
    <div class="__shop-apply">
        <div class="card __card mb-3">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12 text-center">
                        <i class="fa fa-4x fa-check-circle text-success mb-4" aria-hidden="true"></i>
                        <h3 class="font-weight-bold mb-4">{{ translate('subscription_paid_successfully') }}</h3>
                        <a href="{{ route('vendor.auth.login') }}" class="btn btn--primary font-semi-bold">{{ translate('log_in') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection