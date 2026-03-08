@extends('layouts.default')
@section('content')

<div class="content-wrapper">
    <div class="purchase-container">

        {{-- 左側：入力エリア --}}
        <main class="purchase-main">
            {{-- 商品情報 --}}
            <div class="item-summary">
                <div class="item-image">
                    @if($item->item_images->first())
                        <img src="{{ asset('storage/' . $item->item_images->first()->img_url) }}" alt="{{ $item->name }}">
                    @endif
                </div>
                <div class="item-text">
                    <h1 class="item-name">{{ $item->name }}</h1>
                    <p class="item-price">￥{{ number_format($item->price) }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('purchase.store', $item->id) }}" id="purchase-form">
                @csrf

                {{-- 支払い方法 --}}
                <section class="selection-section">
                    <h2>支払い方法</h2>

                    @php
                        $selectedPayment = old('payment_method', session('payment_method'));
                    @endphp

                    <select name="payment_method" class="purchase-select js-payment-select @error('payment_method') is-invalid @enderror">

                        <option value="" disabled {{ !$selectedPayment ? 'selected' : '' }}>
                            選択してください
                        </option>

                        <option value="コンビニ支払い"
                            {{ $selectedPayment === 'コンビニ支払い' ? 'selected' : '' }}>
                            コンビニ支払い
                        </option>

                        <option value="カード支払い"
                            {{ $selectedPayment === 'カード支払い' ? 'selected' : '' }}>
                            カード支払い
                        </option>

                    </select>

                    @error('payment_method')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </section>

                {{-- 配送先 --}}
                <section class="selection-section">
                    <div class="section-header">
                        <h2>配送先</h2>

                        <a href="{{ route('address.edit', ['item' => $item->id]) }}" class="link-change">
                            変更する
                        </a>
                    </div>

                    <div class="address-display">
                        <p>〒{{ $user->profile?->post_code }}</p>
                        <p>
                            {{ $user->profile?->address }}
                            {{ $user->profile?->building }}
                        </p>
                    </div>
                </section>

            </form>
        </main>

        {{-- 右側：小計 --}}
        <div class="purchase-right">
            <aside class="purchase-sidebar">
                <table class="summary-table">

                    <tr>
                        <th>商品代金</th>
                        <td>￥{{ number_format($item->price) }}</td>
                    </tr>

                    <tr>
                        <th>支払い方法</th>
                        <td class="js-payment-display">
                            {{ $selectedPayment }}
                        </td>
                    </tr>

                </table>
            </aside>

            <button type="submit" form="purchase-form" class="btn-purchase"
                {{ $item->is_sold ? 'disabled' : '' }}
            >
                {{ $item->is_sold ? '売り切れ' : '購入する' }}
            </button>
        </div>

    </div>
</div>

@vite(['resources/js/purchase.js'])

@endsection