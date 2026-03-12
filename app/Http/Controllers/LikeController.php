<?php

namespace App\Http\Controllers;

use App\Models\Item;

class LikeController extends Controller
{
    public function store(Item $item)
    {
        $item->toggleLike(auth()->id());

        return redirect()
            ->route('items.show', $item->id);
    }
}