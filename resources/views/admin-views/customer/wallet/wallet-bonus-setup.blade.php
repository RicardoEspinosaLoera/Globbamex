@extends('layouts.back-end.app')

@section('title',translate('customer_wallet_bonus_setup'))

@section('content')
    <div class="content container-fluid">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4 pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{dynamicAsset(path: 'public/assets/back-end/img/admin-wallet.png')}}" alt="">
                {{translate('wallet_bonus_setup')}}
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
                                <img width="80" class="mb-3" src="{{dynamicAsset(path: 'public/assets/back-end/img/wallet-bonus.png')}}"
                                     loading="lazy" alt="">
                                <h4 class="lh-md">{{ translate('wallet_bonus_is_only_applicable_when_a_customer_wants_to_add_fund_to_wallet_via_outside_payment_gateway').'!' }}
                                </h4>
                                <p>{{ translate('the_bonus_amounts_are_added_to_the_customer’s_wallet_balance_with_the_amount_added_from_outside_payment_gateways,_when_admin_set_this_bonus_amount').'. '.translate('the_bonus_amount_will_be_deduct_from_admin_wallet_&_will_consider_as_admin_expense').'.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.customer.wallet.bonus-setup') }}" id="form-submit" method="post">
                    @csrf
                    <div class="row gx-2">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label for="bonus_title"
                                       class="title-color text-capitalize d-flex">{{translate('bonus_title')}}</label>
                                <input type="text" name="title" class="form-control" id="bonus_title"
                                       placeholder="{{translate('ex').':'.translate('EID_Dhamaka')}}" required>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <label for="short_desc"
                                       class="title-color text-capitalize d-flex">{{translate('short_description')}}</label>
                                <input type="text" name="description" class="form-control" id="short_desc"
                                       placeholder="{{translate('ex').':'.translate('EID_Dhamaka')}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="bonus-type"
                                       class="title-color text-capitalize d-flex">{{translate('bonus_type')}}</label>
                                <select name="bonus_type" id="bonus-type" class="form-control" required>
                                    <option value="percentage">{{translate('percentage').'(%)'}}</option>
                                    <option value="fixed">{{translate('fixed_amount')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4" id="bonus_amount_area">
                            <div class="form-group">
                                <label for="bonus_amount"
                                       class="title-color text-capitalize d-flex">
                                        {{translate('bonus_amount')}} (<span id="bonus-title-percent">{{translate('%')}}</span>)
                                </label>
                                <input type="number" name="bonus_amount" min="0" class="form-control" value="0"
                                       id="bonus_amount" placeholder="{{translate('ex').':'.'5'}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="min_add_money_amount"
                                       class="title-color text-capitalize d-flex">{{translate('minimum_add_amount')}}
                                    ({{ getCurrencySymbol(currencyCode: getCurrencyCode(type: 'default')) }})</label>
                                <input type="number" name="min_add_money_amount" min="0" class="form-control"
                                       id="min_add_money_amount" value="0" placeholder="{{translate('ex').':'.'100'}}"
                                       required>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-6 col-lg-4" id="max-bonus-amount-area">
                            <div class="form-group">
                                <label for="max_bonus_amount"
                                       class="title-color text-capitalize d-flex">{{translate('maximum_bonus')}}
                                    ({{ getCurrencySymbol(currencyCode: getCurrencyCode(type: 'default')) }})</label>
                                <input type="number" min="0" name="max_bonus_amount" value="0" class="form-control"
                                       id="max_bonus_amount" placeholder="{{translate('ex').':'.'5000'}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="start-date-time"
                                       class="title-color text-capitalize d-flex">{{translate('start_date')}}</label>
                                <input type="date" name="start_date_time" id="start-date-time" class="form-control"
                                       required>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label for="end-date-time"
                                       class="title-color text-capitalize d-flex">{{translate('end_date')}}</label>
                                <input type="date" name="end_date_time" id="end-date-time" class="form-control">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex gap-3 justify-content-end">
                                <button type="reset" class="btn btn-secondary px-5">{{translate('reset')}}</button>
                                <button type="submit" class="btn btn--primary px-5">{{translate('submit')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card mt-3">
            <div class="px-3 py-4">
                <div class="row align-items-center">
                    <div class="col-sm-4 col-md-6 col-lg-8 mb-2 mb-sm-0">
                        <h5 class="mb-0 d-flex align-items-center gap-10">
                            {{translate('wallet_Bonus_Table')}}
                            <span class="badge badge-soft-dark radius-50 fz-12 ml-1">{{ $data->total() }}</span>
                        </h5>
                    </div>
                    <div class="col-sm-8 col-md-6 col-lg-4">
                        <form action="{{ url()->current() }}" method="GET">
                            <div class="input-group input-group-merge input-group-custom">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input id="datatableSearch_" type="search" name="search" class="form-control"
                                       placeholder="{{translate('search_by_bonus_title')}}"
                                       value="{{ request('search') }}"
                                       aria-label="Search orders">
                                <button type="submit" class="btn btn--primary">{{translate('search')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                    <thead class="thead-light thead-50 text-capitalize">
                    <tr>
                        <th>{{translate('SL')}}</th>
                        <th>{{translate('bonus_title')}}</th>
                        <th>{{translate('bonus_info')}}</th>
                        <th class="text-center">{{translate('bonus_amount')}}</th>
                        <th class="text-center">{{translate('started_on')}}</th>
                        <th class="text-center">{{translate('expires_on')}}</th>
                        <th>{{translate('status')}}</th>
                        <th class="text-center">{{translate('action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $key=>$item)
                        <tr>
                            <td>{{$data->firstItem()+$key}}</td>
                            <td>{{ $item->title }}</td>
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    <div>{{translate('minimum_add_amount').' '.'-'}}
                                         {{setCurrencySymbol(amount: usdToDefaultCurrency(amount: $item->min_add_money_amount)) }}</div>
                                    @if ($item->bonus_type != "fixed")
                                        <div>{{translate('maximum_bonus').' '.'-'}}
                                             {{setCurrencySymbol(amount: usdToDefaultCurrency(amount: $item->max_bonus_amount)) }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">{{ $item->bonus_type == 'percentage' ? $item->bonus_amount.'%' : setCurrencySymbol(amount: usdToDefaultCurrency(amount: $item->bonus_amount)) }}</td>
                            <td class="text-center">{{ date('d M, Y',strtotime($item->start_date_time)) }}</td>
                            <td class="text-center">{{ date('d M, Y',strtotime($item->end_date_time)) }}</td>
                            <td>
                                <form action="{{route('admin.customer.wallet.bonus-setup-status')}}" method="post" id="bonus-setup-{{ $item->id }}-form">
                                    @csrf
                                    <input name="id" value="{{$item['id']}}" hidden>
                                    <label class="switcher" for="bonus-setup-{{ $item->id }}">
                                        <input type="checkbox" class="switcher_input toggle-switch-message" name="status" value="1"
                                               id="bonus-setup-{{ $item->id }}" {{ ($item->is_active == 1 ? 'checked':'')}}
                                               data-modal-id = "toggle-status-modal"
                                               data-toggle-id = "bonus-setup-{{$item->id}}"
                                               data-on-image = ""
                                               data-off-image = ""
                                               data-on-title = "{{translate('want_to_enable_this_bonus_status').'?'}}"
                                               data-off-title = "{{translate('want_to_disable_this_bonus_status').'?'}}"
                                               data-on-message = "<p>{{translate('if_enabled_customers_will_receive_&_enjoy_this_bonus_offer'.'.')}}</p>"
                                               data-off-message = "<p>{{translate('if_disabled_the_this_bonus_offer_will_be_hidden_for_all_customer').'.'}}</p>">
                                        <span class="switcher_control"></span>
                                    </label>
                                </form>
                            </td>
                            <td>
                                <div class="d-flex gap-10 justify-content-center">
                                    <a title="{{translate('edit')}}"
                                       type="button" class="btn btn-outline--primary btn-sm btn-xs edit"
                                       href="{{ route('admin.customer.wallet.bonus-setup-edit', ['id'=>$item->id]) }}">
                                        <i class="tio-edit"></i>
                                    </a>
                                    <a title="{{translate('delete')}}" class="btn btn-outline-danger btn-sm btn-xs delete-data"
                                       data-id="wallet-bonus-{{$item['id']}}">
                                        <i class="tio-delete"></i>
                                    </a>
                                    <form action="{{route('admin.customer.wallet.bonus-setup-delete',['id'=>$item['id']])}}"
                                          method="post" id="wallet-bonus-{{$item['id']}}">
                                        @csrf @method('delete')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end p-4">
                    {!! $data->links() !!}
                </div>
                @if(count($data) == 0)
                    <div class="text-center p-4">
                        <img class="mb-3 w-160" src="{{dynamicAsset(path: 'public/assets/back-end/svg/illustrations/sorry.svg')}}"
                             alt="Image Description">
                        <p class="mb-5">{{translate('no_data_to_show')}}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{dynamicAsset(path: 'public/assets/back-end/js/admin/customer/wallet.js')}}"></script>
@endpush

