<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// コメント機能
use App\Http\Requests\CommentRequest;

// Itemモデル
use App\Models\Item;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Item $item)
    {
        $item->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return redirect()->route('items.show', $item->id)->with('success', 'コメントを投稿しました。');
    }
}
