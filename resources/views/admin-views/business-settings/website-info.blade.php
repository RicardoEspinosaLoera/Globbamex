@extends('layouts.back-end.app')

@section('title', translate('general_Settings'))

@section('content')
    <div class="content container-fluid">
        <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{dynamicAsset(path: 'public/assets/back-end/img/business-setup.png')}}" alt="">
                {{ translate('business_Setup') }}
            </h2>
            <div class="btn-group">

                <div
                    class="dropdown-menu dropdown-menu-right bg-aliceblue border border-color-primary-light p-4 dropdown-w-lg">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <img width="20" src="{{dynamicAsset(path: 'public/assets/back-end/img/note.png')}}" alt="">
                        <h5 class="text-primary mb-0">{{translate('note')}}</h5>
                    </div>
                    <p class="title-color font-weight-medium mb-0">{{ translate('please_click_save_information_button_below_to_save_all_the_changes') }}</p>
                </div>
            </div>
        </div>
        @include('admin-views.business-settings.business-setup-inline-menu')
        <div class="alert alert-danger d-none mb-3" role="alert">
            {{translate('changing_some_settings_will_take_time_to_show_effect_please_clear_session_or_wait_for_60_minutes_else_browse_from_incognito_mode')}}
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <form action="{{route('admin.business-settings.maintenance-mode')}}" method="post" id="maintenance-mode-form">
                    @csrf
                    <div class="border rounded border-color-c1 px-4 py-3 d-flex justify-content-between mb-1">
                        <h5 class="mb-0 d-flex gap-1 c1">
                            {{translate('maintenance_mode')}}
                        </h5>
                        <div class="position-relative">
                            <label class="switcher">
                                <input type="checkbox" class="switcher_input toggle-switch-message" id="maintenance-mode" name="value"
                                   value="1" {{isset($businessSetting['maintenance_mode']) && $businessSetting['maintenance_mode']==1?'checked':''}}
                                   data-modal-id="toggle-status-modal"
                                   data-toggle-id="maintenance-mode"
                                   data-on-image="maintenance_mode-on.png"
                                   data-off-image="maintenance_mode-off.png"
                                   data-on-title="{{translate('Want_to_enable_the_Maintenance_Mode')}}"
                                   data-off-title="{{translate('Want_to_disable_the_Maintenance_Mode')}}"
                                   data-on-message="<p>{{translate('if_enabled_all_your_apps_and_customer_website_will_be_temporarily_off')}}</p>"
                                   data-off-message="<p>{{translate('if_disabled_all_your_apps_and_customer_website_will_be_functional')}}</p>">
                                <span class="switcher_control"></span>
                            </label>
                        </div>
                    </div>
                </form>
                <p>{{'*'.translate('by_turning_the').', "'. translate('Maintenance_Mode').'"'.translate('ON').' '.translate('all_your_apps_and_customer_website_will_be_disabled_until_you_turn_this_mode_OFF').' '.translate('only_the_Admin_Panel_&_Vendor_Panel_will_be_functional')}}
                </p>
            </div>
        </div>
        <form action="{{ route('admin.business-settings.web-config.update') }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0 text-capitalize d-flex gap-1">
                        <i class="tio-user-big"></i>
                        {{translate('company_information')}}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 col-lg-4">
                            <div class="form-group">
                                <label
                                    class="title-color d-flex">{{translate('company_Name')}}</label>
                                <input class="form-control" type="text" name="company_name"
                                       value="{{ $businessSetting['company_name'] }}"
                                       placeholder="{{translate('new_business')}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="form-group">
                                <label class="title-color d-flex">{{translate('phone')}}</label>
                                <input class="form-control" type="text" name="company_phone"
                                       value="{{ $businessSetting['company_phone'] }}"
                                       placeholder="{{translate('01xxxxxxxx')}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="form-group">
                                <label
                                    class="title-color d-flex">{{translate('email')}}</label>
                                <input class="form-control" type="text" name="company_email"
                                       value="{{ $businessSetting['company_email'] }}"
                                       placeholder="{{translate('company@gmail.com')}}">
                            </div>
                        </div>

                        @php($countryCode = getWebConfig(name: 'country_code'))
                        <div class="col-sm-6 col-lg-4">
                            <div class="form-group">
                                <label class="title-color d-flex">{{translate('country')}} </label>
                                <select id="country" name="country_code" class="form-control js-select2-custom">
                                    @foreach(COUNTRIES as $country)
                                        <option value="{{$country['code']}}" {{ $countryCode?($countryCode==$country['code']?'selected':''):'' }} >
                                            {{$country['name']}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @php($timeZone = getWebConfig(name: 'timezone'))
                        <div class="col-sm-6 col-lg-4">
                            <div class="form-group">
                                <label class="title-color d-flex">{{translate('time_zone')}}</label>
                                <select name="timezone" class="form-control js-select2-custom">
                                    @foreach(App\Enums\GlobalConstant::TIMEZONE_ARRAY as $timeZoneArray)
                                        <option value="{{$timeZoneArray['value']}}" {{$timeZone?($timeZone==$timeZoneArray['value'] ? 'selected':''):''}}>
                                            {{$timeZoneArray['name']}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-4">
                            <div class="form-group">
                                <label class="title-color d-flex" for="language">{{translate('language')}}</label>
                                <select name="language" class="form-control js-select2-custom">
                                    @if (isset($businessSetting['language']))
                                        @foreach (json_decode($businessSetting['language']) as $item)
                                            <option
                                                value="{{ $item->code }}" {{ $item->default == 1?'selected':'' }}>{{ ucwords($item->name).' ('.ucwords($item->code).')' }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="form-group">
                                <label class="title-color d-flex">{{translate('company_address')}}</label>
                                <input type="text" value="{{ $businessSetting['shop_address'] }}"
                                       name="shop_address" class="form-control" id="shop-address"
                                       placeholder="{{translate('your_shop_address')}}"
                                       required>
                            </div>
                        </div>
                        @php($default_location = getWebConfig(name: 'default_location'))
                        <div class="col-sm-6 col-lg-4">
                            <div class="form-group">
                                <label class="title-color d-flex">
                                    {{translate('latitude')}}
                                    <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                          data-placement="right"
                                          title="{{translate('copy_the_latitude_of_your_business_location_from_Google_Maps_and_paste_it_here')}}">
                                        <img width="16" src="{{dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg')}}"
                                             alt="">
                                    </span>
                                </label>
                                <input class="form-control latitude" type="text" name="latitude" id="latitude"
                                       value="{{ !empty($default_location['lat'])?$default_location['lat']: '-33.8688' }}"
                                       placeholder="{{translate('latitude')}}"  disabled>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="form-group">
                                <label class="title-color d-flex">
                                    {{translate('longitude')}}
                                    <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                          data-placement="right"
                                          title="{{translate('copy_the_longitude_of_your_business_location_from_Google_Maps_and_paste_it_here')}}">
                                        <img width="16" src="{{dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg')}}"
                                             alt="">
                                    </span>
                                </label>
                                <input class="form-control longitude" type="text" name="longitude" id="longitude"
                                       value="{{ !empty($default_location['lng'])?$default_location['lng']:'151.2195' }}"
                                       placeholder="{{translate('longitude')}}"   disabled>

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="title-color d-flex justify-content-end">
                                    <span class="badge badge--primary-2">
                                       {{translate('latitude').' : '}}
                                        <span  id="showLatitude">
                                            {{(!empty($default_location['lat'])?$default_location['lat']:'-33.8688')}}
                                        </span>
                                    </span>
                                    <span class="mx-1 badge badge--primary-2" id="showLongitude">
                                       {{translate('longitude').' : '}}
                                        <span  id="showLongitude">
                                            {{(!empty($default_location['lng'])?$default_location['lng']:'151.2195')}}
                                        </span>
                                    </span>
                                </label>
                                <input id="map-pac-input" class="form-control rounded __map-input mt-1"
                                       title="{{translate('search_your_location_here')}}" type="text"
                                       placeholder="{{translate('search_here')}}"/>
                                <div class="rounded w-100 __h-200px mb-5"
                                     id="location-map-canvas"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0 text-capitalize d-flex gap-1">
                        <i class="tio-briefcase"></i>
                        {{translate('business_information')}}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-sm-6 col-lg-4">
                            <div class="form-group">
                                <label class="title-color d-flex" for="currency">{{translate('currency')}} </label>
                                <select name="currency_id" class="form-control js-select2-custom">
                                    @foreach ($CurrencyList as $item)
                                        <option
                                            value="{{ $item->id }}" {{ $item->id == $businessSetting['system_default_currency'] ?'selected':'' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <label class="title-color d-flex">{{translate('currency_Position')}}</label>
                            <div class="form-control form-group d-flex gap-2">
                                <div class="custom-control custom-radio flex-grow-1">
                                    <input type="radio" class="custom-control-input" value="left"
                                           name="currency_symbol_position"
                                           id="currency_position_left" {{ $businessSetting['currency_symbol_position'] == 'left' ? 'checked':'' }}>
                                    <label class="custom-control-label"
                                           for="currency_position_left">({{ getCurrencySymbol(currencyCode: getCurrencyCode(type: 'default')) }}
                                        ) {{translate('left')}}</label>
                                </div>
                                <div class="custom-control custom-radio flex-grow-1">
                                    <input type="radio" class="custom-control-input" value="right"
                                           name="currency_symbol_position"
                                           id="currency_position_right" {{ $businessSetting['currency_symbol_position'] == 'right' ? 'checked':'' }}>
                                    <label class="custom-control-label"
                                           for="currency_position_right">{{translate('right')}}
                                        ({{ getCurrencySymbol(currencyCode: getCurrencyCode(type: 'default')) }}
                                        )</label>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <label class="title-color d-flex">
                                {{translate('forgot_password_verification_by')}}
                                <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                      data-placement="right"
                                      title="{{translate('set_how_users_of_recover_their_forgotten_password')}}">
                                    <img width="16" src="{{dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg')}}"
                                         alt="">
                                </span>
                            </label>
                            <div class="form-control form-group d-flex gap-2">
                                <div class="custom-control custom-radio flex-grow-1">
                                    <input type="radio" class="custom-control-input" value="email"
                                           name="forgot_password_verification"
                                           id="verification_by_email" {{ $businessSetting['forgot_password_verification'] == 'email' ? 'checked':'' }}>
                                    <label class="custom-control-label"
                                           for="verification_by_email">{{translate('email')}}</label>
                                </div>
                                <div class="custom-control custom-radio flex-grow-1">
                                    <input type="radio" class="custom-control-input" value="phone"
                                           name="forgot_password_verification"
                                           id="verification_by_phone" {{ $businessSetting['forgot_password_verification'] == 'phone' ? 'checked':'' }}>
                                    <label class="custom-control-label"
                                           for="verification_by_phone">{{translate('phone').' '.'('.translate('OTP').')'}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <label class="title-color d-flex">{{translate('business_model')}}</label>
                            <div class="form-control form-group d-flex gap-2">
                                <div class="custom-control custom-radio flex-grow-1">
                                    <input type="radio" class="custom-control-input" value="single" name="business_mode"
                                           id="single_vendor" {{ $businessSetting['business_mode'] == 'single' ? 'checked':'' }}>
                                    <label class="custom-control-label"
                                           for="single_vendor">{{translate('single_vendor')}}</label>
                                </div>
                                <div class="custom-control custom-radio flex-grow-1">
                                    <input type="radio" class="custom-control-input" value="multi" name="business_mode"
                                           id="multi_vendor" {{ $businessSetting['business_mode'] == 'multi' ? 'checked':'' }}>
                                    <label class="custom-control-label"
                                           for="multi_vendor">{{translate('multi_vendor')}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="form-group">
                                <div class="d-flex justify-content-between align-items-center gap-10 form-control">
                                    <span class="title-color text-capitalize">
                                        {{translate('email_verification')}}
                                        <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                              data-placement="right"
                                              title="{{translate('if_enabled_users_can_receive_verification_codes_on_their_registered_email_addresses')}}">
                                            <img width="16"
                                                 src="{{dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg')}}" alt="">
                                        </span>
                                    </span>

                                    <label class="switcher" for="email-verification">
                                        <input type="checkbox" class="switcher_input toggle-switch-message"
                                               name="email_verification"
                                               id="email-verification"
                                               value="1"
                                               {{ $businessSetting['email_verification'] == 1 ? 'checked':'' }}
                                               data-modal-id="toggle-modal"
                                               data-toggle-id="email-verification"
                                               data-on-image="email-verification-on.png"
                                               data-off-image="email-verification-off.png"
                                               data-on-title="{{translate('want_to_Turn_OFF_the_Email_Verification')}}"
                                               data-off-title="{{translate('want_to_Turn_ON_the_Email_Verification')}}"
                                               data-on-message="<p>{{translate('if_disabled_users_would_not_receive_verification_codes_on_their_registered_email_addresses')}}</p>"
                                               data-off-message="<p>{{translate('if_enabled_users_will_receive_verification_codes_on_their_registered_email_addresses')}}</p>">
                                        <span class="switcher_control"></span>
                                    </label>
                                </div>

                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-4">
                            @php($phoneVerification = getWebConfig(name: 'phone_verification'))
                            <div class="form-group">
                                <div class="d-flex justify-content-between align-items-center gap-10 form-control">
                                    <span class="title-color">
                                        {{translate('OTP_Verification')}}
                                        <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                              data-placement="right"
                                              title="{{translate('if_enabled_users_can_receive_verification_codes_via_OTP_messages_on_their_registered_phone_numbers')}}">
                                            <img width="16"
                                                 src="{{dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg')}}" alt="">
                                        </span>
                                    </span>

                                    <label class="switcher" for="otp-verification">
                                        <input type="checkbox" class="switcher_input toggle-switch-message"
                                               name="phone_verification"
                                               id="otp-verification"
                                               value="1" {{ $phoneVerification == 1 ? 'checked':'' }}
                                               data-modal-id="toggle-modal"
                                               data-toggle-id="otp-verification"
                                               data-on-image="otp-verification-on.png"
                                               data-off-image="otp-verification-off.png"
                                               data-on-title="{{translate('want_to_Turn_OFF_the_OTP_Verification')}}"
                                               data-off-title="{{translate('want_to_Turn_ON_the_OTP_Verification')}}"
                                               data-on-message="<p>{{translate('if_disabled_users_would_not_receive_verification_codes_on_their_registered_phone_numbers')}}</p>"
                                               data-off-message="<p>{{translate('if_enabled_users_will_receive_verification_codes_on_their_registered_phone_numbers')}}</p>">
                                        <span class="switcher_control"></span>
                                    </label>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="form-group">
                                <label class="title-color d-flex">
                                    {{translate('pagination')}}
                                    <span class="input-label-secondary cursor-pointer" data-toggle="tooltip"
                                          data-placement="right"
                                          title="{{translate('this_number_indicates_how_much_data_will_be_shown_in_the_list_or_table')}}">
                                        <img width="16" src="{{dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg')}}"
                                             alt="">
                                    </span>
                                </label>
                                <input type="number" value="{{ $businessSetting['pagination_limit'] }}"
                                       name="pagination_limit" class="form-control" placeholder="25">
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="form-group">
                                <label class="title-color d-flex">{{translate('Company_Copyright_Text')}}</label>
                                <input class="form-control" type="text" name="company_copyright_text"
                                       value="{{ $businessSetting['company_copyright_text'] }}"
                                       placeholder="{{translate('company_copyright_text')}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4">
                            <div class="form-group">
                                <label
                                    class="input-label text-capitalize">{{translate('digit_after_decimal_point')}}
                                    ( {{translate('ex').':'. '0.00'}})</label>
                                <input type="number" value="{{ $businessSetting['decimal_point_settings'] }}"
                                       name="decimal_point_settings" class="form-control" min="0"
                                       placeholder="{{translate('4')}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-xxl-4 col-sm-6 mb-3">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="mb-0 d-flex align-items-center gap-2">
                                <img src="{{dynamicAsset(path: 'public/assets/back-end/img/website-color.png')}}" alt="">
                                {{translate('website_Color')}}
                            </h5>
                        </div>
                        <div class="card-body d-flex flex-wrap gap-4 justify-content-around">
                            <div class="form-group">
                                <input type="color" name="primary" value="{{ $businessSetting['primary_color'] }}"
                                       class="form-control form-control_color">
                                <div class="text-center">
                                    <div
                                        class="title-color mb-4 mt-3">{{ strtoupper($businessSetting['primary_color']) }}</div>
                                    <label class="title-color text-capitalize">{{translate('primary_Color')}}</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="color" name="secondary" value="{{ $businessSetting['secondary_color'] }}"
                                       class="form-control form-control_color">
                                <div class="text-center">
                                    <div
                                        class="title-color mb-4 mt-3">{{ strtoupper($businessSetting['secondary_color']) }}</div>
                                    <label class="title-color text-capitalize">
                                        {{translate('secondary_Color')}}
                                    </label>
                                </div>
                            </div>
                            @if(theme_root_path() == 'theme_aster')
                                <div class="form-group">
                                    <input type="color" name="primary_light"
                                           value="{{ $businessSetting['primary_color_light'] ?? '#CFDFFB' }}"
                                           class="form-control form-control_color">
                                    <div class="text-center">
                                        <div
                                            class="title-color mb-4 mt-3">{{ $businessSetting['primary_color_light'] ?? '#CFDFFB' }}</div>
                                        <label
                                            class="title-color text-capitalize">{{translate('primary_Light_Color')}}</label>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-sm-6 mb-3">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2">
                                <img src="{{dynamicAsset(path: 'public/assets/back-end/img/header-logo.png')}}" alt="">
                                {{translate('website_header_logo')}}
                            </h5>
                            <span
                                class="badge badge-soft-info">{{ THEME_RATIO[theme_root_path()]['Main website Logo'] }}</span>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-around">
                            <div class="d-flex justify-content-center">
                                <img height="60" id="view-website-logo" alt=""
                                     src="{{ getValidImage(path: 'storage/app/public/company/'. $businessSetting['web_logo'] , type: 'backend-basic') }}">
                            </div>
                            <div class="mt-4 position-relative">
                                <input type="file" name="company_web_logo" id="website-logo"
                                       class="custom-file-input image-input" data-image-id="view-website-logo"
                                       accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                <label class="custom-file-label text-capitalize"
                                       for="website-logo">{{translate('choose_file')}}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-sm-6 mb-3">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2">
                                <img src="{{dynamicAsset(path: 'public/assets/back-end/img/footer-logo.png')}}" alt="">
                                {{translate('website_footer_logo')}}
                            </h5>
                            <span
                                class="badge badge-soft-info">{{ THEME_RATIO[theme_root_path()]['Main website Logo'] }}</span>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-around">
                            <div class="d-flex justify-content-center">
                                <img height="60" id="view-website-footer-logo"
                                     src="{{ getValidImage(path: 'storage/app/public/company/'. $businessSetting['footer_logo'] , type: 'backend-basic') }}"alt="">
                            </div>
                            <div class="position-relative mt-4">
                                <input type="file" name="company_footer_logo" id="website-footer-logo"
                                       class="custom-file-input image-input" data-image-id="view-website-footer-logo"
                                       accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                <label class="custom-file-label text-capitalize"
                                       for="website-footer-logo">{{translate('choose_file')}}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-sm-6 mb-3">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2">
                                <img src="{{dynamicAsset(path: 'public/assets/back-end/img/footer-logo.png')}}" alt="">
                                {{translate('website_Favicon')}}
                            </h5>
                            <span class="badge badge-soft-info">( {{translate('ratio').'1:1'}} )</span>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-around">
                            <div class="d-flex justify-content-center">
                                <img height="60" id="view-website-fav-icon"
                                     src="{{ getValidImage(path: 'storage/app/public/company/'. $businessSetting['fav_icon'] , type: 'backend-basic') }}" alt="">
                            </div>
                            <div class="position-relative mt-4">
                                <input type="file" name="company_fav_icon" id="website-fav-icon"
                                       class="custom-file-input image-input" data-image-id="view-website-fav-icon"
                                       accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                <label class="custom-file-label"
                                       for="website-fav-icon">{{translate('choose_File')}}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-sm-6 mb-3">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2">
                                <img src="{{dynamicAsset(path: 'public/assets/back-end/img/footer-logo.png')}}" alt="">
                                {{translate('loading_gif')}}
                            </h5>
                            <span class="badge badge-soft-info">( {{translate('ratio').'1:1'}})</span>
                        </div>
                        <div class="card-body d-flex flex-column justify-content-around">
                            <div class="d-flex justify-content-center">
                                <img height="60" id="view-loader-icon"
                                     src="{{ getValidImage(path: 'storage/app/public/company/'. $businessSetting['loader_gif'] , type: 'backend-basic') }}" alt="">
                            </div>
                            <div class="position-relative mt-4">
                                <input type="file" name="loader_gif" id="loader-icon"
                                       class="custom-file-input image-input" data-image-id="view-loader-icon"
                                       accept=".webp, .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                <label class="custom-file-label text-capitalize"
                                       for="loader-icon">{{translate('choose_file')}}</label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn--primary text-capitalize px-4">{{translate('save_information')}}</button>
            </div>
        </form>
    </div>
    <span id="get-default-latitude" data-latitude="{{$default_location['lat']??'21.8671333'}}"></span>
    <span id="get-default-longitude" data-longitude="{{$default_location['lng']??'-102.291255'}}"></span>

@endsection

@push('script')
    <script src="https://maps.googleapis.com/maps/api/js?key={{getWebConfig('map_api_key')}}&callback=initAutocomplete&libraries=places&v=3.49"
        defer></script>
    <script src="{{dynamicAsset(path: 'public/assets/back-end/js/admin/business-setting/business-setting.js')}}"></script>
@endpush
