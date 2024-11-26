@extends('layouts.back-end.app')

@section('title', translate('edit_blog'))
@push('css_or_js')
<link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
<link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
<link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="content container-fluid">
        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <img width="20" src="{{ dynamicAsset(path: 'public/assets/back-end/img/brand.png') }}" alt="">
                {{ translate('edit_blog') }}
            </h2>
        </div>
        <div class="d-block flex-grow-1 w-max-md-100">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                @php
                    $languages = [
                        ['code' => 'es', 'name' => 'Español'],
                        ['code' => 'en', 'name' => 'English'],
                    ];
                    $defaultLanguage = $blog->lenguage; // Asigna el idioma del blog
                @endphp

                <ul class="nav nav-tabs w-fit-content mb-2">
                    @foreach($languages as $language)
                        <li class="nav-item text-capitalize">
                            <a class="nav-link lang-link {{ $language['code'] == $defaultLanguage ? 'active' : '' }}"
                               href="javascript:"
                               id="{{ $language['code'] }}-link"
                               data-lang="{{ $language['code'] }}">
                                {{ $language['name'] . ' (' . strtoupper($language['code']) . ')' }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.blogs.updateblog', ['idupdate' => $blog->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body text-start">
                            <div class="form-group mb-4">
                                <label for="title" class="title-color">
                                    Titulo <label id='codigo'></label><span class="text-danger">*</span>
                                </label>
                                <input type="text" name="title" id="title" class="form-control" value="{{$blog->title}}">
                            </div>

                            <div class="form-group mb-4">
                                <label for="contentido" class="title-color">
                                    Contenido <label id='codigocont'></label><span class="text-danger">*</span>
                                </label>
                                <textarea name="contentido" id="contentido" class="summernote" rows="5" required>{{$blog->content}}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="image1" class="title-color">
                                            {{ translate('image1') }} Tamaño 370 x 350px<span class="text-danger">*</span>
                                        </label>
                                        <div class="custom-file text-left">
                                            <input type="file" name="image1" id="image1" class="custom-file-input image-preview-before-upload" data-preview="#viewer1" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                            <label class="custom-file-label" for="image1">
                                                {{ translate('choose_file') }}
                                            </label>
                                        </div><br><br>
                                        <div class="text-center">
                                            <img class="upload-img-view" id="viewer1" src="{{ asset('storage/app/' . $blog->image1) }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="image2" class="title-color">
                                            {{ translate('image2') }} Tamaño 1600 x 600px
                                        </label>
                                        <div class="custom-file text-left">
                                            <input type="file" name="image2" id="image2" class="custom-file-input image-preview-before-upload" data-preview="#viewer2" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                            <label class="custom-file-label" for="image2">
                                                {{ translate('choose_file') }}
                                            </label>
                                        </div><br><br>
                                        <div class="text-center">
                                            <img class="upload-img-view" id="viewer2" src="{{ asset('storage/app/' . $blog->image2) }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                            <input type="hidden" name="codLen" id="codLen" class="form-control" value="{{$blog->lenguage}}">
                            <div class="d-flex gap-3 justify-content-end">
                                <button type="reset" id="reset" class="btn btn-secondary px-4">{{ translate('Go_back') }}</button>
                                <button type="submit" class="btn btn--primary px-4">{{ translate('submit') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/products-management.js') }}"></script>
@endpush

@push('script')
    <script>
        'use strict';
        document.getElementById('reset').addEventListener('click', function() {
        window.location.href = 'https://globbamex.com/admin/blogs/blogs';
    });
       // Variables para almacenar los valores originales
    let originalTitle = '';
    let originalContent = '';
    let originalImage1 = '';
    let originalImage2 = '';

    // Ocultar alertas después de 5 segundos
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.classList.remove('show');
            alert.classList.add('fade');
        });
    }, 9000);

    // Initialize the label with the blog language
    document.addEventListener('DOMContentLoaded', function() {
        const defaultLang = '{{ $blog->lenguage }}'; // Idioma del blog
        document.getElementById('codigo').innerText = `(${defaultLang.toUpperCase()})`;
        document.getElementById('codigocont').innerText = `(${defaultLang.toUpperCase()})`;

        // Añadir la clase "active" a la pestaña correspondiente al idioma del blog
        document.querySelectorAll('.lang-link').forEach(link => {
            if (link.getAttribute('data-lang') === defaultLang) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });

        // Guardar los valores originales
        originalTitle = document.getElementById('title').value;
        originalContent = document.getElementById('contentido').value;
        originalImage1 = document.getElementById('viewer1').src;
        originalImage2 = document.getElementById('viewer2').src;
    });

    document.querySelectorAll('.lang-link').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            
            // Remover la clase "active" de todos los enlaces
            document.querySelectorAll('.lang-link').forEach(link => link.classList.remove('active'));

            // Añadir la clase "active" al enlace clicado
            this.classList.add('active');

            let lang = this.getAttribute('data-lang');
            
            // Actualizar el label según el idioma seleccionado
            document.getElementById('codigo').innerText = `(${lang.toUpperCase()})`;
            document.getElementById('codigocont').innerText = `(${lang.toUpperCase()})`;

            // Limpiar los campos si se cambia a un idioma diferente al original
            if (lang !== '{{ $blog->lenguage }}') {
                document.getElementById('title').value = '';
                $('.summernote').summernote('code', '');
                //document.getElementById('contentido').value = ''; // Asegurar que el campo de contenido se limpie
                //alert('a'+ document.getElementById('contentido').value)
                //document.getElementById('viewer1').src = '';
                //document.getElementById('viewer2').src = '';
                $('#viewer1').attr('src', '{{ dynamicAsset(path: "public/assets/back-end/img/400x400/img2.jpg") }}');
            $('#viewer2').attr('src', '{{ dynamicAsset(path: "public/assets/back-end/img/400x400/img2.jpg") }}');
                document.getElementById('codLen').value = lang;
            } else {
                // Restaurar los valores originales si se vuelve al idioma original
                document.getElementById('title').value = originalTitle;
                //document.getElementById('contentido').value = originalContent;
                $('.summernote').summernote('code', originalContent);
                document.getElementById('viewer1').src = originalImage1;
                document.getElementById('viewer2').src = originalImage2;
                document.getElementById('codLen').value = lang;
            }
        });
    });
    </script>
@endpush
@push('script')
<script src="{{ dynamicAsset(path: 'public/assets/back-end/js/tags-input.min.js') }}"></script>
<script src="{{ dynamicAsset(path: 'public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
<script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.js') }}"></script>
<script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/product-add-update.js') }}"></script>
<script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/product-add-colors-img.js') }}"></script>
<script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
@endpush