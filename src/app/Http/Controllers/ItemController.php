<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        // 商品を取得する準備（クエリ作成）
        $query = Item::query();

        // 検索キーワードがあれば名前で絞り込み
        if ($request->filled('keyword')) {
        $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // マイリスト（いいね）ページなら、ログイン中ユーザーがいいねした商品だけ取得
        if ($request->page == 'mylist' && Auth::check()) {
                $query->whereHas('likes', function ($q) {
                $q->where('user_id', Auth::id());
            });
        }

        // 絞り込み結果を取得
        $items = $query->get();

        // compact(`items`)で変数をビューに渡す
        return view('items.index', compact('items'));
    }

    public function show(Item $item)
    {
         // 関連モデルを事前に読み込む（likes, comments, categories）
        $item->load('likes', 'comments', 'categories');

        // カテゴリをランダムに並び替え
        $item->setRelation('categories', $item->categories->shuffle());

        return view('items.show', compact('item'));
    }

    public function toggleLike(Item $item)
    {
        $user = auth()->user();

        if ($item->isLikedBy($user)) {
            // すでにいいねしてる → 解除
            $item->likes()->where('user_id', $user->id)->delete();
        } else {
            // いいね追加
            $item->likes()->create(['user_id' => $user->id]);
        }

        return back(); // 商品詳細にリダイレクト
    }
}
