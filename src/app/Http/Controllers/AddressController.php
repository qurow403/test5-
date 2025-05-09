<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// ユーザー認証機能追加
use Illuminate\Support\Facades\Auth;

// AddressRequest(バリデーション)追加
use App\Http\Requests\AddressRequest;

// Itemモデル
use App\Models\Item;

// Addressモデル
use App\Models\Address;

class AddressController extends Controller
{
    // 住所変更画面の表示
    public function edit(Item $item)
    {
        $user = Auth::user();
        $address = Address::where('user_id', $user->id)->first();
        return view('items.address', compact('item', 'address'));
    }

    // 住所の登録 or 更新
    public function update(AddressRequest $request, Item $item)
    {
        $user = Auth::user();

        // バリデーション済みデータを取得し、住所を更新 or 作成
        $address = Address::updateOrCreate(
            ['user_id' => $user->id],
            [
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building' => $request->building,
            ]
        );

        return redirect()->route('items.purchase', ['item' => $item->id])->with('success', '住所が更新されました');
    }
}
