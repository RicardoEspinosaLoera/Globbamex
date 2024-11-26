@extends('layouts.back-end.app')

@section('title', translate('FCM_Settings'))

@push('css_or_js')
    <link rel="stylesheet" href="{{ dynamicAsset(path: 'public/assets/back-end/vendor/swiper/swiper-bundle.min.css')}}"/>
@endpush

@section('content')
    <div class="content container-fluid">
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{dynamicAsset(path: 'public/assets/back-end/img/3rd-party.png')}}" alt="">
                {{translate('push_Notification_Setup')}}
            </h2>
        </div>
        <div class="d-flex flex-wrap justify-content-between gap-3 mb-4">
            @include('admin-views.push-notification._push-notification-inline-menu')

        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{route('admin.push-notification.')}}" method="post"
                      style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="title-color">{{translate('server_Key')}}</label>
                        <textarea name="push_notification_key" class="form-control text-area-max-min" rows="2"
                                  placeholder="{{translate('ex').':'.'abcd1234efgh5678ijklmnop90qrstuvwxYZ'}}"
                                  required>{{env('APP_MODE')=='demo'?'':$pushNotificationKey}}</textarea>
                    </div>
                    <div class="row d--none">
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <label class="input-label"
                                       for="exampleFormControlInput1">{{translate('FCM_Project_ID')}}</label>
                                <input type="text" value="{{$projectId}}"
                                       name="fcm_project_id" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-3 justify-content-end">
                        <button type="reset" class="btn btn-secondary px-5">{{translate('reset')}}</button>
                        <button type="submit" class="btn btn--primary px-5 {{env('APP_MODE')!='demo'?'':'call-demo'}}">{{translate('submit')}}</button>
                    </div>
                </form>
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
                                         src="{{dynamicAsset(path: 'public/assets/back-end/img/firebase-console.png')}}"
                                         loading="lazy" alt="">
                                    <h4 class="lh-md mb-3">{{translate('go_to_Firebase_Console')}}</h4>
                                    <ul class="d-flex flex-column px-4 gap-2 mb-4">
                                        <li>{{translate('open_your_web_browser_an_ go_to_the_Firebase_Console')}} <br>
                                            {{translate('(')}}<span
                                                    class="text-decoration-underline">{{translate('https://console.firebase.google.com/')}}
                                            </span>{{translate(').')}}
                                        </li>
                                        <li>{{translate('select_the_project_for_which_you_want_to_configure_FCM_from_the_Firebase_Console_dashboard')}}.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="d-flex flex-column align-items-center gap-2">
                                    <img width="80" class="mb-3"
                                         src="{{dynamicAsset(path: 'public/assets/back-end/img/navigate-settings.png')}}"
                                         loading="lazy" alt="">
                                    <h4 class="lh-md mb-3 text-capitalize">{{translate('navigate_to_project_settings')}}</h4>
                                    <ul class="d-flex flex-column px-4 gap-2 mb-4">
                                        <li>{{translate('in_the_left-hand_menu,_click_on_the').' '.'"'.translate('settings').'"'.' '.translate('gear_icon,_and_then_select').' '."Project settings".' '.translate('from_the_dropdown')}}.
                                        </li>
                                        <li>{{translate('in_the_Project_settings_page,_click_on_the').' '.'"'.translate('Cloud_Messaging').'"'.' '.translate('tab_from_the_top_menu')}}.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="d-flex flex-column align-items-center gap-2">
                                    <img width="80" class="mb-3"
                                         src="{{dynamicAsset(path: 'public/assets/back-end/img/info-asked.png')}}" loading="lazy"
                                         alt="">
                                    <h4 class="lh-md mb-3 text-capitalize">{{translate('obtain_all_the_information_asked').'!'}}</h4>
                                    <ul class="d-flex flex-column px-4 gap-2 mb-4">
                                        <li>{{translate('In_the_Firebase_Project_settings_page,_click_on_the_"General"_tab_from_the_top_menu').'.'}} </li>
                                        <li>{{translate('under_the').' '.'"'.translate('Your_Apps').'"'.' '.translate('section')}}, {{translate('click_on_the').' '.'"'.translate('WEB').'"'.' '.translate('app_for_which_you_want_to_configure_FCM')}}.
                                        </li>
                                        <li>{{translate('then_obtain').' '.translate('API_Key').','.translate('FCM_Project_ID').','.translate('Auth_Domain').','.translate('Storage_Bucket').','.translate('Messaging_Sender_ID').'.'}}
                                        </li>
                                    </ul>
                                    <p>{{translate('Note').':'.' '.translate('please_make_sure_to_use_the_obtained_information_securely_and_in_accordance_with_Firebase_and_FCM_documentation,_terms_of_service,_and_any_applicable_laws_and_regulations').'.'}}</p>
                                    <button class="btn btn-primary px-10 mt-3 text-capitalize" data-dismiss="modal">{{ translate('got_it') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination mb-2"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/vendor/swiper/swiper-bundle.min.js')}}"></script>
@endpush
