<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Models\Order;

use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function create(Item $item)
    {
        $item->load('item_images');
        $user = Auth::user()->load('profile');

        return view('purchase.index', compact('item', 'user'));
    }

    public function store(PurchaseRequest $request, Item $item)
    {
        $item->purchase($request->validated(), Auth::id());

        return redirect()
            ->route('items.index')
            ->with('success', '商品を購入しました。');
    }
}