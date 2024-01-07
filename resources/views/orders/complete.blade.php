@extends('layouts.app')

@section('title')
    注文完了｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h5 class="text-center text-warning">
                <i class="fa-5x fa-solid fa-gifts"></i>
                <p class="mt-3">お買い上げありがとうございます！</p>
                <p>以下の内容で注文が確定しました</p>
            </h5>
        </div>
    </div>
</div>

@endsection