@extends('layouts.app')

@section('title')
    TOP｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')

    <div id="top-carousel" class="carousel slide carousel-fade z-n1" data-bs-ride="carousel">
        {{-- <ul class="carousel-indicators">
            <li data-bs-target="#top-carousel" data-bs-slide-to="0" aria-current="true" class="active"></li>
            <li data-bs-target="#top-carousel" data-bs-slide-to="1"></li>
            <li data-bs-target="#top-carousel" data-bs-slide-to="2"></li>
        </ul> --}}
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="img-gradation"> 
                    <img src="{{ asset('images/top1.jpg') }}" class="d-block w-100" alt="">
                </div>
                <div class="carousel-caption d-md-block">

                </div>
            </div>
            {{-- <div class="carousel-item">
                <div class="img-gradation">
                    <img src="{{ asset('images/top2.jpg') }}" class="d-block w-100" alt="">
                </div>
                <div class="carousel-caption d-md-block">

                </div>
            </div>
            <div class="carousel-item">
                <div class="img-gradation">
                    <img src="{{ asset('images/top3.jpg') }}" class="d-block w-100" alt="">
                </div>
                <div class="carousel-caption d-md-block">

                </div>
            </div> --}}
        </div>
    </div>

<div class="container text-light">
    <h1 class="top-title">新着商品</h1>
    <div class="row justify-content-center">

        @foreach($new_top10_products as $product)
        <div class="col-6 col-md-4 mb-3">
            <div class="card card-body p-2 border">
                <a href="#">
                    <img src="{{ $storage->url($product->image) }}" class="img-fluid" alt="">
                </a>
            </div>
        </div>
        @endforeach

    </div>
</div>

<div class="bg-secondary">
    <div class="container text-light py-3">
        <h1 class="top-title">商品を探す</h1>

        <div class="row justify-content-between">

        @foreach($major_categories as $major)
            <div class="col-4 mb-4">
                <h5>{{ $major->name }}</h5>
                <ul class="ms-2">
                @foreach($major->categories()->get() as $category)
                    <li><a href="#" class="text-light text-decoration-none">{{ $category->name }} ({{ $category->products()->count() }})</a></li>
                @endforeach
                </ul>
            </div>
        @endforeach

        </div>
    </div>
</div>

@endsection
