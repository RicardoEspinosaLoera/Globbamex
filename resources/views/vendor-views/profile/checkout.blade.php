@extends('layouts.back-end.app-seller')

@section('title', translate('subscription_payment'))

@push('css_or_js')
<link rel="stylesheet" href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/intl-tel-input/css/intlTelInput.css') }}">
@endpush

@section('content')

<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <h2 class="col-sm mb-2 mb-sm-0 h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{dynamicAsset(path: 'public/assets/back-end/img/profile_setting.png')}}" alt="">
                {{translate('subscription_payment')}}
            </h2>
            <div class="col-sm-auto">
                <a class="btn btn--primary" href="{{route('vendor.dashboard.index')}}">
                    <i class="tio-home mr-1"></i> {{translate('dashboard')}}
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div id="checkout"></div>
        </div>
    </div>
</div>

@endsection

@push('script')
<!-- Add the Stripe.js script here -->
<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
    // Initialize Stripe.js
    const stripe = Stripe('{{ config('cashier.key') }}');

    initialize();

    // Fetch Checkout Session and retrieve the client secret
    async function initialize() {
        const fetchClientSecret = async () => {
            const response = await fetch("/vendor/profile/checkout-subscription/{{ $plan->id }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="_token"]').getAttribute('content')
                }
            });
            const { clientSecret } = await response.json();
            return clientSecret;
        };

        // Initialize Checkout
        const checkout = await stripe.initEmbeddedCheckout({
            fetchClientSecret,
        });

        // Mount Checkout
        checkout.mount('#checkout');
    }
</script>
@endpush