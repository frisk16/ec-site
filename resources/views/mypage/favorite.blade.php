@extends('layouts.app')

@section('title')
    お気に入り一覧｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <h5 class="title">お気に入り一覧</h5>
            <strong>全{{ $favorites->count() }}件</strong>

            <hr>

            @foreach($favorites as $fav)
            <div class="row mb-3">
                <div class="col-lg-3 col-4">
                    <a href="{{ route('products.show', $fav->product) }}">
                        <img src="{{ $storage->url($fav->product->image) }}" class="img-fluid">
                    </a>
                </div>
                <div class="col-lg-9 col-8">
                    <h5 class="title mb-0">{{ $fav->product->name }}</h5>
                    <p class="mb-3">登録日：{{ $fav->created_at }}</p>
                    <h1 class="fs-4 mb-0 text-danger fw-bold">￥{{ number_format($fav->product->price) }}円<small>(税込)</small></h1>
                    <strong class="text-success">
                        送料：
                        @if($fav->product->carriage_flag)
                            ￥300円
                        @else
                            無料
                        @endif
                    </strong>
                </div>
                <div class="col-12">
                    <div class="d-flex justify-content-end">
                        <form action="{{ route('carts.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $fav->product->id }}">
                            <button type="submit" class="btn btn-primary btn-sm me-1">
                                <i class="fa-solid fa-cart-shopping"></i>
                                カートに追加
                            </button>
                        </form>
                        <form action="{{ route('favorites.toggle') }}" method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $fav->product->id }}">
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fa-solid fa-trash"></i>
                                お気に入り削除
                            </button>
                        </form>
                    </div>
                </div> 
            </div>
            <hr>
            @endforeach

            <div class="d-flex justify-content-center py-3">
                {{ $favorites->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

@endsection