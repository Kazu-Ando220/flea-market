@extends('layouts.default')
@section('content')

<div class="content-wrapper">
    <div class="item-detail">

        {{-- 左側: 商品画像 --}}
        <div class="item-image">
            @if($item->item_images->count())
                <img src="{{ asset('storage/' . $item->item_images->first()->img_url) }}" alt="{{ $item->name }}">
            @endif
        </div>

        {{-- 右側: 商品情報 --}}
        <div class="item-info">
            <h1 class="item-name">{{ $item->name }}</h1>

            @if($item->brand)
                <p class="item-brand">{{ $item->brand }}</p>
            @endif

            <p class="item-price">￥{{ number_format($item->price) }}（税込）</p>

            {{-- いいね・コメント数 --}}
            <div class="item-stats">
                <div class="stat-item">
                    @auth
                        <form method="POST" action="{{ route('like.store', $item->id) }}" class="like-form">
                            @csrf
                            <button type="submit" class="like-button">
                                @if($isLiked)
                                    <img src="{{ asset('images/icon-heart-pink.png') }}" alt="いいね済み">
                                @else
                                    <img src="{{ asset('images/icon-heart-default.png') }}" alt="いいね">
                                @endif
                            </button>
                        </form>
                    @else
                        <img src="{{ asset('images/icon-heart-default.png') }}" alt="いいね" class="guest-icon">
                    @endauth
                    <span>{{ $item->likes->count() }}</span>
                </div>

                <div class="stat-item">
                    <img src="{{ asset('images/icon-comment.png') }}" alt="コメント">
                    <span>{{ $item->comments->count() }}</span>
                </div>
            </div>

            {{-- 購入ボタン --}}
            @auth
                @if($item->is_sold)
                    <button class="btn-purchase" disabled>売り切れ</button>
                @elseif($item->user_id === auth()->id())
                    <button class="btn-purchase" disabled>自分の商品</button>
                @else
                    <a href="{{ route('purchase.create', $item->id) }}" class="btn-purchase">購入手続きへ</a>
                @endif
            @else
                <button class="btn-purchase js-login-trigger">購入手続きへ</button>
            @endauth

            {{-- 商品説明 --}}
            <div class="detail-section">
                <h2>商品説明</h2>
                <p>{{ $item->description }}</p>
            </div>

            {{-- 商品情報 --}}
            <div class="detail-section">
                <h2>商品の情報</h2>
                <div class="info-row">
                    <span class="info-label">カテゴリー</span>
                    <span class="category-tag">{{ $item->category->content }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">商品の状態</span>
                    <span>{{ $item->condition->content }}</span>
                </div>
            </div>

            {{-- コメント一覧 --}}
            <div class="comment-section" id="comment-section">
                <h2>コメント（{{ $item->comments->count() }}）</h2>

                @forelse($item->comments as $comment)
                    <div class="comment-item">
                        <div class="user-info">
                            <div class="user-avatar"></div>
                            <span>{{ $comment->user->name }}</span>
                        </div>
                        <div class="comment-body">
                            {!! nl2br(e($comment->content)) !!}
                        </div>
                    </div>
                @empty
                    <p class="empty-message">コメントはまだありません。</p>
                @endforelse

                {{-- コメント投稿フォーム --}}
                <div class="comment-form">
                    <h3>商品へのコメント</h3>

                    @auth
                        <form method="POST" action="{{ route('comment.store', $item->id) }}">
                            @csrf
                            <textarea name="content"
                                class="@error('content') is-invalid @enderror"
                                rows="5"
                                placeholder="コメントを入力"
                                maxlength="255">{{ old('content') }}</textarea>
                            @error('content')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                            <button type="submit" class="btn-comment">コメントを送信する</button>
                        </form>
                    @else
                        <textarea placeholder="コメントを入力" disabled></textarea>
                        <p class="login-prompt">
                            コメントするには<a href="javascript:void(0)" class="js-login-trigger">ログイン</a>が必要です
                        </p>
                        <button class="btn-comment" disabled>コメントを送信する</button>
                    @endauth
                </div>
            </div>

        </div>
    </div>
</div>

@endsection