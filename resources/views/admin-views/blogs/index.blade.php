@extends('layouts.back-end.app')

@section('title', translate('my_blog'))
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
                {{ translate('my_blog') }}
            </h2>
        </div>
        <div class="d-block flex-grow-1 w-max-md-100">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                @php
                    $languages = [
                        ['code' => 'es', 'name' => 'Español'],
                        ['code' => 'en', 'name' => 'English'],
                    ];
                    $defaultLanguage = 'es';
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
        
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body text-start">
                            <form id="blog-form" action="{{ route('admin.blogs.storeblog') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group mb-4">
                                    <label for="title" class="title-color">
                                        Titulo <label id='codigo'></label><span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="title" id="title" class="form-control" required>
                                </div>

                                <!--<div class="form-group mb-4">
                                    <label for="content" class="title-color">
                                        Contenido<label id='codigocont'></label><span class="text-danger">*</span>
                                    </label>
                                    <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
                                </div>-->
                                
                                <div class="form-group mb-4">
                                    <label for="content" class="title-color">
                                        Contenido<label id='codigocont'></label><span class="text-danger">*</span>
                                    </label>
                                    <textarea name="content" id="content" class="summernote" rows="5" required></textarea>
                                </div>
                                


                                <div class="form-group mb-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="image1" class="title-color">
                                                {{ translate('image1') }} Tamaño 370 x 350px<span class="text-danger">*</span>
                                            </label>
                                            <div class="custom-file text-left">
                                                <input type="file" name="image1" id="image1" class="custom-file-input image-preview-before-upload" data-preview="#viewer1" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                                                <label class="custom-file-label" for="image1">
                                                    {{ translate('choose_file') }}
                                                </label>
                                            </div><br><br>
                                            <div class="text-center">
                                                <img class="upload-img-view" id="viewer1" src="{{ dynamicAsset(path: 'public/assets/back-end/img/400x400/img2.jpg') }}" alt=""> &nbsp; &nbsp;
                                                
                                            </div>
                                        </div>
                                
                                        <div class="col-md-6">
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
                                               
                                                <img class="upload-img-view" id="viewer2" src="{{ dynamicAsset(path: 'public/assets/back-end/img/400x400/img2.jpg') }}" alt="">
                                                <!--<img class="upload-img-view" id="viewer3"  alt="">-->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--<div class="form-group mb-4">
                                    <label for="image3" class="title-color">
                                        Imagen3
                                    </label>
                                    <div class="custom-file text-left">
                                        <input type="file" name="image3" id="image3" class="custom-file-input image-preview-before-upload" data-preview="#viewer3" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                        <label class="custom-file-label" for="image3">
                                        
                                        </label>
                                    </div>
                                </div>-->
                                <input type="hidden" name="codLen" id="codLen" class="form-control" value="es">
                               
                                <br>
                                
                               

                                <div class="d-flex gap-3 justify-content-end">
                                    <button type="reset" id="reset" class="btn btn-secondary px-4">{{ translate('reset') }}</button>
                                    <button type="submit" class="btn btn--primary px-4">{{ translate('submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

       
       
           
            <!-- TABLA -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <table class="table-responsive table ">
                                <caption class="text-center mb-3" style="caption-side: top;">Blogs</caption>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Título</th>
                                        <th>Contenido</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($blogs as $blog)
                                        <tr>
                                            <td id="id" name="id">{{ $blog->id }}</td>
                                            <td>{{ $blog->title }}</td>
                                            <td>{!! \Str::limit(strip_tags($blog->content)) !!}</td>
                                            <td><div class="d-flex justify-content-between">
                                                <a href="{{ route('admin.blogs.editblog', ['id' => $blog->id, 'idedit' => $blog->id]) }}" class="btn btn-primary btn-sm me-1 d-flex align-items-center">{{translate('Edit')}}</a>
                                                <button type="submit" class="btn btn-danger btn-sm w-50 me-1 delete" data-id="{{ $blog->id }}">{{translate('Delete')}}</button>
                                            </div></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
       
        
    </div>
@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/products-management.js') }}"></script>
@endpush

@push('script')
    <script>
        'use strict';
        // Resetear el formulario
        $('#reset').on('click', function() {
            // Limpiar vistas previas de imágenes
            $('#viewer1').attr('src', '{{ dynamicAsset(path: "public/assets/back-end/img/400x400/img2.jpg") }}');
            $('#viewer2').attr('src', '{{ dynamicAsset(path: "public/assets/back-end/img/400x400/img2.jpg") }}');
            
            // Limpiar contenido de Summernote
            $('.summernote').summernote('code', '');
        });
        
          // Ocultar alertas después de 5 segundos
          setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.classList.remove('show');
                alert.classList.add('fade');
            });
        }, 9000);
         // Initialize the label with the default language
        document.addEventListener('DOMContentLoaded', function() {
            const defaultLang = 'es';
            document.getElementById('codigo').innerText = `(${defaultLang.toUpperCase()})`;
            document.getElementById('codigocont').innerText = `(${defaultLang.toUpperCase()})`;

            
        });
        document.querySelectorAll('.lang-link').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                
                // Remove active class from all links
                document.querySelectorAll('.lang-link').forEach(link => link.classList.remove('active'));
                
                // Hide all forms
                document.querySelectorAll('.form-system-language-form').forEach(form => form.classList.add('d-none'));

                // Add active class to the clicked link
                this.classList.add('active');
                
                // Show the form related to the selected language
                let lang = this.getAttribute('data-lang');
                //document.getElementById(`${lang}-form`).classList.remove('d-none');
                
              
                if(lang == 'en'){
                    document.getElementById('codigo').innerText = `(${lang.toUpperCase()})`;
                    document.getElementById('codigocont').innerText = `(${lang.toUpperCase()})`;
                    document.getElementById('codLen').value = 'en';
                }
                else{
                    document.getElementById('codigo').innerText = `(${lang.toUpperCase()})`;
                    document.getElementById('codigocont').innerText = `(${lang.toUpperCase()})`;
                    document.getElementById('codLen').value = 'es';
                }
            });
        });

        $(document).on('click', '.delete', function () {
            //var id = $(this).attr("id");
            var id = $(this).data('id');
            var ruta ="{{ route('admin.blogs.destroyblog', ['iddelete' => ':id']) }}".replace(':id', id);
           
            Swal.fire({
                title: '{{translate("are_you_sure_delete_this")}} ?',
                text: "{{translate('you_will_not_be_able_to_revert_this')}}!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{translate("yes_delete_it")}}!',
                cancelButtonText: '{{ translate("cancel") }}',
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                       
                        //url: "{{ route('admin.blogs.destroyblog', ['iddelete' => "+id+"]) }}/",
                        url: ruta,
                        method: 'DELETE',
                       
                        success: function () {
                            toastr.success('{{translate("successfully_removed")}}');
                            location.reload();
                        }
                    });
                }
            })
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
