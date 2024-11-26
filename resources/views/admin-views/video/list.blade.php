@extends('layouts.back-end.app')

@section('title', translate('video_list'))

@section('content')
    <div class="content container-fluid">
        <div class="mb-3">
            <h2 class="h1 mb-0 d-flex gap-2">
                <img width="20" src="{{ dynamicAsset(path: 'public/assets/back-end/img/brand-setup.png') }}" alt="">
                {{ translate('video_list') }}
                <span class="badge badge-soft-dark radius-50 fz-14">{{ $videos->total() }}</span>
            </h2>
        </div>
        <div class="row mt-20">
            <div class="col-md-12">
                <div class="card">
                    <div class="px-3 py-4">
                        <div class="row g-2 flex-grow-1">
                            <div class="col-lg-9 col-md-9 col-12">
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group input-group-custom input-group-merge">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="searchValue" class="form-control" placeholder="{{ translate('search_by_title') }}" aria-label="{{ translate('search_by_title') }}" value="{{ request('searchValue') }}" required>
                                        <button type="submit" class="btn btn--primary input-group-text">{{ translate('search') }}</button>
                                    </div>
                                </form>
                            </div>

                            <div class="col-lg-3 col-md-3 col-12">
                                <a href="{{ route('admin.videos.add') }}" class="btn btn--primary text-nowrap text-capitalize w-100"><i class="tio-add"></i> {{ translate('add_video') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100 text-start">
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
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $video->title }}</td>
                                        <td class="overflow-hidden max-width-100px">
                                            <span data-toggle="tooltip" data-placement="right" title="{{ $video->description }}">{{ Str::limit($video->description, 50) }}</span>
                                        </td>
                                        <td>@if($video->type=='2'){{ translate('file') }}@else{{ translate('url') }}@endif</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="@if($video->type=='2'){{ getValidImage(path: '/storage/app/public/videos/'.$video->video) }}@else{{ $video->video }}@endif" target="_blank" class="btn btn-outline-primary btn-sm square-btn" title="{{ translate('view') }}">
                                                    <i class="tio-invisible"></i>
                                                </a>
                                                <a href="{{ route('admin.videos.update', [$video->id]) }}" class="btn btn-outline-info btn-sm square-btn" title="{{ translate('edit') }}">
                                                    <i class="tio-edit"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm delete square-btn delete-data" title="{{ translate('delete') }}" data-id="video-{{$video->id}}">
                                                    <i class="tio-delete"></i>
                                                </a>
                                            </div>
                                            <form action="{{ route('admin.videos.delete',['id' => $video->id]) }}" method="post" id="video-{{$video->id}}">
                                                @csrf
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <div class="d-flex justify-content-lg-end">
                            {{ $videos->links() }}
                        </div>
                    </div>
                    @if(count($videos)==0)
                        <div class="text-center p-4">
                            <img class="mb-3 w-160" src="{{ dynamicAsset(path: 'public/assets/back-end/svg/illustrations/sorry.svg') }}" alt="{{ translate('image_description') }}">
                            <p class="mb-0">{{ translate('no_data_to_show') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection