@extends('layouts.app')

@section('title')
    検索結果｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">

        {{-- 条件検索 --}}
        <div class="d-none d-lg-block col-lg-3">
            <div class="card shadow">
                <div class="card-header bg-senary">
                    <h5 class="fw-bold my-1">さらに条件で絞る</h5>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <form action="{{ route('products.search') }}" method="get">
                            <div class="form-group row mb-3">
                                <label for="keyword" class="col-form-label col-12">
                                    商品名
                                </label>
                                <div class="col-12">
                                    <input type="text" name="keyword" id="keyword" class="form-control" placeholder="全て" value="{{ old('keyword', request()->keyword) }}">
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="category_id" class="col-form-label col-12">
                                    カテゴリー
                                </label>
                                <div class="col-12">
                                    <select name="category_id" id="category_id" class="form-select">
                                        <option value="">-- 全て --</option>
                                        @foreach(App\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}" @if(request()->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-5">
                                <label for="max_price" class="col-form-label col-12">
                                    最大価格
                                </label>
                                <div class="col-12">
                                    <select name="max_price" id="max_price" class="form-select">
                                        <option value="{{ App\Models\Product::max('price') }}">-- 上限無し --</option>
                                        @for($i = 45000; $i >= 5000; $i-=5000)
                                        <option value="{{ $i }}" @if(request()->max_price == $i) selected @endif>～￥{{ number_format($i) }}円まで</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    検索
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- 商品一覧 --}}
        <div class="col-md-11 col-lg-9">
            <h5 class="title">検索結果｜{{ $products->count() }}件</h5>

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
                                        <span class="text-success">￥300円</span>
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

            <div class="d-flex justify-content-center py-3">
                {{ $products->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
</div>

@endsection