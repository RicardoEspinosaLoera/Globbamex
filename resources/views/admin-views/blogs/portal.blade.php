@extends('layouts.front-end.app')

@section('title', translate('my_blog')) 

@section('content')
<br><br>

<div class="container ">
    <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
        <h3 class="h1 mb-0 d-flex align-items-center gap-2">
           Blog
        </h3>
    </div>

    <div class="row justify-content-center">
        @foreach($blogs as $blog)
            <div class="col-md-4 mb-4">
                <div class="card">
                   
                    <div class="card-img-wrapper" style="height: 380px; overflow: hidden;justify-content: center;object-fit: contain; overflow: hidden;display: flex; ">
                        <img src="{{ asset('storage/app/' . $blog->image1) }}" class="card-img-top" alt="{{ $blog->title }}" style="height: 380px; object-fit: cover;overflow: hidden;display: flex; ">
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $blog->title }}</h5>
                        
                            <a href="{{ route('showblog', ['route' => $blog->route]) }}" class="btn btn-primary">{{ translate('see_more') }}</a>
                        
                        
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@push('styles')
    <style>
     


        .btn-primary {
            margin-top: 10px; /* Añade un margen superior a los botones para separación */
        }
    </style>
@endpush
