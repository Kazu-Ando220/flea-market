<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Models\Item;

use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function edit($item_id)
    {
        $user = Auth::user();
        $item = Item::findOrFail($item_id);

        return view('purchase.address', compact('user', 'item'));
    }

    public function update(AddressRequest $request, $item_id)
    {
        $user = Auth::user();
        $user->updateProfileAddress($request->validated());

        return redirect()
            ->route('purchase.create', $item_id)
            ->with('success', '配送先住所を変更しました。');
    }
}