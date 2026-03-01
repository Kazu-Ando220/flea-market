<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Models\Order;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    use AuthorizesRequests;

    public function create($item_id)
    {
        $item = Item::with('item_images')->findOrFail($item_id);
        $user = Auth::user()->load('profile');

        return view('purchase.index', compact('item', 'user'));
    }

    public function store(PurchaseRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        $this->authorize('create', [Order::class, $item]);
        $item->purchase($request->validated(), Auth::id());

        return redirect()->route('items.index')->with('success', '商品を購入しました。');
    }
}