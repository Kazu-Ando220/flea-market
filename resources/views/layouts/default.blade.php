<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'COACHTECHフリマ')</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>
    @include('layouts.header')

    <div class="page-body">
        @if (Session::has('success'))
            <div class="success">
                {{ Session::get('success') }}
            </div>
        @endif

        @yield('content')
    </div>

    {{-- ログインモーダル --}}
    @guest
        <div id="loginModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeLoginModal()">&times;</span>
                <h2>ログインが必要です</h2>
                <p>この機能を利用するにはログインしてください</p>
                <a href="{{ route('login') }}" class="btn-modal-login">ログインする</a>
                <a href="{{ route('register') }}" class="btn-modal-register">会員登録する</a>
            </div>
        </div>

        @vite(['resources/js/modal.js'])
    @endguest
</body>

</html>