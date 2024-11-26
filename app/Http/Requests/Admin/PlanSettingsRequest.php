<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $commission
 */
class PlanSettingsRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|array',
            'name.*' => 'required',
            'price' => 'required|array',
            'price.*' => 'required|min:0',
            'commission' => 'required|array',
            'commission.*' => 'required|min:0|max:100',
            'subscription_api_id' => 'required|array',
            'subscription_api_id.*' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.*.required' => translate('plan_name_is_required'),
            'price.*.required' => translate('the_price_field_is_required'),
            'price.*.min' => translate('the_price_value_field_must_be_at_least_min'),
            'commission.*.required' => translate('the_commission_field_is_required'),
            'commission.*.min' => translate('the_commission_value_field_must_be_at_least_min'),
            'commission.*.max' => translate('the_commission_value_field_must_be_maximum_max'),
            'subscription_api_id.*.required' => translate('plan_id_is_required'),
        ];
    }

}
