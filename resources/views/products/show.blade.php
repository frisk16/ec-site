@extends('layouts.app')

@section('title')
    {{ $product->name }} | {{ config('app.name', 'Laravel') }}
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">

        {{-- 商品画像エリア --}}
        <div class="col-lg-4 mb-3">
            <img src="{{ $storage->url($product->image) }}" alt="" class="img-fluid w-100 shadow">
        </div>

        {{-- 詳細情報エリア --}}
        <div class="col-lg-8 mb-3">
            <div class="card card-header bg-senary mb-3 shadow">
                <h3 class="title my-1">{{ $product->name }}</h3>
            </div>
            <div class="card card-body shadow">
                <h5 class="m-0">
                    評価：
                    <span>☆☆☆☆☆</span>
                </h5>

                <hr>

                <h1>
                    <span class="text-danger fs-2 fw-bold">￥{{ $product->price }}円</span>
                    <small>（税込）</small>
                </h1>
                <h4>
                    送料：
                    <span class="text-success fs-4">
                        @if($product->carriage_flag)
                        ￥300円
                        @else
                        無料
                        @endif
                    </span>
                </h4>

                <form action="" method="post" class="row justify-content-end mt-3">
                    @csrf
                    <div class="form-group col-lg-6">
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fa-solid fa-heart"></i>
                            お気に入り追加
                        </button>
                    </div>
                </form>

                <hr>

                <p>
                    {!! nl2br($product->description) !!}
                </p>

                <hr>

                <form action="" method="post">
                    @csrf
                    <div class="form-group row justify-content-end align-items-center mb-3">
                        <label for="qty" class="col-2 text-end">
                            数量
                        </label>
                        <div class="col-2">
                            <input type="number" class="form-control" name="qty" id="qty" value="1" min="1" required>
                        </div>
                    </div>
                    <div class="form-group row justify-content-end">
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fa-solid fa-cart-shopping"></i>
                                カートに追加する
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        {{-- レビューエリア --}}
        <div class="col-12 mb-3">
            <div class="card card-body shadow">
                <h1 class="title fs-4">レビュー</h1>
                <h5>
                    評価
                    <span>☆☆☆☆☆</span>
                </h5>
                <hr>
                <div class="row mt-3">
                    <div class="col-lg-6">
                        <form action="" method="post">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-form-label col-lg-3 text-lg-end">
                                    ニックネーム
                                </label>
                                <div class="col-lg-7"> 
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="名無しさん" value="{{ old('name') }}">
                                
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="score" class="col-form-label col-lg-3 text-lg-end">
                                    評価
                                </label>
                                <div class="col-lg-7"> 
                                    <select name="score" id="score" class="form-select">
                                        @for($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}">{{ str_repeat('★', $i) }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="comment" class="col-form-label col-lg-3 text-lg-end">
                                    コメント
                                </label>
                                <div class="col-lg-7">
                                    <textarea name="comment" id="comment" cols="30" rows="10" class="form-control @error('comment') is-invalid @enderror" placeholder="200文字以内">{{ old('comment') }}</textarea>
                                
                                    @error('comment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mt-5">
                                <div class="col-lg-10">
                                    <button type="submit" class="btn btn-primary w-100">投稿する</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        @if($reviews->exists())
                            @foreach($reviews->get() as $review)
                            
                            @endforeach
                        @else       
                        <h5 class="text-center text-secondary my-5">
                            <i class="fa-5x fa-solid fa-comment-slash"></i>
                            <p class="mt-3">レビューがありません</p>
                        </h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection