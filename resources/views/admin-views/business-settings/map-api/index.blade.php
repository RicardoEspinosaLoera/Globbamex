@php use App\Utils\Helpers; @endphp
@extends('layouts.back-end.app')

@section('title', translate('third_party_apis'))

@section('content')
    <div class="content container-fluid">
        <div class="mb-4 pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{dynamicAsset(path: 'public/assets/back-end/img/3rd-party.png')}}" alt="">
                {{translate('3rd_party')}}
            </h2>
        </div>
        @include('admin-views.business-settings.third-party-inline-menu')
        @php($map_api_key=Helpers::get_business_settings('map_api_key'))
        @php($map_api_key_server=Helpers::get_business_settings('map_api_key_server'))
        <div class="card">
            <div class="card-body">
                <form
                    action="{{ env('APP_MODE') != 'demo' ? route('admin.business-settings.map-api') : 'javascript:' }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex align-items-center gap-2 justify-content-between mb-3">
                        <h4 class="text-capitalize mb-0">{{translate('google_map_API_setup')}}</h4>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title-color d-flex">{{translate('map_api_key').'('.translate('client').')'}} </label>
                                <input type="text" placeholder="{{translate('map_api_key'.'('.translate('client').')')}}"
                                       class="form-control" name="map_api_key"
                                       value="{{env('APP_MODE')!='demo' ? $map_api_key ?? '' : ''}}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="title-color d-flex">{{translate('map_api_key')}} ({{translate('server')}}
                                    )</label>
                                <input type="text" placeholder="{{translate('map_api_key')}} ({{translate('server')}})"
                                       class="form-control" name="map_api_key_server"
                                       value="{{env('APP_MODE')!='demo' ? $map_api_key_server ?? '' : ''}}" required>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3">
                        <button type="reset" class="btn btn-secondary px-5">{{translate('reset')}}</button>
                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                class="btn btn--primary px-5 {{env('APP_MODE')!='demo'? '' : 'call-demo'}}">{{translate('submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
