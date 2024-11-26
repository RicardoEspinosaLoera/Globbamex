@extends('layouts.back-end.app')

@section('title', translate('video_add'))

@section('content')
    <div class="content container-fluid">

        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <img width="20" src="{{ dynamicAsset(path: 'public/assets/back-end/img/brand-setup.png') }}" alt="">
                {{ translate('add_new_video') }}
            </h2>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-body text-start">
                        <form action="{{ route('admin.videos.add') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <ul class="nav nav-tabs w-fit-content mb-4">
                                @foreach ($languages as $language)
                                <li class="nav-item">
                                    <span class="nav-link text-capitalize form-system-language-tab @if($language==$defaultLanguage) active @endif cursor-pointer" id="{{ $language }}-link">{{ getLanguageName($language).'('.strtoupper($language).')' }}</span>
                                </li>
                                @endforeach
                            </ul>

                            @foreach ($languages as $key => $language)
                            <div class="row form-system-language-form @if($language!=$defaultLanguage) d-none @endif" id="{{ $language }}-form">
                                <input type="hidden" name="lang[]" value="{{ $language }}">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="{{ $language }}_title" class="title-color">{{ translate('title') }} ({{ strtoupper($language) }})</label>
                                        <input type="text" name="title[]" class="form-control" placeholder="{{ translate('enter_title') }}" @if($language==$defaultLanguage) required @endif value="{{ old('title.'.$key) }}" id="{{ $language }}_title">
                                    </div>

                                    <div class="form-group">
                                        <label for="{{ $language }}_description" class="title-color">{{ translate('description') }} ({{ strtoupper($language) }})</label>
                                        <textarea name="description[]" class="form-control" placeholder="{{ translate('enter_description') }}" rows="3" id="{{ $language }}_description">{{ old('description.'.$key) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="type" class="title-color">{{ translate('type') }}<span class="text-danger">*</span></label>
                                        <select name="type" class="form-control" required id="type">
                                            <option value="1" @if(old('type')=='1') selected @endif>{{ translate('url') }}</option>
                                            <option value="2" @if(old('type')=='2') selected @endif>{{ translate('file') }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group @if(!is_null(old('type')) && old('type')!='1') d-none @endif" id="video-url">
                                        <label for="url" class="title-color">{{ translate('url') }}<span class="text-danger">*</span></label>
                                        <input type="text" name="url" class="form-control" placeholder="{{ translate('enter_url') }}" value="{{ old('url') }}" id="url">
                                    </div>

                                    <div class="form-group @if(is_null(old('type')) || (!is_null(old('type')) && old('type')!='2')) d-none @endif" id="video-file">
                                        <label for="video" class="title-color">{{ translate('video') }}<span class="text-danger">*</span></label>
                                        <div class="custom-file text-left">
                                            <input type="file" name="video" class="custom-file-input" accept="video/*" id="video">
                                            <label class="custom-file-label" for="video">{{ translate('choose_file') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-3 justify-content-end">
                                <button type="reset" class="btn btn-secondary px-4" id="reset">{{ translate('reset') }}</button>
                                <button type="submit" class="btn btn--primary px-4">{{ translate('submit') }}</button>
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