@extends('layouts.front-end.app')

@section('title')
    {{ $blog->title }}
@endsection

@section('content')
<br><br>
<div class="content container-fluid">
    <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
        <h3 style="text-align: center">
            {{$blog->title}}
        </h3>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6 mb-4">
            <div class="image-container text-center">
                <img src="{{ asset('storage/' . $blog->image1) }}" alt="{{ $blog->title }}" class="img-fluid">
               
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="image-container text-center">
                <img src="{{ asset('storage/' . $blog->image2) }}" alt="{{ $blog->title }}" class="img-fluid">
               
            </div>
        </div>
    </div>
    <div  style="text-align: justify">
        <p>{{ $blog->content }}</p>
    </div>
</div>
@endsection

@push('styles')
    <style>
        .image-container {
            border: 1px solid #ddd; /* Añade un borde alrededor del contenedor */
            border-radius: 8px; /* Bordes redondeados */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra suave */
            overflow: hidden; /* Asegura que la imagen no sobresalga */
        }

        .image-container img {
            width: 100%; /* Asegura que la imagen cubra el ancho del contenedor */
            height: auto; /* Mantiene la relación de aspecto de la imagen */
            max-height: 300px; /* Ajusta la altura máxima de la imagen */
            object-fit: cover; /* Ajusta la imagen para cubrir el contenedor */
        }

        .description {
            padding: 1rem; /* Espaciado dentro del área de descripción */
        }
    </style>
@endpush
