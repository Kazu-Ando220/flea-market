<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Item;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Stripe\Stripe;
use Stripe\Checkout\Session;

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
        // 二重購入防止
        if ($item->is_sold) {
            return redirect()
                ->route('items.index')
                ->with('error', 'この商品はすでに購入されています。');
        }

        $data = $request->validated();

        Stripe::setApiKey(config('services.stripe.secret'));

        // 支払い方法分岐
        $paymentMethodTypes = $data['payment_method'] === 'コンビニ支払い'
            ? ['konbini']
            : ['card'];

        $session = Session::create([
            'payment_method_types' => $paymentMethodTypes,
            'mode' => 'payment',

            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name ?? '商品',
                    ],
                    'unit_amount' => (int) $item->price,
                ],
                'quantity' => 1,
            ]],

            'success_url' => route('purchase.success', $item->id) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('purchase.create', $item->id),
        ]);

        session([
            'purchase_item_id' => $item->id,
            'payment_method' => $data['payment_method']
        ]);

        return redirect($session->url);
    }

    public function success(Request $request, Item $item)
    {
        if (!$request->session_id) {
            return redirect()->route('items.index');
        }

        $paymentMethod = session('payment_method');

        if (!$paymentMethod) {
            return redirect()->route('items.index');
        }

        // 二重購入防止
        if ($item->is_sold) {
            return redirect()->route('items.index');
        }

        $item->purchase([
            'payment_method' => $paymentMethod
        ], Auth::id());

        return redirect()
            ->route('items.index')
            ->with('success', '商品を購入しました。');
    }
}