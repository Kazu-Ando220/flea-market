<header class="header">
    <div class="header-inner">
        <div class="logo">
            <a href="{{ route('items.index') }}">
                <img src="{{ asset('images/logo.png') }}" alt="COACHTECH">
            </a>
        </div>

        @if (!Route::is('login', 'register'))
            <div class="search-box">
                <form method="GET" action="{{ route('items.index') }}">
                    <input type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ request('keyword') }}">
                </form>
            </div>

            <ul class="nav-links">
                @auth
                    <li><a href="#" class="nav-link-item">ログアウト</a></li>
                @else
                    @if (Route::is('items.index', 'items.show'))
                        <li><a href="{{ route('login') }}" class="nav-link-item">ログイン</a></li>
                    @endif
                @endauth
                <li><a href="{{ route('mypage.index') }}" class="nav-link-item">マイページ</a></li>
                <li><a href="{{ route('items.create') }}" class="btn-sell">出品</a></li>
            </ul>
        @endif
    </div>
</header>