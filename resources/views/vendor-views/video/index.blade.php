@extends('layouts.back-end.app-seller')

@section('title', translate('video_list'))

@section('content')
    <div class="content container-fluid">
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/brand-setup.png') }}" alt="">
                {{ translate('video_list') }}
            </h2>
        </div>

        <div class="row mt-20">
            <div class="col-md-12">
                <div class="card">
                    <div class="px-3 py-4">
                        <div class="row justify-content-between align-items-center flex-grow-1">
                            <div class="col-sm-4 col-md-6 col-lg-8 mb-2 mb-sm-0">
                                <h5 class="mb-0 text-capitalize d-flex gap-2">
                                    {{ translate('video_list') }}
                                    <span class="badge badge-soft-dark radius-50 fz-12 ml-1">{{ $videos->total() }}</span>
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
                                        <input id="datatableSearch_" type="search" name="searchValue" class="form-control" placeholder="{{ translate('search_by_title') }}" value="{{ request('searchValue') }}" aria-label="{{ translate('search_by_title') }}" required>
                                        <button type="submit" class="btn btn--primary">{{ translate('search') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="datatable" class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table {{ Session::get('direction') === 'rtl' ? 'text-right' : 'text-left' }}">
                            <thead class="thead-light thead-50 text-capitalize">
                                <tr>
                                    <th>{{ translate('SL') }}</th>
                                    <th>{{ translate('title') }}</th>
                                    <th>{{ translate('description') }}</th>
                                    <th>{{ translate('type') }}</th>
                                    <th class="text-center"> {{ translate('action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($videos as $key => $video)
                                @php
                                if (count($video['translations'])) {
                                    $translate=[];
                                    foreach ($video['translations'] as $translation) {
                                        if ($translation->locale==$defaultLanguage && $translation->key=="title") {
                                            $translate[$defaultLanguage]['title']=$translation->value;
                                        }

                                        if ($translation->locale==$defaultLanguage && $translation->key=="description") {
                                            $translate[$defaultLanguage]['description']=$translation->value;
                                        }
                                    }
                                }
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $translate[$defaultLanguage]['title'] ?? $video->title }}</td> 
                                    <td class="overflow-hidden max-width-100px">
                                        <span data-toggle="tooltip" data-placement="right" title="{{ $translate[$defaultLanguage]['description'] ?? $video->description }}">{{ Str::limit($translate[$defaultLanguage]['description'] ?? $video->description, 50) }}</span>
                                    </td>
                                    <td>@if($video->type=='2'){{ translate('file') }}@else{{ translate('url') }}@endif</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="@if($video->type=='2'){{ getValidImage(path: '/storage/app/public/videos/'.$video->video) }}@else{{ $video->video }}@endif" target="_blank" class="btn btn-outline-primary btn-sm square-btn" title="{{ translate('view') }}">
                                                <i class="tio-invisible"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive mt-4">
                        <div class="px-4 d-flex justify-content-lg-end">
                            {{ $videos->links() }}
                        </div>
                    </div>

                    @if(count($videos)==0)
                        <div class="text-center p-4">
                            <img class="mb-3 w-160" src="{{ dynamicAsset(path: 'public/assets/back-end/svg/illustrations/sorry.svg')}}" alt="{{ translate('image_description') }}">
                            <p class="mb-0">{{ translate('no_data_to_show') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection