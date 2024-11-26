<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\BaseController;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\PlanRepository;
use App\Services\VendorService;
use Stripe\StripeClient;

class SubscriptionController extends BaseController
{
    public function __construct(
        private readonly PlanRepository $planRepo,
        private readonly VendorService  $vendorService
    )
    {
    }
    
    public function index(?Request $request, string $type = null): View|Collection|LengthAwarePaginator|null|callable|RedirectResponse
    {
        // TODO: Implement index() method.
    }

    public function checkout(string|int $plan): View|RedirectResponse
    {
        $plan=$this->planRepo->getFirstWhere([['id', $plan]]);
        return view(VIEW_FILE_NAMES['checkout_subscription'], compact('plan'));
    }

    public function checkout_create(Request $request, string|int $plan): JsonResponse
    {
        $plan=$this->planRepo->getFirstWhere([['id', $plan]]);
        $stripe=new StripeClient(config('cashier.secret'));
        $session=$stripe->checkout->sessions->create([
            'mode' => 'subscription',
            'line_items' => [['price' => $plan->subscription_api_id, 'quantity' => 1]],
            'ui_mode' => 'embedded',
            'customer_email' => auth()->guard('seller')->user()->email,
            'return_url' => route('vendor.stripe.success')
        ]);

        return response()->json(['clientSecret' => $session->client_secret]);
    }

    public function success(): View
    {
        $this->vendorService->logout();
        return view(VIEW_FILE_NAMES['subscription_success']);
    }
}