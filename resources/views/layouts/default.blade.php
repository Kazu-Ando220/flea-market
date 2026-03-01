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
        {{-- @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

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

        <script>
        function showLoginModal() {
            document.getElementById('loginModal').style.display = 'block';
        }

        function closeLoginModal() {
            document.getElementById('loginModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('loginModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }
        </script>
    @endguest
</body>

</html>