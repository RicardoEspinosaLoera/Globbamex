@extends('layouts.front-end.app')

@section('title', translate('subscription_payment'))

@push('css_or_js')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')

<div class="container py-5 rtl text-start">
    <div id="checkout"></div>
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
            const response = await fetch("/vendor/checkout-subscription/{{ $plan->id }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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