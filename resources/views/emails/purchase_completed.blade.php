<p>{{ $user->name }} 様</p>
<p>「{{ $item->name }}」のご購入ありがとうございます。</p>
<p>商品の発送までしばらくお待ちください。</p>
<hr>
<p>合計金額：￥{{ number_format($item->price) }}</p>