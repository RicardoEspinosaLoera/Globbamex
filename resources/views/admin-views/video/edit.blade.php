@extends('layouts.back-end.app')

@section('title', translate('video_update'))

@section('content')
    <div class="content container-fluid">

        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <h2 class="h1 mb-0 align-items-center d-flex gap-2">
                <img width="20" src="{{ dynamicAsset(path: 'public/assets/back-end/img/brand-setup.png') }}" alt="">
                {{ translate('video_update') }}
            </h2>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-body text-start">
                        <form action="{{ route('admin.videos.update', [$video->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <ul class="nav nav-tabs w-fit-content mb-4">
                                @foreach($languages as $language)
                                <li class="nav-item">
                                    <span class="nav-link text-capitalize form-system-language-tab @if($language==$defaultLanguage) active @endif cursor-pointer" id="{{ $language }}-link">{{ getLanguageName($language).'('.strtoupper($language).')' }}</span>
                                </li>
                                @endforeach
                            </ul>

                            @foreach ($languages as $key => $language)
                            @php
                            if (count($video['translations'])) {
                                $translate=[];
                                foreach ($video['translations'] as $translation) {
                                    if ($translation->locale==$language && $translation->key=="title") {
                                        $translate[$language]['title']=$translation->value;
                                    }

                                    if ($translation->locale==$language && $translation->key=="description") {
                                        $translate[$language]['description']=$translation->value;
                                    }
                                }
                            }
                            @endphp
                            <div class="row form-system-language-form @if($language!=$defaultLanguage) d-none @endif" id="{{ $language }}-form">
                                <input type="hidden" name="lang[]" value="{{ $language }}">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="{{ $language }}_title" class="title-color">{{ translate('title') }} ({{ strtoupper($language) }})</label>
                                        <input type="text" name="title[]" class="form-control" placeholder="{{ translate('enter_title') }}" @if($language==$defaultLanguage) required @endif value="{{ old('title.'.$key, $translate[$language]['title'] ?? $video['title']) }}" id="{{ $language }}_title">
                                    </div>

                                    <div class="form-group">
                                        <label for="{{ $language }}_description" class="title-color">{{ translate('description') }} ({{ strtoupper($language) }})</label>
                                        <textarea name="description[]" class="form-control" placeholder="{{ translate('enter_description') }}" rows="3" id="{{ $language }}_description">{{ old('description.'.$key, $translate[$language]['description'] ?? $video['description']) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="type" class="title-color">{{ translate('type') }}<span class="text-danger">*</span></label>
                                        <select name="type" class="form-control" required id="type">
                                            <option value="1" @if(old('type', $video->type)=='1') selected @endif>{{ translate('url') }}</option>
                                            <option value="2" @if(old('type', $video->type)=='2') selected @endif>{{ translate('file') }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group @if(!is_null(old('type', $video->type)) && old('type', $video->type)!='1') d-none @endif" id="video-url">
                                        <label for="url" class="title-color">{{ translate('url') }}<span class="text-danger">*</span></label>
                                        <input type="text" name="url" class="form-control" placeholder="{{ translate('enter_url') }}" value="@if($video->type=='1'){{ old('url', $video->video) }}@else{{ old('url') }}@endif" id="url">
                                    </div>

                                    <div class="form-group @if(is_null(old('type', $video->type)) || (!is_null(old('type', $video->type)) && old('type', $video->type)!='2')) d-none @endif" id="video-file">
                                        <label for="video" class="title-color">{{ translate('video') }}<span class="text-danger">*</span></label>
                                        <div class="custom-file text-left">
                                            <input type="file" name="video" class="custom-file-input" accept="video/*" id="video">
                                            <label class="custom-file-label" for="video">@if($video->type=='2'){{ $video->video }}@else{{ translate('choose_file') }}@endif</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-3">
                                <button type="reset" class="btn btn-secondary px-4" id="reset">{{ translate('reset') }}</button>
                                <button type="submit" class="btn btn--primary px-4">{{ translate('update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script type="text/javascript">
    $('#type').change(function() {
        if ($(this).val()=='2') {
            $('#video-url').addClass('d-none');
            $('#video-file').removeClass('d-none');
        } else {
            $('#video-file').addClass('d-none');
            $('#video-url').removeClass('d-none');
        }
    });
</script>
@endpush