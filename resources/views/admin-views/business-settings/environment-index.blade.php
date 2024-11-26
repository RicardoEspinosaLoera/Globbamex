@extends('layouts.back-end.app')

@section('title', translate('environment_setup'))

@section('content')
<div class="content container-fluid">
    <div class="mb-4 pb-2">
        <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
            <img src="{{dynamicAsset(path: 'public/assets/back-end/img/system-setting.png')}}" alt="">
            {{translate('system_Setup')}}
        </h2>
    </div>
    @include('admin-views.business-settings.system-settings-inline-menu')
    <div class="card">
        <div class="border-bottom px-4 py-3">
            <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{dynamicAsset(path: 'public/assets/back-end/img/environment.png')}}" alt="">
                {{translate('environment_information')}}
            </h5>
        </div>
        <div class="card-body">
            <form action="{{route('admin.business-settings.web-config.environment-setup')}}" method="post"
                    enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="col-md-12 col-12">
                        <div class="form-group">
                            <label class="title-color d-flex">{{translate('app_url')}}</label>
                            <input type="text" value="{{ env('APP_URL') }}"
                                    name="app_url" class="form-control"
                                    placeholder="{{ translate('ex').':'.'http://localhost'}}" required disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label class="title-color d-flex">{{translate('DB_connection')}}</label>
                            <input type="text" value="{{ env('APP_MODE') != 'demo' ? env('DB_CONNECTION') : '---' }}"
                                    name="db_connection" class="form-control"
                                    placeholder="{{ translate('ex').':'.'mysql' }}" required disabled>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label class="title-color d-flex">{{translate('DB_host')}}</label>
                            <input type="text" value="{{ env('APP_MODE') != 'demo' ? env('DB_HOST') : '---' }}"
                                    name="db_host" class="form-control"
                                    placeholder="{{ translate('ex').':'.'http://localhost/' }}" required disabled>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label class="title-color d-flex">{{translate('DB_port')}}</label>
                            <input type="text" value="{{ env('APP_MODE') != 'demo' ? env('DB_PORT') : '---' }}"
                                    name="db_port" class="form-control"
                                    placeholder="{{ translate('ex').':'.'3306' }}" required disabled>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label class="title-color d-flex">{{translate('DB_database')}}</label>
                            <input type="text" value="{{ env('APP_MODE') != 'demo' ? env('DB_DATABASE') : '---' }}"
                                    name="db_database" class="form-control"
                                    placeholder="{{ translate('ex').':'.'demo_db'}} " required disabled>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label class="title-color d-flex">{{translate('DB_username')}}</label>
                            <input type="text" value="{{ env('APP_MODE') != 'demo' ? env('DB_USERNAME') : '---' }}"
                                    name="db_username" class="form-control"
                                    placeholder="{{ translate('ex').':'.translate('root')  }}" required disabled>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label class="title-color d-flex">{{translate('DB_password')}}</label>
                            <input type="text" value="{{ env('APP_MODE') != 'demo' ? env('DB_PASSWORD') : '---' }}"
                                    name="db_password" class="form-control"
                                    placeholder="{{ translate('ex').':'.translate('password') }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end flex-wrap gap-3">
                    <button type="reset" class="btn btn-secondary px-5">{{translate('reset')}}</button>
                    <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                        class="btn btn--primary px-5 {{env('APP_MODE')!='demo'?'':'call-demo'}}">{{translate('submit')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
