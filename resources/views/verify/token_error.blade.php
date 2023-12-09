@extends('layouts.app')

@section('title')
    ページ期限切れ｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <h5 class="title">ページの有効期限が切れています</h5>
                <p>お手数ですが、最初からやり直してください。</p>

            </div>
        </div>
    </div>
@endsection
