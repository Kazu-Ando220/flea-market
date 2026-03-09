<?php

namespace App\Services;

use App\Models\Item;

use Stripe\Stripe;
use Stripe\Checkout\Session;

class PurchaseService
{
    // Stripe Checkoutセッションを作成し、決済画面のURLを返す。
    // 支払い方法によってkonbini/cardを切り替え

    public function createStripeSession(Item $item, string $paymentMethod): string
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentMethodTypes = $paymentMethod === 'コンビニ支払い'
            ? ['konbini']
            : ['card'];

        $session = Session::create([
            'payment_method_types' => $paymentMethodTypes,
            'mode'                 => 'payment',
            'line_items'           => [[
                'price_data' => [
                    'currency'     => 'jpy',
                    'product_data' => ['name' => $item->name ?? '商品'],
                    'unit_amount'  => (int) $item->price,
                ],
                'quantity' => 1,
            ]],
            'success_url' => route('purchase.success', $item->id) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('purchase.create', $item->id),
        ]);

        return $session->url;
    }

    public function completePurchase(Item $item, string $paymentMethod, int $userId): void
    {
        $item->purchase(['payment_method' => $paymentMethod], $userId);
    }
}