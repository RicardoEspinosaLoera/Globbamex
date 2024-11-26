@extends('layouts.back-end.app')

@section('title', translate('reCaptcha_Setup'))

@section('content')
    <div class="content container-fluid">
        <div class="mb-4 pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{dynamicAsset(path: 'public/assets/back-end/img/3rd-party.png')}}" alt="">
                {{translate('3rd_party')}}
            </h2>
        </div>
        @include('admin-views.business-settings.third-party-inline-menu')
        <div class="row">
            <div class="col-12">
                <div class="card overflow-hidden">
                    <form action="{{ env('APP_MODE') != 'demo' ? route('admin.business-settings.captcha') : 'javascript:' }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="d-flex justify-content-between gap-2 align-items-center mb-3">
                                <div>{{translate('status')}}</div>


                            </div>
                            <div class="bg-white rounded-bottom overflow-hidden mb-4">
                                <div class="border rounded border-color-c1 px-4 py-3 d-flex justify-content-between">
                                    <h5 class="mb-0 d-flex gap-1 c1">
                                        @if(isset($config))
                                            @php($config = (array)json_decode($config['value']))
                                        @endif
                                        {{translate('turn')}} {{translate(isset($config) && $config['status']==1?'OFF':'ON')}}
                                    </h5>
                                    <div class="position-relative">
                                        <label class="switcher">
                                            <input class="switcher_input toggle-switch-message" type="checkbox" name="status"
                                                   id="recaptcha-id" {{$config['status']==1?'checked':''}} value="1"
                                                   data-modal-id = "toggle-modal"
                                                   data-toggle-id = "recaptcha-id"
                                                   data-on-image = "recaptcha-off.png"
                                                   data-off-image = "recaptcha-off.png"
                                                   data-on-title = "{{translate('important').'!'}}"
                                                   data-off-title = "{{translate('warning').'!'}}"
                                                   data-on-message = "<p>{{translate('reCAPTCHA_is_now_enabled_for_added_security').'.'.translate('users_may_be_prompted_to_complete_a_reCAPTCHA_challenge_to_verify_their_human_identity_and protect_against_spam_and_malicious_activity')}}</p>"
                                                   data-off-message = "<p>{{translate('disabling_reCAPTCHA_may_leave_your_website_vulnerable_to_spam_and_malicious_activity_and_suspects_that_a_user_may_be_a_bot').' '.translate('it_is_highly_recommended_to_keep_reCAPTCHA_enabled_to_ensure_the_security_and_integrity_of_your_website')}}</p>">
                                            <span class="switcher_control"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="title-color font-weight-bold d-flex">{{translate('site_Key')}}</label>
                                        <input type="text" class="form-control" name="site_key"
                                                value="{{env('APP_MODE')!='demo'?$config['site_key']??"":''}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="title-color font-weight-bold d-flex">{{translate('secret_Key')}}</label>
                                        <input type="text" class="form-control" name="secret_key"
                                                value="{{env('APP_MODE')!='demo'?$config['secret_key']??"":''}}">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-3">
                                <button type="reset" class="btn btn-secondary px-5">{{translate('reset')}}</button>
                                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" class="btn btn--primary px-5 {{env('APP_MODE')!='demo'?'':'call-demo'}}">{{translate('save')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="getInformationModal" tabindex="-1" aria-labelledby="getInformationModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0 d-flex justify-content-end">
                    <button type="button" class="btn-close border-0" data-dismiss="modal" aria-label="Close"><i class="tio-clear"></i></button>
                </div>
                <div class="modal-body px-4 px-sm-5 pt-0">
                    <div class="swiper mySwiper pb-3">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="d-flex flex-column align-items-center gap-2">
                                    <img width="80" class="mb-3" src="{{dynamicAsset(path: 'public/assets/back-end/img/smtp-server.png')}}" loading="lazy" alt="">
                                    <h4 class="lh-md mb-3 text-capitalize">{{translate('find_SMTP_server_details')}}</h4>
                                    <ul class="d-flex flex-column px-4 gap-2 mb-4">
                                    <li>{{translate('contact_your_email_service_provider_or_IT_administrator_to_obtain_the_SMTP_server_details_such_as_hostname_port_username_and_password').'.'}}</li>
                                        <li>{{translate('note').':'.translate('if_you`re_not_sure_where_to_find_these_details,_check_the_email_provider`s_documentation_or_support_resources_for_guidance').'.'}}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
