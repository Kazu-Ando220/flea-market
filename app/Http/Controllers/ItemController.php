<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionRequest;
use App\Models\Item;
use App\Services\ItemService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __construct(private ItemService $itemService) {}

    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend');
        $keyword = $request->query('keyword');
        $items = $this->itemService->getItemsForIndex($tab, $keyword);

        return view('items.index', compact('tab', 'keyword', 'items'));
    }

    public function create()
    {
        ['categories' => $categories, 'conditions' => $conditions]
            = $this->itemService->getFormData();

        return view('items.create', compact('categories', 'conditions'));
    }

    public function store(ExhibitionRequest $request)
    {
        $this->itemService->createItem($request->validated(), Auth::id());

        return redirect()
            ->route('items.index')
            ->with('success', '商品を出品しました。');
    }

    public function show(Item $item)
    {
        ['item' => $item, 'isLiked' => $isLiked]
            = $this->itemService->getItemDetail($item);

        return view('items.show', compact('item', 'isLiked'));
    }
}