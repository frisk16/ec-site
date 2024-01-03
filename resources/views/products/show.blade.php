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
                <h5 class="title my-1">{{ $product->name }}</h5>
            </div>
            <div class="card card-body shadow">
                <h5>
                    総合評価：
                    <span class="score-area">
                        <span class="text-warning score"></span>
                        <span class="text-warning total-score" style="width: {{ $product->review_score }}em;">　</span>
                        <span class="score-point">{{ $product->review_score }}</span>
                    </span>
                </h5>

                <hr>

                <h1>
                    <span class="text-danger fs-2 fw-bold">￥{{ number_format($product->price) }}円</span>
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

                @auth
                <form action="{{ route('favorites.toggle') }}" method="post" class="row justify-content-end mt-3">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="form-group col-lg-6">
                        @if(Auth::user()->favorites()->where('product_id', $product->id)->exists())
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fa-solid fa-heart-crack"></i>
                            お気に入り解除
                        </button>
                        @else
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fa-solid fa-heart"></i>
                            お気に入り追加
                        </button>
                        @endif
                    </div>
                </form>
                @else
                <div class="row justify-content-end mt-3">
                    <div class="col-lg-6">
                        <a href="{{ route('login') }}" class="btn btn-outline-danger w-100">
                            <i class="fa-solid fa-heart"></i>
                            お気に入り追加
                        </a>
                    </div>
                </div>
                @endauth

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
                    総合評価：
                    <span class="score-area">
                        <span class="text-warning score"></span>
                        <span class="text-warning total-score" style="width: {{ $product->review_score }}em;">　</span>
                        <span class="score-point">{{ $product->review_score }}</span>
                    </span>
                </h5>
                <hr>
                <div class="row mt-3">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <form action="{{ route('products.review', $product) }}" method="post">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-form-label col-lg-3 text-lg-end">
                                    名前 (任意)
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
                                    <select name="score" id="score" class="form-select text-warning">
                                        @for($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}">{{ str_repeat('★', $i).' '.$i }}</option>
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
                            <div class="form-group row mt-4">
                                <div class="col-lg-10">
                                    @auth
                                        @if(Auth::user()->reviews()->exists())
                                        <span class="btn btn-primary w-100 disabled">既に投稿済みです</span>
                                        @else
                                        <button type="submit" class="btn btn-primary w-100">投稿する</button>
                                        @endif
                                    @else
                                    <span class="btn btn-secondary w-100 disabled">ログイン後に投稿可能</span>
                                    @endauth
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <h5 class="title">投稿一覧</h5>
                        @if($reviews->exists())
                            @foreach($reviews->latest()->get() as $review)
                            <div class="card card-body mb-3">
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