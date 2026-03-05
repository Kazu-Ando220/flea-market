@extends('layouts.default')
@section('content')

<div class="auth-wrapper">
    <h1 class="auth-title">ログイン</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf

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

        <input type="submit" class="btn-submit" value="ログインする">
    </form>

    <a href="{{ route('register') }}" class="auth-link">会員登録はこちら</a>
</div>

@endsection