@extends('layouts.app')

@section('title')
    注文詳細｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h5 class="title">注文コード：{{ $order->order_code }}</h5>
            <p class="fs-5 fw-bold">
                <i class="fa-solid fa-box-open"></i>
                全{{ $items->count() }}商品
            </p>
            <hr>

            @foreach($items as $item)
            <a href="{{ route('products.show', $item->product) }}" class="card-link">
                <div class="card card-body shadow mb-3">
                    <div class="row">
                        <div class="col-lg-3 col-4">
                            <img src="{{ $storage->url($item->product->image) }}" class="img-fluid">
                        </div>
                        <div class="col-lg-9 col-8">
                            <h5 class="title mb-0">{{ $item->product->name }}</h5>
                            <h1 class="fs-3 mb-0 text-danger fw-bold">￥{{ number_format($item->product->price) }}円<small>(税込)</small></h1>
                            <strong class="text-success fs-5">
                                送料：
                                @if($item->product->carriage_flag)
                                    ￥300円
                                @else
                                    無料
                                @endif
                            </strong>
                            <p class="fw-bold">
                                <i class="fa-solid fa-box-open"></i>
                                購入数：{{ $item->total_qty }}
                            </p>
                        </div>
                    </div>
                </div>
            </a>
            <hr>

            @endforeach
        </div>
    </div>
</div>

@endsection