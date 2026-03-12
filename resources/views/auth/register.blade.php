@extends('layouts.default')
@section('content')

<div class="auth-wrapper">
    <h1 class="auth-title">会員登録</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label class="form-label">ユーザー名</label>
            <input type="text" name="name"
                class="form-input @error('name') is-invalid @enderror"
                value="{{ old('name') }}">
            @error('name')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">メールアドレス</label>
            <input type="email" name="email"
                class="form-input @error('email') is-invalid @enderror"
                value="{{ old('email') }}">
            @error('email')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">パスワード</label>
            <input type="password" name="password"
                class="form-input @error('password') is-invalid @enderror">
            @error('password')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">確認用パスワード</label>
            <input type="password" name="password_confirmation"
                class="form-input @error('password_confirmation') is-invalid @enderror">
            @error('password_confirmation')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-submit">登録する</button>
    </form>

    <a href="{{ route('login') }}" class="auth-link">ログインはこちら</a>
</div>

@endsection