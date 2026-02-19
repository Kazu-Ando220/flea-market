@extends('layouts.default')
@section('content')

    <div class="tab-area">
        <div class="tab-inner">
            <a href="{{ route('items.index') }}" class="tab-item is-active">おすすめ</a>
            <a href="/?tab=mylist" class="tab-item">マイリスト</a>
        </div>
    </div>

    <div class="content-wrapper">
        <div class="item-grid">
            @foreach($items as $item)
                <div class="item-card">
                    <a href="{{ route('items.show', $item->id) }}">
                        <div class="img-box">
                            <img src="{{ asset('storage/' . $item->item_images->first()->img_url) }}">
                            @if ($item->is_sold)
                                <span class="sold-tag">Sold</span>
                            @endif
                        </div>
                        <p class="item-name">{{ $item->name }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

@endsection