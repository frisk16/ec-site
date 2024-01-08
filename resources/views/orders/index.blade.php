@extends('layouts.app')

@section('title')
    注文履歴｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h5 class="title">注文履歴</h5>
            <p class="fs-5 fw-bold mb-3">全{{ $orders->count() }}件</p>

            @foreach($orders as $order)
            <div class="card shadow mb-3">
                <div class="card-header bg-quinary">
                    <h5 class="my-1">
                        <i class="fa-regular fa-clock"></i>
                        購入日時：{{ $order->created_at }}
                    </h5>
                </div>
                <div class="card-body">
                    <h5 class="title">注文コード：{{ $order->order_code }}</h5>
                    <div class="mb-3">
                        <h5 class="title mb-0">
                            <i class="fa-solid fa-sack-dollar"></i>
                            総額
                        </h5>
                        <p class="fs-3 fw-bold text-danger ms-2">￥{{ number_format($order->total_price) }}円<small>（送料込み）</small></p>
                    </div>
                    <div class="mb-3">
                        <h5 class="title mb-0">
                            <i class="fa-solid fa-truck"></i>
                            送料
                        </h5>
                        <p class="fs-5 fw-bold text-success ms-2">￥{{ $order->carriage }}円</p>
                    </div>
                    <div class="mb-3">
                        <h5 class="title mb-0">
                            <i class="fa-solid fa-box-open"></i>
                            購入商品
                        </h5>
                        <p class="fs-5 fw-bold ms-2">全{{ $order->ordered_products()->count() }}商品</p>
                        <ul class="mx-3">
                            @foreach($order->ordered_products()->latest()->get() as $item)
                            <li class="mb-3">
                                <i class="fa-solid fa-bag-shopping"></i>
                                {{ $item->product->name }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="mb-3">
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-success w-100">商品の詳細を表示</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection