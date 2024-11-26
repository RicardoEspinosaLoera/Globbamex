<?php

namespace App\Http\Controllers\Vendor;

use App\Models\Seller;
use Stripe\StripeClient;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use Carbon\Carbon;

class StripeWebhookController extends CashierController
{
    /**
     * Handle customer created.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleCustomerCreated(array $payload)
    {
        $user = $this->getUserByStripeId($payload['data']['object']['id']);

        if (!$user) {
            $seller = Seller::where('email', $payload['data']['object']['email'])->first();
            if (!is_null($seller)) {
                $seller->stripe_id = $payload['data']['object']['id'];
                $seller->save();
            }
        }

        return $this->successMethod();
    }

    /**
     * Handle checkout session completed.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleCheckoutSessionCompleted(array $payload)
    {
        $user = $this->getUserByStripeId($payload['data']['object']['customer']);

        if ($user) {
            $data = $payload['data']['object'];
            $stripe = new StripeClient(config('cashier.secret'));
            $subscription_data = $stripe->subscriptions->retrieve($data['subscription'], []);

            if (! $user->subscriptions->contains('stripe_id', $subscription_data['id'])) {
                if (isset($subscription_data['trial_end'])) {
                    $trialEndsAt = Carbon::createFromTimestamp($subscription_data['trial_end']);
                } else {
                    $trialEndsAt = null;
                }

                $firstItem = $subscription_data['items']['data'][0];
                $isSinglePrice = count($subscription_data['items']['data']) === 1;

                $subscription = $user->subscriptions()->create([
                    'type' => $subscription_data['metadata']['type'] ?? $subscription_data['metadata']['name'] ?? $this->newSubscriptionType($payload),
                    'stripe_id' => $subscription_data['id'],
                    'stripe_status' => $subscription_data['status'],
                    'stripe_price' => $isSinglePrice ? $firstItem['price']['id'] : null,
                    'quantity' => $isSinglePrice && isset($firstItem['quantity']) ? $firstItem['quantity'] : null,
                    'trial_ends_at' => $trialEndsAt,
                    'ends_at' => null,
                ]);

                foreach ($subscription_data['items']['data'] as $item) {
                    $subscription->items()->create([
                        'stripe_id' => $item['id'],
                        'stripe_product' => $item['price']['product'],
                        'stripe_price' => $item['price']['id'],
                        'quantity' => $item['quantity'] ?? null,
                    ]);
                }
            }

            // Terminate the billable's generic trial if it exists...
            if (! is_null($user->trial_ends_at)) {
                $user->update(['trial_ends_at' => null]);
            }
        }

        return $this->successMethod();
    }
}
