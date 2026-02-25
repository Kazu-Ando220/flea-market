<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend');
        $keyword = $request->query('keyword');
        $items = Item::query()
            ->tab($tab)
            ->keyword($keyword)
            ->get();

        return view('items.index', compact('tab', 'keyword', 'items'));
    }

    public function create()
    {

    }

    public function store()
    {

    }

    public function show($item_id)
    {
        $item = Item::with([
            'user',
            'category',
            'condition',
            'item_images',
            'comments.user',
            'likes',
        ])->findOrFail($item_id);

        $isLiked = $item->isLikedByCurrentUser();

        return view('items.show',compact('item', 'isLiked'));
    }
}