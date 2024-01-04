<header class="fixed-top">
    <nav class="navbar main-navbar @guest navbar-expand @else navbar-expand-none @endguest navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <div class="me-auto">
                <form class="search-form" action="" method="get">
                    <input type="text" name="" id="" class="form-control" placeholder="商品名">
                    <button type="submit" class="btn btn-primary border">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div>

            @guest
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">まずはログイン</a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">初めての方は<a href="{{ route('register') }}">こちら</a></span>
                    </li>
                </ul>
            @else
                <a href="#" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false">
                    <span>
                        <i class="fa-solid fa-user"></i>
                        {{ Auth::user()->email }} 様
                    </span>
                </a>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="{{ route('mypage.index') }}" class="nav-link">
                                マイページへ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('mypage.edit_info') }}" class="nav-link">
                                会員情報編集
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('mypage.edit_password') }}" class="nav-link">
                                パスワード変更
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('verify.index', ['type' => 'customer']) }}" class="nav-link">
                                支払い情報の変更
                            </a>
                        </li>

                        @if(Auth::user()->customers()->exists())
                            @if(!Auth::user()->cancel_flag && Auth::user()->subscriptions()->where('period_end_at', null)->doesntExist())
                                <li class="nav-item">
                                    <a href="{{ route('verify.index', ['type' => 'subscription']) }}" class="nav-link">
                                        有料会員申し込み
                                    </a>
                                </li>
                            @endif
                        @endif

                        <li class="nav-item">
                            <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                ログアウト
                            </a>
                        </li>
                    </ul>
                </div>
            @endguest

        </div>
    </nav>
    <nav class="navbar sub-navbar navbar-expand navbar-light shadow">
        <div class="container">
            <a href="#" class="text-light fw-bold text-decoration-none me-4" data-bs-toggle="modal" data-bs-target="#navbar-modal">
                <i class="fa-solid fa-bars"></i>
                商品を探す
            </a>

            <ul class="navbar-nav me-auto">
                <li class="nav-item me-2">
                    <a href="" class="nav-link p-0">
                        <i class="fa-solid fa-clipboard-list"></i>
                        注文履歴
                    </a>
                </li>
                <li class="nav-item me-2">
                    <a href="{{ route('favorites.index') }}" class="nav-link p-0">
                        <i class="fa-solid fa-heart"></i>
                        お気に入り
                    </a>
                </li>
                <li class="nav-item me-2">
                    <a href="{{ route('carts.index') }}" class="nav-link p-0">
                        <i class="fa-solid fa-cart-shopping"></i>
                        カート
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>

{{-- Navbar Modal --}}
<div class="modal fade" id="navbar-modal" tabindex="-1" data-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-10 mb-3">

                            <div class="row justify-content-between align-items-center">
                                <div class="col-9">
                                    <form action="" method="get" class="search-form d-flex">
                                        <input type="text" name="" id="" class="form-control" placeholder="商品名">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="col-3 text-end">
                                    <a href="#" data-bs-dismiss="modal">
                                        <i class="fa-solid fa-circle-xmark"></i>
                                        閉じる
                                    </a>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-10">
                            <h6 class="title m-2">全カテゴリー</h6>
                            
                            <div class="row justify-content-center align-items-center">
                                <div class="col-lg-6">
                                    <ul class="row">
                                        @foreach(App\Models\MajorCategory::all() as $major_category)
                                        <li class="col-6 mb-3">
                                            <strong>{{ $major_category->name }}</strong>

                                            @foreach($major_category->categories()->get() as $category)
                                            <div class="d-flex flex-wrap ms-2">
                                                <a href="{{ route('categories.show', $category) }}">
                                                    {{ $category->name }} ({{ $category->products()->where('public_flag', true)->count() }})
                                                </a>
                                            </div>
                                            @endforeach
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-lg-6 mt-4">
                                    <h6 class="title mb-2">条件で絞る</h6>

                                    <form action="" method="get">
                                        <div class="form-group row mt-3">
                                            <label for="category_id" class="col-12">
                                                カテゴリー
                                            </label>
                                            <div class="col-12">
                                                <select name="category_id" id="category_id" class="form-select">

                                                    @foreach(App\Models\Category::all() as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row mt-3">
                                            <label for="price" class="col-12">
                                                最大価格
                                            </label>
                                            <div class="col-12">
                                                <select name="price" id="price" class="form-select">
                                                    @for($i = 1000; $i <= 22000; $i += 3000)
                                                        <option value="{{ $i }}">〜￥{{ number_format($i) }}円まで</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row justify-content-end mt-5">
                                            <div class="col-lg-4">
                                                <button type="submit" class="btn btn-primary btn-sm w-100">検索</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Logout Modal --}}
<div class="modal fade" id="logoutModal" tabindex="-1" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">ログアウトしますか？</div>
            <div class="modal-footer">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <span class="btn btn-sm btn-secondary" data-bs-dismiss="modal">閉じる</span>
                    <button type="submit" class="btn btn-sm btn-danger">ログアウト</button>
                </form>
            </div>
        </div>
    </div>
</div>
