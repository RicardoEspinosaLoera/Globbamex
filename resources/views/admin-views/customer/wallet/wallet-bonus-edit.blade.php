@extends('layouts.back-end.app')

@section('title',translate('customer_wallet_bonus_edit'))

@section('content')
    <div class="content container-fluid">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4 pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{dynamicAsset(path: 'public/assets/back-end/img/admin-wallet.png')}}" alt="">
                {{translate('wallet_bonus_edit')}}
            </h2>

            <div class="modal fade" id="howItWorksModal" tabindex="-1" aria-labelledby="howItWorksModal"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0 pb-0 d-flex justify-content-end">
                            <button type="button" class="btn-close border-0" data-dismiss="modal" aria-label="Close"><i
                                        class="tio-clear"></i></button>
                        </div>
                        <div class="modal-body px-4 px-sm-5 pt-0 text-center">
                            <div class="d-flex flex-column align-items-center gap-2">
                                <img width="80" class="mb-3" src="{{dynamicAsset(path: 'public/assets/back-end/img/para.png')}}"
                                     loading="lazy" alt="">
                                <h4 class="lh-md">
                                    {{ translate('wallet_bonus_is_only_applicable_when_a_customer_add_fund_to_wallet_via_outside_payment_gateway').'!' }}
                                </h4>
                                <p>{{ translate('customer_will_get_extra_amount_to_his_or_her_wallet_additionally_with_the_amount_he_or_she_added_from_other_payment_gateways').' '.translate('the_bonus_amount_will_be_deduct_from_admin_wallet_&_will_consider_as_admin_expense') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.customer.wallet.bonus-setup-update') }}" id="form-submit" method="post">
                    @csrf
                    <div class="row gx-2">
                        <input type="hidden" name="id" value="{{ $data->id }}">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label for="bonus_title"
                                       class="title-color text-capitalize d-flex">{{translate('bonus_title')}}</label>
                                <input type="text" name="title" class="form-control" id="bonus_title"
                                       placeholder="{{translate('ex').':'.translate('EID_Dhamaka')}}" value="{{ $data->title }}"
                                       required>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label for="short_desc"
                                       class="title-color text-capitalize d-flex">{{translate('short_description')}}</label>
                                <input type="text" name="description" class="form-control" id="short_desc"
                                       placeholder="{{translate('ex').':'.translate('EID_Dhamaka')}}" value="{{ $data->description }}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="bonus-type"
                                       class="title-color text-capitalize d-flex">{{translate('bonus_type')}}</label>
                                <select name="bonus_type" id="bonus-type" class="form-control">
                                    <option value="percentage" {{ $data->bonus_type == 'percentage' ? 'selected':'' }}>{{translate('percentage ').'(%)'}}</option>
                                    <option value="fixed" {{ $data->bonus_type == 'fixed' ? 'selected':'' }}>{{translate('fixed_amount')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="bonus_amount"
                                       class="title-color text-capitalize d-flex">
                                    {{translate('bonus_amount')}}(<span id="bonus-title-percent">{{translate('%')}}</span>)
                                </label>
                                <input type="number" name="bonus_amount" min="0" class="form-control" id="bonus-title-percent"
                                       placeholder="{{translate('ex').':'.'5'}}"
                                       value="{{ $data->bonus_type == 'fixed' ? (usdToDefaultCurrency(amount: $data->bonus_amount) ?? 0) : $data->bonus_amount }}"
                                       required>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="min_add_money_amount"
                                       class="title-color text-capitalize d-flex">{{translate('minimum_add_amount')}}
                                    ({{ getCurrencySymbol(currencyCode: getCurrencyCode(type: 'default')) }})</label>
                                <input type="number" name="min_add_money_amount" min="0" class="form-control"
                                       id="min_add_money_amount" placeholder="{{translate('ex').':'.'100'}}"
                                       value="{{ usdToDefaultCurrency(amount: $data->min_add_money_amount) ?? 0 }}"
                                       required>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4" id="max-bonus-amount-area">
                            <div class="form-group">
                                <label for="max_bonus_amount"
                                       class="title-color text-capitalize d-flex">{{translate('maximum_bonus')}}
                                    ({{getCurrencySymbol(currencyCode: getCurrencyCode(type: 'default'))}})</label>
                                <input type="number" min="0" name="max_bonus_amount" class="form-control"
                                       id="max_bonus_amount" placeholder="{{translate('ex').':'.'5000'}}"
                                       value="{{ usdToDefaultCurrency(amount: $data->max_bonus_amount) ?? 0 }}">
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="start-date-time"
                                       class="title-color text-capitalize d-flex">{{translate('start_date')}}</label>
                                <input type="date" name="start_date_time" id="start-date-time" class="form-control"
                                       value="{{ date('Y-m-d',strtotime($data['start_date_time'])) }}" required>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="end-date-time"
                                       class="title-color text-capitalize d-flex">{{translate('end_date')}}</label>
                                <input type="date" name="end_date_time" id="end-date-time" class="form-control"
                                       value="{{ date('Y-m-d',strtotime($data['end_date_time'])) }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex gap-3 justify-content-end">
                                <a href="{{route('admin.customer.wallet.bonus-setup')}}"
                                   class="btn btn-secondary px-5">{{translate('back')}}</a>
                                <button type="submit" class="btn btn--primary px-5">{{translate('submit')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{dynamicAsset(path: 'public/assets/back-end/js/admin/customer/wallet.js')}}"></script>
@endpush

