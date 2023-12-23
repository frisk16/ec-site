@extends('layouts.app')

@section('title')
    TOP｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')

<div id="top-carousel" class="carousel z-n1" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="img-gradation"> 
                <img src="{{ asset('images/top1.jpg') }}" class="d-block w-100" alt="">
            </div>
        </div>
    </div>
</div>

{{-- Topics --}}
<div id="topic-carousel" class="carousel slide carousel-fade mb-5" data-bs-ride="carousel">
    <ul class="carousel-indicators">
        <li data-bs-target="#topic-carousel" data-bs-slide-to="0" aria-current="true" class="active"></li>
        <li data-bs-target="#topic-carousel" data-bs-slide-to="1"></li>
        <li data-bs-target="#topic-carousel" data-bs-slide-to="2"></li>
    </ul>

    <div class="carousel-inner">

        @foreach($topics as $i => $topic)
        <div class="carousel-item @if($i === 0) active @endif">
            @if($topic->linked_at)
                <a href="#">
                    <img src="{{ $storage->url($topic->image) }}" class="block w-100" alt="">
                </a>
            @else
                <img src="{{ $storage->url($topic->image) }}" class="block w-100" alt="">
            @endif
        </div>
        @endforeach

    </div>

    <button type="button" class="carousel-control-prev" data-bs-target="#topic-carousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button type="button" class="carousel-control-next" data-bs-target="#topic-carousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>

</div>

<div class="container mb-5">
    <div class="card card-body">
        <h1 class="title">新着商品</h1>
        <div class="row justify-content-center">

            @foreach($new_top10_products as $product)
            <div class="col-6 col-md-4 mb-3">
                <a href="#">
                    <img src="{{ $storage->url($product->image) }}" class="img-fluid shadow" alt="">
                </a>
            </div>
            @endforeach

        </div>   
    </div>
</div>

<div class="bg-secondary mb-5">
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

<div class="container mb-5">
    <div class="card card-body">
        <h1 class="title">本日のおすすめ</h5>
        <div class="row justify-content-center">

            @foreach($recommend_products as $product)
            <div class="col-6 col-md-4 mb-3">
                <a href="#">
                    <img src="{{ $storage->url($product->image) }}" alt="" class="img-fluid shadow">
                </a>
            </div>
            @endforeach

        </div>
    </div>
</div>

@endsection
