@extends('layouts.app')

@section('title')
    再設定手続き完了｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">

                <h5 class="title">再設定手続きが完了しました</h5>

                <p>パスワードが変更されました、ご確認ください。</p>
            </div>
        </div>
    </div>
@endsection
