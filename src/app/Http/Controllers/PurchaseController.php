<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Itemモデル追加
use App\Models\Item;

// Purchaseモデル追加
use App\Models\Purchase;

// Addressモデル追加
use App\Models\Address;

// PurchaseRequest(購入機能のバリデーション)
use App\Http\Requests\PurchaseRequest;

// storeメソッドで使用
use Illuminate\Support\Facades\Auth;


class PurchaseController extends Controller
{
    // 商品購入画面
    public function show(Item $item)
    {
        $user = auth()->user();

        // ユーザーの住所を取得
        $address = $user->address;

        return view('items.purchase', compact('item', 'address'));
    }

    public function complete(PurchaseRequest $request)
    {
        $item = Item::findOrFail($request->item_id);

        // すでに売れている場合は弾く
        if ($item->is_sold) {
            return redirect()->route('items.index')->with('error', 'この商品はすでに売り切れています。');
        }

        // ログインユーザーの住所を取得
        $user = auth()->user();

        // ログインユーザーの登録住所を取得
        $address = $user->address; // 1対1リレーション想定（hasOne）

        if (!$address) {
            return redirect()->route('items.address', $item->id)->with('error', '住所が登録されていません。');
        }

        // 商品をSOLDに更新
        $item->is_sold = true;
        $item->save();

        // 購入処理
        Purchase::create([
            'user_id' => auth()->id(),
            'item_id' => $item->id,
            'payment_method' => $request->payment_method,
            'postal_code' => $address->postal_code,
            'address' => $request->address,
            'building' => $address->building,
        ]);

        return redirect()->route('items.index')->with('success', '購入が完了しました！');
    }

    public function store(Request $request, Item $item)
    {
        $user = Auth::user();

        // すでに売れていたら弾く
        if ($item->is_sold) {
            return redirect()->route('items.index')->with('error', 'この商品はすでに売り切れています。');
        }

        // ユーザーの住所情報を取得
        $address = Address::where('user_id', $user->id)->first();

        // 住所が未登録ならエラーにする
        if (!$address) {
            return redirect()->route('items.address.edit', ['item' => $item->id])->with('error', '購入するには住所を登録してください');
        }

        // 商品購入の登録処理
        Purchase::create([
            'user_id'    => $user->id,
            'item_id'    => $item->id,
            'address_id' => $address->id,
        ]);

        // 商品の状態更新（例：sold）
        $item->update(['is_sold' => true]);

        return redirect()->route('items.index')->with('success', '商品を購入しました');
    }
}
