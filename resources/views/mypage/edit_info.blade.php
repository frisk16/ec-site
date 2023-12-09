@extends('layouts.app')

@section('title')
    お客様の情報｜{{ config('app.name', 'Laravel') }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">

                <h5 class="title">お客様の情報</h5>

                <div class="card card-body shadow">
                    <form action="{{ route('mypage.update_info') }}" method="post">
                        @csrf
                        @method('put')

                        <div class="row form-group mt-3">
                            <label for="email" class="col-md-4 text-md-end col-form-label">
                                Eメールアドレス
                            </label>
                            <div class="col-md-6">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email', $user->email) }}">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group mt-3">
                            <label for="last_name" class="col-md-4 text-md-end col-form-label">
                                氏名
                            </label>
                            <div class="col-md-6 d-flex">
                                <div>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}" placeholder="名字">

                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div>
                                    <input type="text" class="ms-2 form-control @error('first_name') is-invalid @enderror" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}" placeholder="名前">

                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row form-group mt-3">
                            <label for="age" class="col-md-4 text-md-end col-form-label">
                                年齢
                            </label>
                            <div class="col-md-6">
                                <select name="age" id="age" class="form-select @error('age') is-invalid @enderror">
                                    <option value="">-- 年齢を選択 --</option>
                                    @for($i = 12; $i < 111; $i++)
                                        <option value="{{ $i }}" @if($user->age === $i) selected @endif>{{ $i }}歳</option>
                                    @endfor
                                </select>

                                @error('age')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group mt-3">
                            <label for="postal_code" class="col-md-4 text-md-end col-form-label">
                                郵便番号
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('postal_code') is-invalid @enderror" name="postal_code" id="postal_code" value="{{ old('postal_code', $user->postal_code) }}" pattern="\d*" placeholder="半角数字(ハイフン無し)">

                                @error('postal_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group mt-3">
                            <label for="area" class="col-md-4 text-md-end col-form-label">
                                都道府県
                            </label>
                            <div class="col-md-6">
                                <select name="area" id="area" class="form-select @error('area') is-invalid @enderror">
                                    <option value="">-- 都道府県を選択 --</option>
                                    @foreach($areas as $area)
                                        <option value="{{ $area }}" @if($user->area === $area) selected @endif>{{ $area }}</option>
                                    @endforeach
                                </select>

                                @error('area')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group mt-3">
                            <label for="address" class="col-md-4 text-md-end col-form-label">
                                住所
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address" value="{{ old('address', $user->address) }}" placeholder="〇〇市 ✕✕区 00-00-00">

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group mt-3">
                            <label for="phone_number" class="col-md-4 text-md-end col-form-label">
                                電話番号
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" id="phone_number" value="{{ old('phone_number', $user->phone_number) }}" pattern="\d*" placeholder="半角数字(ハイフン無し)">

                                @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row justify-content-center form-group mt-5">
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
