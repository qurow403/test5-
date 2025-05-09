<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// ログイン中にユーザー情報取得できる機能
use Illuminate\Support\Facades\Auth;

// Categoryモデル追加
use App\Models\Category;

// Conditionモデル追加
use App\Models\Condition;

// Itemモデル追加
use App\Models\Item;

// バリデーション実装
use App\Http\Requests\ExhibitionRequest;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user(); // ログイン中のユーザー情報を取得

        // 出品した商品
        $soldItems = $user->items; // もし hasMany(Item::class) をUserモデルに書いているならOK

        // 購入した商品
        $purchasedItems = $user->purchasedItems()->get();

        return view('profile.mypage', compact('soldItems', 'purchasedItems'));
    }

    // プロフィール画面
    public function update(Request $request)
    {
        // バリデーションして保存など
        return redirect()->route('profile.mypage')->with('success', 'プロフィールを更新しました');
    }

    // プロフィール編集画面
    public function mypage()
    {
        $user = Auth::user();

        $soldItems = $user->items; // 出品商品
        $purchasedItems = $user->purchasedItems; // 購入商品（中間テーブル）

        // 必要なデータを取得してマイページを表示（例: 出品した商品一覧など）
        return view('profile.mypage', compact('soldItems', 'purchasedItems'));
    }

    // 商品出品画面表示
    public function sell()
    {
        $categories = Category::all();
        $conditions = Condition::all();

        return view('profile.sell', compact('categories', 'conditions'));
    }

    // 商品出品（保存）処理、バリデーション実装
    public function store(ExhibitionRequest $request)
    {
        // 画像の保存
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('items', 'public');
        } else {
            $image = null;
        }

        // 商品を保存
        $item = Item::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'brand' => $request->brand,
            'description' => $request->description,
            'price' => $request->price,
            'condition_id' => $request->condition_id,
            'image' => $image,
            'is_sold' => false, // 新規出品なので未販売
        ]);

        // 中間テーブルへ複数カテゴリを紐づける
        $item->categories()->attach($request->category_id);

        return redirect()->route('profile.mypage')->with('success', '商品を出品しました');
        }

    // 商品の状態・カテゴリー表示
    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();

        return view('sell', compact('categories', 'conditions'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }
}
