<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\Plan;
use App\Contracts\Repositories\PlanRepositoryInterface;
use App\Enums\ViewPaths\Admin\BusinessSettings;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\PlanSettingsRequest;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PlanSettingsController extends BaseController
{

    public function __construct(
        private readonly PlanRepositoryInterface $planRepo,
    )
    {
    }

    /**
     * @param Request|null $request
     * @param string|null $type
     * @return View Index function is the starting point of a controller
     * Index function is the starting point of a controller
     */
    public function index(Request|null $request, string $type = null): View
    {
        return $this->getView();
    }

    public function getView(): View
    {
        $plans=Plan::whereIn('id', [1, 2, 3])->get();
        return view(BusinessSettings::PLAN_VIEW[VIEW], compact('plans'));
    }

    public function update(PlanSettingsRequest $request): RedirectResponse
    {
        $ids=[0 => 1, 1 => 2, 2 => 3];
        foreach ($ids as $key => $value) {
            $data=['name' => request('name')[$key], 'price' => request('price')[$key], 'subscription_api_id' => request('subscription_api_id')[$key], 'sales_commission' => request('commission')[$key]];
            $this->planRepo->update($value, $data);
        }

        Toastr::success(translate('Updated_successfully'));
        return redirect()->back();
    }

}
