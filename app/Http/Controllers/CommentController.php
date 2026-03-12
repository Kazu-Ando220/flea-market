<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Item;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Item $item)
    {
        $item->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return redirect(route('items.show', $item->id) . '#comment-section')
            ->with('success', 'コメントを保存しました。');
    }
}