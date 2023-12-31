@extends('layouts.app')

@section('title')
    {{ $category->name }} 一覧 | {{ config('app.name', 'Laravel') }}
@endsection

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">

        {{-- Categories Field --}}
        <div class="d-none d-lg-block col-lg-3 col-xl-2">
            <div class="card shadow">
                <div class="card-header bg-senary">
                    <h5 class="my-1">カテゴリー 一覧</h5>
                </div>
                <div class="card-body">
                    <ul>
                        @foreach($major_categories as $major)
                        <li class="mt-4">
                            <h4>{{ $major->name }}</h4>
                            @foreach($major->categories()->get() as $ctg)
                            <h5 class="ms-2">
                                <a href="{{ route('categories.show', $ctg) }}">{{ $ctg->name }} ({{ $ctg->products()->count() }})</a>
                            </h5>
                            @endforeach
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        {{-- Products Field --}}
        <div class="col-md-11 col-lg-9 col-xl-10">
            
            <div class="card card-header mb-3 bg-senary shadow">
                <h3 class="title my-1">{{ $category->name }}｜<span class="fw-normal">全{{ $category->products()->count() }}品</span></h3>
            </div>

            <div class="row justify-content-start">
                @foreach($products as $product)
                <div class="col-6 col-lg-4 col-xl-3 mb-4">
                    <a href="{{ route('products.show', $product) }}" class="text-decoration-none">
                        <div class="card product-card shadow">
                            <img src="{{ $storage->url($product->image) }}" alt="" class="card-img-top">
                            <div class="card-title">
                                <strong>{{ $product->name }}</strong>
                            </div>
                            <div class="card-body">
                                <h5 class="text-danger">￥{{ number_format($product->price) }}円</h5>
                                <p>
                                    送料：
                                    @if($product->carriage_flag)
                                        <span class="text-success">￥500円</span>
                                    @else
                                        <span class="text-success">無し</span>
                                    @endif
                                </p>
                            </div>
                        </div>   
                    </a>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

@endsection