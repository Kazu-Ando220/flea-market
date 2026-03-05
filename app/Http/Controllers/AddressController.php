<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Models\Item;

use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function edit(Item $item)
    {
        $user = Auth::user();

        if (request()->has('payment_method')) {
            session(['payment_method' => request('payment_method')]);
        }

        return view('purchase.address', compact('user', 'item'));
    }

    public function update(AddressRequest $request, Item $item)
    {
        $user = Auth::user();
        $user->updateProfileAddress($request->validated());

        return redirect()
            ->route('purchase.create', $item->id)
            ->with('success', '配送先住所を変更しました。');
    }
}