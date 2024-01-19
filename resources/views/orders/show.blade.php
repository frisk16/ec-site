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
                全{{ $count }}商品
            </p>
            <hr>

            @foreach($items as $item)
            <div class="card shadow mb-3">

            @if($item->completed_flag)
                @if($item->cancel_flag)
                <div class="card-header bg-secondary text-light">
                    <h5 class="fw-bold my-1 text-tertiary">
                        キャンセル手続きが完了しました
                    </h5>
                </div>
                @else
                <div class="card-header bg-secondary">
                    <h5 class="fw-bold my-1">
                        配達が完了しました
                    </h5>
                </div>
                @endif
            @else
                @if($item->cancel_flag)
                <div class="card-header bg-danger text-lignt">
                    <h5 class="fw-bold my-1">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        現在キャンセル手続き中です
                    </h5>
                </div>
                @else
                <div class="card-header bg-primary text-lignt">
                    <h5 class="fw-bold my-1">
                        現在手続き中です
                    </h5>
                </div>
                @endif
            @endif

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-4">
                            <a href="{{ route('products.show', $item->product) }}">
                                @if($item->product->image)
                                <img src="{{ $storage->url($item->product->image) }}" class="img-fluid">
                                @else
                                <img src="{{ asset('images/dummy.png') }}" alt="" class="img-fluid">
                                @endif
                            </a>
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

                            @if(!$item->completed_flag)
                            <div class="text-end mt-3">
                                @if($item->cancel_flag)
                                <span class="btn btn-danger btn-sm disabled">キャンセル中</span>
                                @else
                                <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#cancel-modal{{ $item->id }}">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                    この注文をキャンセルする
                                </a>
                                @endif
    
                                {{-- Cancel Modal --}}
                                <div class="modal fade" id="cancel-modal{{ $item->id }}" tabindex="-1" data-keyboard="false">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-quinary text-light">
                                                <h5 class="m-0">以下の商品をキャンセルします、よろしいですか？</h5>
                                            </div>
                                            <div class="modal-body text-start">
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
                                            <div class="modal-footer">
                                                <form action="{{ route('orders.cancel', $item) }}" method="post">
                                                    @csrf
                                                    @method('put')
                                                    <span class="btn btn-secondary btn-sm" data-bs-dismiss="modal">閉じる</span>
                                                    <button type="submit" class="btn btn-danger btn-sm">キャンセルする</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            @endforeach
        </div>
    </div>
</div>

@endsection