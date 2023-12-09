<div class="container my-3">
    @if($errors->any() || session('error_password'))
        <div class="alert alert-danger text-center">
            <p>入力内容に誤りがあります</p>
        </div>
    @endif
    @if(session('error_msg'))
        <div class="alert alert-danger text-center">
            <p>{{ session('error_msg') }}</p>
        </div>
    @endif
    @if(session('success_msg'))
        <div class="alert alert-success text-center">
            <p>{{ session('success_msg') }}</p>
        </div>
    @endif
</div>
