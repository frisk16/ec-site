@extends('layouts.app')

@section('title')
    注文完了｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h5 class="text-center fw-bold">
                <i class="fa-5x fa-solid fa-gifts"></i>
                <p class="mt-3">お買い上げありがとうございます！</p>
                <p>以下の内容で注文が確定しました</p>
            </h5>
            <div class="card card-body shadow mt-3">
                <div class="mb-3 fw-bold">
                    <h5 class="title mb-0">お客様の注文コード</h5>
                    <p class="fs-5 ms-2 text-primary">{{ $order_code }}</p>
                </div>
                <div class="mb-3 fw-bold">
                    <h5 class="title mb-0">支払い総額</h5>
                    <p class="fs-5 ms-2 text-primary">￥{{ number_format($order->total_price) }}円<small>（送料込み）</small></p>
                </div>
            </div>
            <div class="row justify-content-center mt-3">
                <div class="col-md-5">
                    <a href="{{ route('home') }}" class="btn btn-success btn-sm w-100">TOPへ戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection