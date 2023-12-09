@extends('layouts.app')

@section('title')
    パスワード変更｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">

                <h5 class="title">パスワード変更</h5>

                <div class="card card-body shadow">
                    <form action="{{ route('mypage.update_password') }}" method="post">
                        @csrf
                        @method('put')

                        <div class="row form-group mt-3">
                            <label for="current_password" class="col-md-4 col-form-label text-md-end">
                                現在のパスワード
                            </label>
                            <div class="col-md-6">
                                <input type="password" name="current_password" id="current_password" class="form-control @if(session('error_password')) is-invalid @endif" placeholder="登録中のパスワード" required>

                                @if(session('error_password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ session('error_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="row form-group mt-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">
                                新しいパスワード
                            </label>
                            <div class="col-md-6">
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @endif" placeholder="半角英数字記号8文字以上" required>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group mt-3">
                            <label for="password_confirmation" class="col-md-4 col-form-label text-md-end">
                                新しいパスワード(確認用)
                            </label>
                            <div class="col-md-6">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="確認用に再度入力" required>
                            </div>
                        </div>
                        <div class="row form-group justify-content-center mt-5">
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-primary w-100">更新</button>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
