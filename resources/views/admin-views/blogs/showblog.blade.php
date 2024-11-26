@extends('layouts.front-end.app')

@section('title')
    {{ $blog->title }}
@endsection

@section('content')
<br><br>
<div class="container">
    <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
        <h3  >
            {{$blog->title}}
        </h3>
    </div>

   

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="image-container text-center">
                <img src="{{ asset('storage/app/' . $blog->image2) }}" alt="{{ $blog->title }}" style="width: 100%; height: 500px; " class="img-fluid ">
            </div>
        </div>
    </div>
    <div class="description mt-3" style="text-align: justify">
        
        {!! $blog->content !!}
    </div>
    <br>
</div>
@endsection

@push('styles')
    <style>
        .header-image {
    width: 100%; /* Ocupa todo el ancho del contenedor */
    max-height: 100px; /* Ajusta la altura máxima según sea necesario */
    object-fit: cover; /* Ajusta cómo se muestra la imagen para cubrir el área */
}
        

        .description {
            padding: 1rem; /* Espaciado dentro del área de descripción */
        }
    </style>
@endpush
