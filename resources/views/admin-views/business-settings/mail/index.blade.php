@php use App\Utils\Helpers; @endphp
@extends('layouts.back-end.app')
@section('title', translate('mail_Config'))

@push('css_or_js')
    <link rel="stylesheet" href="{{ dynamicAsset(path: 'public/assets/back-end/vendor/swiper/swiper-bundle.min.css')}}"/>
@endpush

@section('content')
    <div class="content container-fluid">
        <div class="mb-4 pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{dynamicAsset(path: 'public/assets/back-end/img/3rd-party.png')}}" alt="">
                {{translate('3rd_party')}}
            </h2>
        </div>
        @include('admin-views.business-settings.third-party-inline-menu')
        <div class="bg-white rounded-top">
            <div class="card-body pb-0">
                <div class="d-flex flex-wrap justify-content-between gap-3 border-bottom">
                    <nav>
                        <div class="nav nav-tabs border-0" id="nav-tab" role="tablist">
                            <a class="nav-link d-flex align-items-center gap-2 active" id="nav-home-tab"
                               data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home"
                               aria-selected="true">
                                <img width="22" src="{{dynamicAsset(path: 'public/assets/back-end/img/mail-config.png')}}" alt="">
                                {{translate('mail_configuration')}}
                            </a>
                            <a class="nav-link d-flex align-items-center gap-2" id="nav-profile-tab" data-toggle="tab"
                               href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                                <img width="22" src="{{dynamicAsset(path: 'public/assets/back-end/img/send-test-mail.png')}}"
                                     alt="">
                                {{translate('send_test_mail')}}
                            </a>
                        </div>
                    </nav>

                </div>
            </div>
        </div>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card mt-3">
                            @php($data_smtp=Helpers::get_business_settings('mail_config'))
                            <form action="{{route('admin.business-settings.mail.update')}}" method="post">
                                @csrf
                                @if(isset($data_smtp))
                                    <div class="card-header">
                                        <h5 class="mb-0 d-flex align-items-center gap-2 text-capitalize">
                                            <img width="20" src="{{dynamicAsset(path: 'public/assets/back-end/img/smtp.png')}}"
                                                 alt="">
                                            {{translate('smtp_mail_config')}}
                                        </h5>

                                        <label class="switcher">
                                            <input type="checkbox" name="status" value="1"
                                                   id="mail_config" {{$data_smtp['status']==1?'checked':''}} class="switcher_input toggle-switch-message"
                                                   data-modal-id = "toggle-modal"
                                                   data-toggle-id = "mail_config"
                                                   data-on-image = "maintenance_mode-on.png"
                                                   data-off-image = "maintenance_mode-off.png"
                                                   data-on-title = "{{translate('want_to_Turn_ON_the_smtp_mail_config_option').'?'}}"
                                                   data-off-title = "{{translate('want_to_Turn_OFF_the_smtp_mail_config_option').'?'}}"
                                                   data-on-message = "<p>{{translate('enabling_mail_configuration_services_will_allow_the_system_to_send_emails').'.'.translate('please_ensure_that_you_have_correctly_configured_the_SMTP_settings_to_avoid_potential_issues_with_email_delivery')}}</p>"
                                                   data-off-message = "<p>{{translate('disabling_SMTP_mail_configuration_services_stops_email_sending')}}</p>">
                                            <span class="switcher_control"></span>
                                        </label>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <label
                                                            class="title-color mb-0">{{translate('mailer_name')}}</label>
                                                        <i class="tio-info-outined" data-toggle="tooltip"
                                                           title="{{translate('enter_mailer_name')}}"></i>
                                                    </div>
                                                    <input type="text"
                                                           placeholder="{{translate('ex')}}:{{translate('alex')}}"
                                                           class="form-control" name="name"
                                                           value="{{env('APP_MODE')=='demo' ? '' :$data_smtp['name']}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <label class="title-color mb-0">{{translate('host')}}</label>
                                                        <i class="tio-info-outined" data-toggle="tooltip"
                                                           title="{{translate('enter_the_name_of_the_host_of_your_mailing_service')}}"></i>
                                                    </div>
                                                    <input type="text" class="form-control" name="host"
                                                           placeholder="{{translate('ex').':'}}{{translate('smtp.mailtrap.io')}}"
                                                           value="{{env('APP_MODE')=='demo'?'':$data_smtp['host']}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <label class="title-color mb-0">{{translate('driver')}}</label>
                                                        <i class="tio-info-outined" data-toggle="tooltip"
                                                           title="{{translate('enter_the_driver_for_your_mailing_service')}}"></i>
                                                    </div>
                                                    <input type="text" class="form-control" name="driver"
                                                           placeholder="{{translate('ex')}}:{{translate('smtp')}}"
                                                           value="{{env('APP_MODE')=='demo'?'':$data_smtp['driver']}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <label class="title-color mb-0">{{translate('port')}}</label>
                                                        <i class="tio-info-outined" data-toggle="tooltip"
                                                           title="{{translate('enter_the_port_number_for_your_mailing_service')}}"></i>
                                                    </div>
                                                    <input type="text" class="form-control" name="port"
                                                           placeholder="{{translate('ex')}}:587"
                                                           value="{{env('APP_MODE')=='demo'?'':$data_smtp['port']}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <label
                                                            class="title-color mb-0">{{translate('username')}}</label>
                                                        <i class="tio-info-outined" data-toggle="tooltip"
                                                           title="{{translate('enter_the_username_of_your_account')}}"></i>
                                                    </div>
                                                    <input type="text" placeholder="{{translate('ex : yahoo')}}"
                                                           class="form-control"
                                                           name="username"
                                                           value="{{env('APP_MODE')=='demo'?'':$data_smtp['username']}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <label
                                                            class="title-color mb-0">{{translate('email_ID')}}</label>
                                                        <i class="tio-info-outined" data-toggle="tooltip"
                                                           title="{{translate('enter_your_email_ID')}}"></i>
                                                    </div>
                                                    <input type="text"
                                                           placeholder="{{translate('ex')}}:{{translate('example@example.com')}}"
                                                           class="form-control" name="email"
                                                           value="{{env('APP_MODE')=='demo'?'':$data_smtp['email_id']}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <label
                                                            class="title-color mb-0">{{translate('encryption')}}</label>
                                                        <i class="tio-info-outined" data-toggle="tooltip"
                                                           title="{{translate('enter_the_encryption_type')}}"></i>
                                                    </div>
                                                    <input type="text"
                                                           placeholder="{{translate('ex :')}}:{{translate('tls')}}"
                                                           class="form-control" name="encryption"
                                                           value="{{env('APP_MODE')=='demo'?'':$data_smtp['encryption']}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="js-form-message form-group">
                                                    <label class="input-label" for="smtpPassword" tabindex="0">
                                                    <span class="d-flex align-items-center gap-2">
                                                      {{translate('password')}}
                                                      <i class="tio-info-outined" data-toggle="tooltip"
                                                         title="{{translate('enter_your_password')}}"></i>
                                                    </span>
                                                    </label>
                                                    <div class="input-group input-group-merge">
                                                        <input type="password" class="js-toggle-password form-control"
                                                               value="{{env('APP_MODE')=='demo'?'':$data_smtp['password']}}"
                                                               name="password" id="smtpPassword"
                                                               placeholder="{{translate('ex')}}:123456"
                                                               data-hs-toggle-password-options='{
                                                                     "target": "#changePassTarget2",
                                                            "defaultClass": "tio-hidden-outlined",
                                                            "showClass": "tio-visible-outlined",
                                                            "classChangeTarget": "#changePassIcon2"
                                                            }'>
                                                        <div id="changePassTarget2" class="input-group-append">
                                                            <a class="input-group-text" href="javascript:">
                                                                <i id="changePassIcon2"
                                                                   class="tio-visible-outlined"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="d-flex flex-wrap justify-content-end gap-10">
                                            <button type="reset"
                                                    class="btn btn-secondary px-5">{{translate('reset')}}</button>
                                            <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                    class="btn btn--primary px-5 {{env('APP_MODE')!='demo'?'':'call-demo'}}">{{translate('save')}}</button>
                                            @else
                                                <button type="submit"
                                                        class="btn btn--primary px-5">{{translate('configure')}}</button>
                                            @endif
                                        </div>

                                    </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card mt-3">
                            <form action="{{route('admin.business-settings.mail.update-sendgrid')}}" method="post">
                                @csrf
                                @php($data_sendgrid=Helpers::get_business_settings('mail_config_sendgrid'))
                                @if(isset($data_sendgrid))
                                    <div class="card-header">
                                        <h5 class="mb-0 d-flex align-items-center gap-2 text-capitalize">
                                            <img width="20" src="{{dynamicAsset(path: 'public/assets/back-end/img/smtp.png')}}" alt="">
                                            {{translate('sendgrid_mail_config')}}
                                        </h5>
                                        <label class="switcher">
                                            <input type="checkbox" class="switcher_input toggle-switch-message" name="status"
                                                   id="mail-config-sendgrid"
                                                   value="1" {{$data_sendgrid['status'] == 1 ? 'checked':''}}
                                                   data-modal-id = "toggle-modal"
                                                   data-toggle-id = "mail-config-sendgrid"
                                                   data-on-image = "maintenance_mode-on.png"
                                                   data-off-image = "maintenance_mode-off.png"
                                                   data-on-title = "{{translate('want_to_Turn_ON_the_sendgrid_mail_config_option').'?'}}"
                                                   data-off-title = "{{translate('want_to_Turn_OFF_the_sendgrid_mail_config_option').'?'}}"
                                                   data-on-message = "<p>{{translate('enabling_mail_configuration_services_will_allow_the_system_to_send_emails').'.'.translate('please_ensure_that_you_have_correctly_configured_the_sendgrid_settings_to_avoid_potential_issues_with_email_delivery')}}</p>"
                                                   data-off-message = "<p>{{translate('disabling_sendgrid_mail_configuration_services_stops_email_sending')}}</p>">
                                            <span class="switcher_control"></span>
                                        </label>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <label
                                                            class="title-color mb-0">{{translate('mailer_name')}}</label>
                                                        <i class="tio-info-outined" data-toggle="tooltip"
                                                           title="{{translate('enter_mailer_name')}}"></i>
                                                    </div>
                                                    <input type="text"
                                                           placeholder="{{translate('ex').':'}}{{translate('alex')}}"
                                                           class="form-control" name="name"
                                                           value="{{env('APP_MODE')=='demo' ? '' :$data_sendgrid['name']}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <label class="title-color mb-0">{{translate('host')}}</label>
                                                        <i class="tio-info-outined" data-toggle="tooltip"
                                                           title="{{translate('enter_the_name_of_the_host_of_your_mailing_service')}}"></i>
                                                    </div>
                                                    <input type="text" class="form-control" name="host"
                                                           placeholder="{{translate('ex')}}:{{translate('smtp.mailtrap.io')}}"
                                                           value="{{env('APP_MODE')=='demo' ? '' : $data_sendgrid['host']}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <label class="title-color mb-0">{{translate('driver')}}</label>
                                                        <i class="tio-info-outined" data-toggle="tooltip"
                                                           title="{{translate('enter_the_driver_for_your_mailing_service')}}"></i>
                                                    </div>
                                                    <input type="text" class="form-control" name="driver"
                                                           placeholder="{{translate('ex')}}:{{translate('smtp')}}"
                                                           value="{{env('APP_MODE')=='demo'?'':$data_sendgrid['driver']}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <label class="title-color mb-0">{{translate('port')}}</label>
                                                        <i class="tio-info-outined" data-toggle="tooltip"
                                                           title="{{translate('enter_the_port_number_for_your_mailing_service')}}"></i>
                                                    </div>
                                                    <input type="text" class="form-control" name="port"
                                                           placeholder="{{translate('ex').':'.'587'}}"
                                                           value="{{env('APP_MODE')=='demo'?'':$data_sendgrid['port']}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <label
                                                            class="title-color mb-0">{{translate('username')}}</label>
                                                        <i class="tio-info-outined" data-toggle="tooltip"
                                                           title="{{translate('enter_the_username_of_your_account')}}"></i>
                                                    </div>
                                                    <input type="text" placeholder="{{translate('ex').':'.'yahoo'}}"
                                                           class="form-control" name="username"
                                                           value="{{env('APP_MODE')=='demo'?'':$data_sendgrid['username']}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <label
                                                            class="title-color mb-0">{{translate('email_ID')}}</label>
                                                        <i class="tio-info-outined" data-toggle="tooltip"
                                                           title="{{translate('enter_your_email_ID')}}"></i>
                                                    </div>
                                                    <input type="text"
                                                           placeholder="{{translate('ex').':'}}{{translate('example@example.com')}}"
                                                           class="form-control" name="email"
                                                           value="{{env('APP_MODE')=='demo'?'':$data_sendgrid['email_id']}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <div class="d-flex align-items-center gap-2 mb-2">
                                                        <label
                                                            class="title-color mb-0">{{translate('encryption')}}</label>
                                                        <i class="tio-info-outined" data-toggle="tooltip"
                                                           title="{{translate('enter_the_encryption_type')}}"></i>
                                                    </div>
                                                    <input type="text"
                                                           placeholder="{{translate('ex').':'}}{{translate('tls')}}"
                                                           class="form-control" name="encryption"
                                                           value="{{env('APP_MODE')=='demo'?'':$data_sendgrid['encryption']}}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="js-form-message form-group">
                                                    <label class="input-label" for="sendGridPassword" tabindex="0">
                                                    <span class="d-flex gap-2 align-items-center">
                                                      {{translate('password')}}
                                                      <i class="tio-info-outined" data-toggle="tooltip"
                                                         title="{{translate('enter_your_password')}}"></i>
                                                    </span>
                                                    </label>
                                                    <div class="input-group input-group-merge">
                                                        <input type="password" class="js-toggle-password form-control"
                                                               name="password" id="sendGridPassword"
                                                               placeholder="{{translate('ex')}}:123456"
                                                               value="{{env('APP_MODE')=='demo'?'':$data_sendgrid['password']}}"
                                                               data-hs-toggle-password-options='{
                                                                     "target": "#changePassTarget",
                                                            "defaultClass": "tio-hidden-outlined",
                                                            "showClass": "tio-visible-outlined",
                                                            "classChangeTarget": "#changePassIcon"
                                                            }'>
                                                        <div id="changePassTarget" class="input-group-append">
                                                            <a class="input-group-text" href="javascript:">
                                                                <i id="changePassIcon" class="tio-visible-outlined"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="d-flex flex-wrap justify-content-end gap-10">
                                            <button type="reset"
                                                    class="btn btn-secondary px-5">{{translate('reset')}}</button>
                                            <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                                    class="btn btn--primary px-5 {{env('APP_MODE')!='demo'?'':'call-demo'}}">{{translate('save')}}</button>
                                            @else
                                                <button type="submit"
                                                        class="btn btn--primary px-5">{{translate('configure')}}</button>
                                            @endif
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="bg-white rounded-bottom overflow-hidden">
                    <div class="bg-white card-body">
                        <form class="" action="javascript:">
                            <div class="row">
                                <div class="col-xl-8 col-lg-10">
                                    <div class="d-flex align-items-end gap-2 gap-sm-3">
                                        <div class="flex-grow-1">
                                            <label class="title-color">{{translate('email')}}</label>
                                            <input type="email" id="test-email" class="form-control"
                                                   placeholder="{{translate('ex').':'.'jhon@email.com'}}">
                                        </div>
                                        <button type="button" class="btn btn--primary px-sm-5" data-toggle="modal"
                                                data-target="#send-mail-confirmation-modal">
                                            <i class="tio-telegram"></i>
                                            {{translate('send_mail')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="getInformationModal" tabindex="-1" aria-labelledby="getInformationModal"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0 d-flex justify-content-end">
                    <button type="button" class="btn-close border-0" data-dismiss="modal" aria-label="Close"><i
                            class="tio-clear"></i></button>
                </div>
                <div class="modal-body px-4 px-sm-5 pt-0">
                    <div class="swiper mySwiper pb-3">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="d-flex flex-column align-items-center gap-2">
                                    <img width="80" class="mb-3"
                                         src="{{dynamicAsset(path: 'public/assets/back-end/img/smtp-server.png')}}" loading="lazy"
                                         alt="">
                                    <h4 class="lh-md mb-3 text-capitalize">{{translate('find_SMTP_server_details')}}</h4>
                                    <ul class="d-flex flex-column px-4 gap-2 mb-4">
                                        <li>
                                            {{translate('contact_your_email_service_provider_or_IT_administrator_to_obtain_the_SMTP_server_details_such_as_hostname_port_username_and_password').'.'}}
                                        </li>
                                        <li>{{translate('note').':'}}
                                             {{translate('if_you`re_not_sure_where_to_find_these_details,_check_the_email_provider`s_documentation_or_support_resources_for_guidance').'.'}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="d-flex flex-column align-items-center gap-2">
                                    <img width="80" class="mb-3"
                                         src="{{dynamicAsset(path: 'public/assets/back-end/img/config-smtp.png')}}" loading="lazy"
                                         alt="">
                                    <h4 class="lh-md mb-3 text-capitalize">{{translate('configure_SMTP_settings')}}</h4>
                                    <ul class="d-flex flex-column px-4 gap-2 mb-4">
                                        <li>{{translate('go_to_the_SMTP_mail_setup_page_in_the_admin_panel').'.'}}</li>
                                        <li>{{translate('enter_the_obtained_SMTP_server_details,_including_the_hostname,_port,_username,_and password').'.'}}</li>
                                        <li>{{translate('choose_the_appropriate_encryption_method').' '.'(e.g., SSL,TLS)'.' '.translate('if_required').'.'}}</li>
                                        <li>{{translate('save_the_settings').'.'}}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="d-flex flex-column align-items-center gap-2">
                                    <img width="80" class="mb-3"
                                         src="{{dynamicAsset(path: 'public/assets/back-end/img/test-smtp.png')}}" loading="lazy"
                                         alt="">
                                    <h4 class="lh-md mb-3 text-capitalize">{{translate('test_SMTP_connection')}}</h4>
                                    <ul class="d-flex flex-column px-4 gap-2 mb-4">
                                        <li>{{translate('click_on_the').'"'.translate('send_test_mail').'"'.translate('button_to_verify_the_SMTP_connection')}}
                                        </li>
                                        <li>{{translate('if_successful,_you_will_see_a_confirmation_message_indicating_that_the_connection_is_working_fine').'.'}} </li>
                                        <li>{{translate('if_not,_double-check_your_SMTP_settings_and_try_again').'.'}}</li>
                                        <li>{{translate('note').':'.translate('if_you`re_unsure_about_the_SMTP_settings,_contact_your_email_service_provider_or_IT_administrator_for_assistance').'.'}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="d-flex flex-column align-items-center gap-2 mb-4">
                                    <img width="80" class="mb-3"
                                         src="{{dynamicAsset(path: 'public/assets/back-end/img/enable-mail-config.png')}}"
                                         loading="lazy" alt="">
                                    <h4 class="lh-md mb-3 text-capitalize">{{translate('enable_mail_configuration')}}</h4>
                                    <ul class="d-flex flex-column px-4 gap-2 mb-4">
                                        <li>{{translate('if_the_SMTP_connection_test_is_successful,_you_can_now_enable_the_mail_configuration_services_by_toggling_the_switch_to_"ON"')}}</li>
                                        <li>{{translate('this_will_allow_the_system_to_send_emails_using_the_configured_SMTP_settings').'.'}}</li>
                                    </ul>
                                    <button class="btn btn-primary px-10 mt-3 text-capitalize"
                                            data-dismiss="modal">{{ translate('got_it') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination mb-2"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="send-mail-confirmation-modal" tabindex="-1"
         aria-labelledby="send-mail-confirmation-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0 d-flex justify-content-end">
                    <button type="button" class="btn-close border-0" data-dismiss="modal" aria-label="Close">
                        <i class="tio-clear"></i></button>
                </div>
                <div class="modal-body px-4 px-sm-5 pt-0 text-center">
                    <div class="d-flex flex-column align-items-center gap-2">
                        <img width="80" class="mb-3" src="{{dynamicAsset(path: 'public/assets/back-end/img/send-mail.png')}}"
                             loading="lazy" alt="">
                        <h4 class="lh-md">{{translate('send_a_test_mail_to_your_email').'?'}}  </h4>
                        <p class="text-muted">{{translate('a_test_mail_will_be_send_to_your_email_to')}}
                            <br> {{translate('confirm_it_works_perfectly').'.'}}</p>
                        <button type="button" id="text-mail-send"
                                class="btn btn--primary px-5 px-sm-10 text-capitalize">{{translate('send_mail')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <span id="get-send-mail-route-text" data-action="{{route('admin.business-settings.mail.send')}}"
          data-error-text="{{translate("email_configuration_error").'!!'}}"
          data-success-text="{{translate("email_configured_perfectly")}}"
          data-info-text="{{translate("email_status_is_not_active").'!'}}"
          data-invalid-text="{{translate("invalid_email_address").'!'}}">
    </span>
@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/vendor/swiper/swiper-bundle.min.js')}}"></script>
    <script src="{{dynamicAsset(path: 'public/assets/back-end/js/admin/business-setting/mail.js')}}"></script>
@endpush
