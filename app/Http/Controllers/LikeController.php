<?php

namespace App\Http\Controllers;

use App\Models\Item;

class LikeController extends Controller
{
    public function store($item_id)
    {
        $item = Item::findOrFail($item_id);
        $item->toggleLike(auth()->id());

        return redirect()->route('items.show', $item->id);
    }
}