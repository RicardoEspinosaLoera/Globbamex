@php use App\Utils\Helpers; @endphp
@extends('layouts.back-end.app')

@section('title', translate('push_Notification'))

@section('content')
    <div class="content container-fluid">
        <div class="mb-4">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{dynamicAsset(path: 'public/assets/back-end/img/push-notification.png')}}" alt="">
                {{translate('push_notification_setup')}}
            </h2>
        </div>
        <div class="d-flex flex-wrap justify-content-between gap-3 mb-4">
            @include('admin-views.push-notification._push-notification-inline-menu')

        </div>
        <div class="row gx-2 gx-lg-3">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-body py-5">
                        <div class="d-flex justify-content-between gap-3 flex-wrap mb-5">
                            <div class="table-responsive w-auto ovy-hidden">
                                @php($language = $language->value ?? null)
                                @php($default_lang = 'en')
                                @php($default_lang = json_decode($language)[0])
                                <ul class="nav nav-tabs w-fit-content flex-nowrap  border-0">
                                    @foreach (json_decode($language) as $lang)
                                        <li class="nav-item text-capitalize">
                                            <a class="nav-link lang-link {{ $lang == $default_lang ? 'active' : '' }}" href="javascript:" id="{{ $lang }}-link">
                                                {{ Helpers::get_language_name($lang) . '(' . strtoupper($lang) . ')' }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div>
                                <select name="for_customer" id="for_customer"
                                        class="form-control min-w-200 text-capitalize select-user-type">
                                    <option value="customer">{{translate('for_customer')}}</option>
                                    <option value="seller">{{translate('for_Vendor')}}</option>
                                    <option value="delivery_man">{{translate('for_delivery_man')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="customer_view">
                            <form action="{{route('admin.push-notification.update',['type'=>'customer'])}}"
                                  class="text-start" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    @foreach ($customerMessages as $key=>$value )
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <div
                                                    class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-10">
                                                    <label for="customer{{$value['key']}}" class="switcher_content">
                                                        {{ translate($value['key'] == 'out_for_delivery_message' ? 'order_out_for_delivery_message' : ($value['key'] == 'order_canceled' ? 'order_canceled_message' : $value['key'])) }}
                                                    </label>
                                                    <label class="switcher" for="customer{{$value['key']}}">
                                                        <input type="checkbox" class="switcher_input toggle-switch-message"
                                                               name="status{{$value['id']}}"
                                                               id="customer{{$value['key']}}" value="1"
                                                               {{$value['status']==1?'checked':''}}
                                                               data-modal-id = "toggle-modal"
                                                               data-toggle-id = "customer{{$value['key']}}"
                                                               data-on-image = "notification-on.png"
                                                               data-off-image = "notification-off.png"
                                                               data-on-title = "{{translate('Want_to_Turn_ON_Push_Notification')}}"
                                                               data-off-title = "{{translate('Want_to_Turn_OFF_Push_Notification')}}"
                                                               data-on-message = "<p>{{translate('if_enabled_customers_will_receive_notifications_on_their_devices')}}</p>"
                                                               data-off-message = "<p>{{translate('if_disabled_customers_will_not_receive_notifications_on_their_devices')}}</p>">
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                </div>
                                                @foreach (json_decode($language) as $lang)
                                                        <?php
                                                        if (count($value['translations'])) {
                                                            $translate = [];
                                                            foreach ($value['translations'] as $t) {
                                                                if ($t->locale == $lang && $t->key == $value['key']) {
                                                                    $translate[$lang][$value['key']] = $t->value;
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    <input type="hidden" name="lang{{$value['id']}}[]"
                                                           value="{{ $lang }}">
                                                    <textarea name="message{{$value['id']}}[]"
                                                              class="form-control text-area-max-min {{ $lang != $default_lang ? 'd-none' : '' }} lang-form {{ $lang }}-form">{{$translate[$lang][$value['key']]??$value['message']}}</textarea>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="d-flex gap-3 justify-content-end">
                                    <button type="reset"
                                            class="btn btn-secondary px-4 {{env('APP_MODE')!='demo'?'':'call-demo'}}">{{translate('reset')}}
                                    </button>
                                    <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                            class="btn btn--primary px-4 {{env('APP_MODE')!='demo'?'':'call-demo'}}">{{translate('submit')}}
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="seller_view d-none">
                            <form action="{{route('admin.push-notification.update',['type'=>'seller'])}}"
                                  class="text-start" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    @foreach ($vendorMessages as $key=>$value )
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <div
                                                    class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-10">
                                                    <label for="seller{{$value['key']}}"
                                                           class="switcher_content">{{translate($value['key'])}}</label>
                                                    <label class="switcher" for="seller{{$value['key']}}">
                                                        <input type="checkbox" class="switcher_input toggle-switch-message"
                                                               name="status{{$value['id']}}"
                                                               id="seller{{$value['key']}}" value="1"
                                                               {{$value['status']==1?'checked':''}}
                                                               data-modal-id = "toggle-modal"
                                                               data-toggle-id = "seller{{$value['key']}}"
                                                               data-on-image = "notification-on.png"
                                                               data-off-image = "notification-off.png"
                                                               data-on-title = "{{translate('Want_to_Turn_ON_Push_Notification')}}"
                                                               data-off-title = "{{translate('Want_to_Turn_OFF_Push_Notification')}}"
                                                               data-on-message = "<p>{{translate('if_enabled_customers_will_receive_notifications_on_their_devices')}}</p>"
                                                               data-off-message = "<p>{{translate('if_disabled_customers_will_not_receive_notifications_on_their_devices')}}</p>">
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                </div>
                                                @foreach (json_decode($language) as $lang)
                                                        <?php
                                                        if (count($value['translations'])) {
                                                            $translate = [];
                                                            foreach ($value['translations'] as $t) {
                                                                if ($t->locale == $lang && $t->key == $value['key']) {
                                                                    $translate[$lang][$value['key']] = $t->value;
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    <input type="hidden" name="lang{{$value['id']}}[]"
                                                           value="{{ $lang }}">
                                                    <textarea name="message{{$value['id']}}[]"
                                                              class="form-control text-area-max-min {{ $lang != $default_lang ? 'd-none' : '' }} lang-form {{ $lang }}-form">{{$translate[$lang][$value['key']]??$value['message']}}</textarea>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="d-flex gap-3 justify-content-end">
                                    <button type="reset"
                                            class="btn btn-secondary px-4 {{env('APP_MODE')!='demo'?'':'call-demo'}}">{{translate('reset')}}
                                    </button>
                                    <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                            class="btn btn--primary px-4 {{env('APP_MODE')!='demo'?'':'call-demo'}}">{{translate('submit')}}
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="delivery_man_view d-none">
                            <form action="{{route('admin.push-notification.update',['type'=>'delivery_man'])}}"
                                class="text-start" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    @foreach ($deliveryManMessages as $key=>$value )
                                        <div class="col-md-6 col-lg-4">
                                            <div class="form-group">
                                                <div
                                                    class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-10">
                                                    <label for="delivery_man{{$value['key']}}"
                                                           class="switcher_content">{{translate($value['key'])}}</label>
                                                    <label class="switcher" for="delivery-man{{$value['key']}}">
                                                        <input type="checkbox" class="switcher_input toggle-switch-message"
                                                               name="status{{$value['id']}}"
                                                               id="delivery-man{{$value['key']}}" value="1"
                                                               {{$value['status']==1?'checked':''}}
                                                               data-modal-id = "toggle-modal"
                                                               data-toggle-id = "delivery-man{{$value['key']}}"
                                                               data-on-image = "notification-on.png"
                                                               data-off-image = "notification-off.png"
                                                               data-on-title = "{{translate('Want_to_Turn_ON_Push_Notification')}}"
                                                               data-off-title = "{{translate('Want_to_Turn_OFF_Push_Notification')}}"
                                                               data-on-message = "<p>{{translate('if_enabled_customers_will_receive_notifications_on_their_devices')}}</p>"
                                                               data-off-message = "<p>{{translate('if_disabled_customers_will_not_receive_notifications_on_their_devices')}}</p>">
                                                        <span class="switcher_control"></span>
                                                    </label>
                                                </div>
                                                @foreach (json_decode($language) as $lang)
                                                        <?php
                                                        if (count($value['translations'])) {
                                                            $translate = [];
                                                            foreach ($value['translations'] as $t) {
                                                                if ($t->locale == $lang && $t->key == $value['key']) {
                                                                    $translate[$lang][$value['key']] = $t->value;
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    <input type="hidden" name="lang{{$value['id']}}[]"
                                                           value="{{ $lang }}">
                                                    <textarea name="message{{$value['id']}}[]"
                                                              class="form-control text-area-max-min {{ $lang != $default_lang ? 'd-none' : '' }} lang-form {{ $lang }}-form">{{$translate[$lang][$value['key']]??$value['message']}}</textarea>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="d-flex gap-3 justify-content-end">
                                    <button type="reset" class="btn btn-secondary px-4 {{env('APP_MODE')!='demo'?'':'call-demo'}}">
                                        {{translate('reset')}}
                                    </button>
                                    <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" class="btn btn--primary px-4 {{env('APP_MODE')!='demo'?'':'call-demo'}}">
                                        {{translate('submit')}}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="docsModal" tabindex="-1" aria-labelledby="docsModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0 d-flex justify-content-end">
                    <button type="button" class="btn-close border-0" data-dismiss="modal" aria-label="Close"><i
                            class="tio-clear"></i></button>
                </div>
                <div class="modal-body px-4 px-sm-5 pt-0">
                    <div class="d-flex flex-column gap-2">
                        <div class="text-center mb-1">
                            <img width="80" class="mb-4" src="{{dynamicAsset(path: 'public/assets/back-end/img/notice.png')}}"
                                 loading="lazy" alt="">
                            <h4 class="lh-md text-capitalize">{{translate('important_notice')}}!</h4>
                        </div>
                        <p class="mb-5">{{translate('to_include_specific_details_in_your_push_notification_message,you_can_use_the_following_placeholders')}}
                            :</p>

                        <ul class="d-flex flex-column px-4 gap-2 mb-4">
                            <li><strong><?= '{deliveryManName}' .' '.':'.' '?></strong> {{translate('the_name_of_the_delivery_person').'.'}}
                            </li>
                            <li><strong><?= '{orderId}'.' '.':'.' ' ?></strong> {{translate('the_unique_ID_of_the_order').'.'}}</li>
                            <li><strong><?= '{time}'.' '.':'.' ' ?></strong> {{translate('the_expected_delivery_time').'.'}}</li>
                            <li><strong><?= '{userName}'.' '.':'.' ' ?></strong> {{translate('the_name_of_the_user_who_placed_the_order').'.'}}
                            </li>
                        </ul>

                        <div class="mx-auto w-100 max-w-300">
                            <button class="btn btn--primary btn-block"
                                    data-dismiss="modal">{{translate('got_it')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{dynamicAsset(path: 'public/assets/back-end/js/admin/notification.js')}}"></script>
@endpush

