<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend');
        $keyword = $request->query('keyword');
        $items = Item::query()
            ->with(['item_images'])
            ->tab($tab)
            ->keyword($keyword)
            ->get();

        return view('items.index', compact('tab', 'keyword', 'items'));
    }

    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();

        return view('items.create', compact('categories', 'conditions'));
    }

    public function store(ExhibitionRequest $request)
    {
        Item::createItem($request->validated(), Auth::id());

        return redirect()
            ->route('items.index')
            ->with('success', '商品を出品しました。');
    }

    public function show(Item $item)
    {
        $item->load(['user', 'category', 'condition', 'item_images', 'comments.user', 'likes']);
        $isLiked = $item->isLikedByCurrentUser();

        return view('items.show', compact('item', 'isLiked'));
    }
}