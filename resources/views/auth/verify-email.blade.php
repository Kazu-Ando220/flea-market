@extends('layouts.default')
@section('content')

    <div class="auth-wrapper verify-wrapper">
        <div class="verify-content">
            <p class="verify-message">
                登録していただいたメールアドレスに認証メールを送付しました。<br>
                メール認証を完了してください。
            </p>

            @if (session('status'))
                <p class="verify-success">
                    認証メールを再送しました。
                </p>
            @endif

            <div class="verify-action">
                <a href="http://mail.google.com/" class="btn-verify" target="_blank" rel="noopener noreferrer">
                    認証はこちらから
                </a>
            </div>

            <form method="POST" action="{{ route('verification.send') }}" class="resend-form">
                @csrf
                <button type="submit" class="link-resend">
                    認証メールを再送する
                </button>
            </form>
        </div>
    </div>

@endsection