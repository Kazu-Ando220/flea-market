<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Services\PurchaseService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function __construct(private PurchaseService $purchaseService) {}

    public function create(Item $item)
    {
        $item->load('item_images');
        $user = Auth::user()->load('profile');

        return view('purchase.index', compact('item', 'user'));
    }

    public function store(PurchaseRequest $request, Item $item)
    {
        if ($item->is_sold) {
            return redirect()
                ->route('items.index')
                ->with('error', 'この商品はすでに購入されています。');
        }

        $data = $request->validated();

        session([
            'purchase_item_id' => $item->id,
            'payment_method' => $data['payment_method']
        ]);

        return redirect(
            $this->purchaseService->createStripeSession($item, $data['payment_method'])
        );
    }

    public function success(Request $request, Item $item)
    {
        if (!$request->session_id) {
            return redirect()->route('items.index');
        }

        $paymentMethod = session('payment_method');

        if (!$paymentMethod || $item->is_sold) {
            return redirect()->route('items.index');
        }

        $this->purchaseService->completePurchase($item, $paymentMethod, Auth::id());

        return redirect()
            ->route('items.index')
            ->with('success', '商品を購入しました。');
    }
}