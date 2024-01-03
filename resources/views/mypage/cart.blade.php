@extends('layouts.app')

@section('title')
    ショッピングカート｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <h5 class="title">ショッピングカート｜全{{ $carts->count() }}商品</h5>

            @if(Auth::user()->carts()->exists())
                @foreach($carts as $cart)
                <div class="row justify-content-center mt-3">
                    <div class="col-4 col-lg-3">
                        <a href="{{ route('products.show', $cart->product->id) }}">
                            <img src="{{ $storage->url($cart->product->image) }}" class="img-fluid">
                        </a>
                    </div>
                    <div class="col-8 col-lg-9">

                    </div>
                </div>
                @endforeach
            @else
                <h5 class="py-5 text-center text-secondary">
                    <i class="fa-5x fa-solid fa-basket-shopping"></i>
                    <p class="mt-3">商品が入ってません</p>
                </h5>
            @endif
        </div>
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header bg-senary">
                    <h5 class="my-1">会計</h5>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
</div>

@endsection