@extends('layouts.default')
@section('content')

<div class="tab-area">
    <div class="tab-inner">
        <a href="{{ route('items.index', ['tab' => 'recommend']) }}" class="tab-item {{ $tab === 'recommend' ? 'is-active' : '' }}">
            おすすめ
        </a>
        <a href="{{ route('items.index', ['tab' => 'mylist']) }}" class="tab-item {{ $tab === 'mylist' ? 'is-active' : '' }}">
            マイリスト
        </a>
    </div>
</div>

<div class="content-wrapper">
    @if($items->isEmpty())
        <p class="empty-message">
            @if($keyword)
                「{{ $keyword }}」に一致する商品はありません
            @elseif($tab === 'mylist')
                いいねした商品はありません
            @else
                商品はありません
            @endif
        </p>
    @else
        <div class="item-grid">
            @foreach($items as $item)
                <div class="item-card">
                    <a href="{{ route('items.show', $item->id) }}">
                        <div class="img-box">
                            @if ($item->item_images->count())
                                <img src="{{ asset('storage/' . $item->item_images->first()->img_url) }}" alt="{{ $item->name }}">
                            @endif
                            @if($item->is_sold)
                                <span class="sold-tag">Sold</span>
                            @endif
                        </div>

                        <p class="item-name">{{ $item->name }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection