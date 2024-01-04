@extends('layouts.app')

@section('title')
    レビュー｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-10">
            <div class="row mb-3">
                <div class="col-lg-3 col-4">
                    <img src="{{ $storage->url($product->image) }}" class="img-fluid shadow">
                </div>
                <div class="col-lg-9 col-8">
                    <div class="card shadow">
                        <div class="card-header bg-senary">
                            <h5 class="my-1">{{ $product->name }}</h5>
                        </div>
                        <div class="card-body">
                            <h1 class="fs-4 mb-0 text-danger fw-bold">￥{{ number_format($product->price) }}円<small>(税込)</small></h1>
                            <strong class="text-success">
                                送料：
                                @if($product->carriage_flag)
                                    ￥300円
                                @else
                                    無料
                                @endif
                            </strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mt-3">
                <div class="card-header bg-quinary">
                    <h5 class="my-1">みんなのレビュー</h5>
                </div>
                <div class="card-body">
                    <h5>
                        総合評価：
                        <span class="score-area">
                            <span class="text-warning score"></span>
                            <span class="text-warning total-score" style="width: {{ $product->review_score }}em;">　</span>
                            <span class="score-point">{{ $product->review_score }}</span>
                        </span>
                    </h5>
                    <hr>
                    
                    <div class="row justify-content-center">
                        @foreach($reviews as $review)
                        <div class="col-md-10 mb-3">
                            <div class="card card-body">
                                <h5 class="title text-primary mb-0">{{ $review->name }}</h5>
                                <p>
                                    評価：
                                    <span class="text-warning score">{{ str_repeat('★', $review->score) }}</span>
                                </p>
                                <p class="my-3 ms-3">
                                    {!! nl2br($review->comment) !!}
                                </p>
                                <p class="text-end">
                                    <i class="fa-regular fa-clock"></i>
                                    投稿時刻：
                                    <span class="text-success fw-bold">
                                        {{ $review->created_at }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection