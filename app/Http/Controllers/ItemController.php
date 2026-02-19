<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $items = Item::with('item_images')->get();

        return view ('items.index', compact('items'));
    }

    public function create()
    {

    }

    public function store()
    {

    }

    public function show()
    {

    }
}