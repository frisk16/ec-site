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
                    <h5 class="my-1 fw-bold">カテゴリー 一覧</h5>
                </div>
                <div class="card-body">
                    <ul>
                        @foreach($major_categories as $major)
                        <li class="mt-4">
                            <h5 class="m-0 fw-bold">{{ $major->name }}</h5>
                            <ul class="ms-2">
                                @foreach($major->categories()->get() as $ctg)
                                <li>
                                    <a href="{{ route('categories.show', $ctg) }}">{{ $ctg->name }} ({{ $ctg->products()->where('public_flag', true)->count() }})</a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        {{-- Products Field --}}
        <div class="col-md-11 col-lg-9 col-xl-10">
            
            <div class="card card-header mb-3 bg-senary shadow">
                <h4 class="title my-1">{{ $category->name }}｜<span class="fw-normal">全{{ $count }}品</span></h4>
            </div>

            <span class="badge bg-success">並び替え</span>
            <div class="d-flex justify-content-start gap-2 mb-4 mt-1">
                <form action="" method="get">
                    <input type="hidden" name="page" value="1">
                    <select name="sort_price" class="form-select form-select-sm @if(request()->has('sort_price')) is-valid @endif" onChange="this.form.submit();">
                        @if(!request()->has('sort_price'))
                        <option value="">-- 価格 --</option>
                        @endif
                        <option value="asc" @if(request()->sort_price === 'asc') selected @endif>価格が安い順</option>
                        <option value="desc" @if(request()->sort_price === 'desc') selected @endif>価格が高い順</option>
                    </select>
                </form>
                <form action="" method="get">
                    <input type="hidden" name="page" value="1">
                    <select name="sort_update" class="form-select form-select-sm @if(request()->has('sort_update')) is-valid @endif" onChange="this.form.submit();">
                        @if(!request()->has('sort_update'))
                        <option value="">-- 更新日 --</option>
                        @endif
                        <option value="asc" @if(request()->sort_update === 'asc') selected @endif>古い順</option>
                        <option value="desc" @if(request()->sort_update === 'desc') selected @endif>新しい順</option>
                    </select>
                </form>
            </div>

            <div class="row justify-content-start">
                @foreach($products as $product)
                <div class="col-6 col-lg-4 col-xl-3 mb-4">
                    <a href="{{ route('products.show', $product) }}" class="text-decoration-none">
                        <div class="card product-card shadow">

                            @if($product->image)
                            <img src="{{ $storage->url($product->image) }}" alt="" class="card-img-top">
                            @else
                            <img src="{{ asset('images/dummy.png') }}" alt="" class="card-img-top">
                            @endif

                            
                            <div class="card-title">
                                <strong>{{ $product->name }}</strong>
                            </div>
                            <div class="card-body pt-0 pb-2">
                                <span class="score-area mb-3">
                                    <span class="text-warning score"></span>
                                    <span class="text-warning total-score" style="width: {{ $product->review_score }}em;">　</span>
                                    <span class="score-point">{{ $product->review_score }}</span>
                                </span>
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