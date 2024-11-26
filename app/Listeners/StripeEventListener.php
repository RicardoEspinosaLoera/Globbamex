<?php

namespace App\Listeners;

use Laravel\Cashier\Events\WebhookReceived;
use Laravel\Cashier\SubscriptionBuilder;

class StripeEventListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle received Stripe webhooks.
     */
    public function handle(WebhookReceived $event): void
    {
        
    }
}
