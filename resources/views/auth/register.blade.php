@extends('layouts.default')
@section('content')

<div class="auth-wrapper">
    <h1 class="auth-title">会員登録</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label class="form-label">ユーザー名</label>
            <input type="text" name="name" class="form-input" value="{{ old('name') }}">
        </div>

        <div class="form-group">
            <label class="form-label">メールアドレス</label>
            <input type="email" name="email" class="form-input" value="{{ old('email') }}">
        </div>

        <div class="form-group">
            <label class="form-label">パスワード</label>
            <input type="password" name="password" class="form-input">
        </div>

        <div class="form-group">
            <label class="form-label">確認用パスワード</label>
            <input type="password" name="password_confirmation" class="form-input">
        </div>

        <input type="submit" class="btn-submit" value="登録する">
    </form>

    <a href="{{ route('login') }}" class="auth-link">ログインはこちら</a>
</div>

@endsection