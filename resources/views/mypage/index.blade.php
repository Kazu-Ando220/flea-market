@extends('layouts.default')
@section('content')

    <div class="content-wrapper">
        <div class="profile-header">
            <div class="profile-left">
                <div class="avatar-wrapper">
                    @if ($user->profile?->avatar)
                        <img src="{{ asset('storage/' . $user->profile->avatar) }}" class="avatar-image" alt="プロフィール画像">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" class="avatar-image avatar-default" alt="デフォルトプロフィール画像">
                    @endif
                </div>

                <p class="profile-name">{{ $user->name }}</p>
            </div>

            <div class="profile-right">
                <a href="{{ route('profile.edit') }}" class="btn-edit">
                    プロフィールを編集
                </a>
            </div>
        </div>
    </div>

    <div class="tab-area">
        <div class="tab-inner">
            <a href="{{ route('mypage.index', ['page' => 'sell']) }}"
                class="tab-item {{ $page === 'sell' ? 'is-active' : '' }}">
                出品した商品
            </a>

            <a href="{{ route('mypage.index', ['page' => 'buy']) }}"
                class="tab-item {{ $page === 'buy' ? 'is-active' : '' }}">
                購入した商品
            </a>
        </div>
    </div>

    <div class="content-wrapper">
        <div class="item-grid">
            @forelse($items as $item)
                <div class="item-card">
                    <a href="{{ route('items.show', $item->id) }}">
                        <div class="img-box">
                            @if ($item->item_images->first())
                                <img src="{{ asset('storage/' . $item->item_images->first()?->img_url) }}"
                                    alt="{{ $item->name }}">
                            @endif

                            @if ($item->is_sold)
                                <span class="sold-tag">Sold</span>
                            @endif
                        </div>

                        <p class="item-name">{{ $item->name }}</p>
                    </a>
                </div>
            @empty
                <p class="empty-message">
                    {{ $page === 'buy' ? '購入した商品はありません' : '出品した商品はありません' }}
                </p>
            @endforelse
        </div>
    </div>

@endsection