<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use App\Models\Transaction;


use App\Http\Requests\ExhibitionRequest;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        $user->update([
            'name' => $request->name,
            'address' => $request->address,
            'profile_completed' => true,
        ]);

        $request->validate([
            'name' => 'required|string|max:50',
            'address' => 'nullable|string|max:255',
        ]);

        return redirect()->route('profile.mypage')->with('success', 'プロフィールを更新しました');
    }

    // 元mypageメソッド
    public function show()
    {
        $user = Auth::user();

        $soldItems = $user->items;
        $purchasedItems = $user->purchasedItems()->get();

        $transactions = Transaction::where(function ($q) use ($user) {
            $q->where('buyer_id', $user->id)
                ->orWhere('seller_id', $user->id);
        })
        ->with(['item', 'chatMessages'])
        ->get();

        $inProgressItems = $transactions->map(function ($tx) use ($user) {
            $messages = $tx->chatMessages ?? collect();
            $lastMessage = $messages->sortByDesc('created_at')->first();

            $unreadCount = $messages->where('user_id', '!=', $user->id)
                                    ->where('is_read', false)
                                    ->count();

            return (object)[
                'transaction_id' => $tx->id,
                'name' => $tx->item->name,
                'image' => $tx->item->image,
                'last_message_time' => $lastMessage ? $lastMessage->created_at : $tx->created_at,
                'unread_count' => $unreadCount,
            ];
        })
        ->sortByDesc('last_message_time')
        ->values();

        $unreadTotal = $inProgressItems->sum('unread_count');

        $sellerRatingAvg = Transaction::where('seller_id', $user->id)
            ->whereNotNull('seller_rating')
            ->avg('seller_rating');
        $sellerRatingCount = Transaction::where('seller_id', $user->id)
            ->whereNotNull('seller_rating')
            ->count();
        $sellerRatingAvg = $sellerRatingAvg ? round($sellerRatingAvg) : 0;

        $buyerRatingAvg = Transaction::where('buyer_id', $user->id)
            ->whereNotNull('buyer_rating')
            ->avg('buyer_rating');
        $buyerRatingCount = Transaction::where('buyer_id', $user->id)
            ->whereNotNull('buyer_rating')
            ->count();
        $buyerRatingAvg = $buyerRatingAvg ? round($buyerRatingAvg) : 0;

    return view('profile.mypage', compact(
            'soldItems',
            'purchasedItems',
            'inProgressItems',
            'unreadTotal',
            'sellerRatingAvg',
            'sellerRatingCount',
            'buyerRatingAvg',
            'buyerRatingCount'  // ←ここを追加
        ));
    }

    public function sell()
    {
        $categories = Category::all();
        $conditions = Condition::all();

        return view('profile.sell', compact('categories', 'conditions'));
    }

    public function store(ExhibitionRequest $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('items', 'public');
        } else {
            $image = null;
        }

        $item = Item::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'brand' => $request->brand,
            'description' => $request->description,
            'price' => $request->price,
            'condition_id' => $request->condition_id,
            'image' => $image,
            'is_sold' => false,
        ]);

        $item->categories()->attach($request->category_id);

        return redirect()->route('profile.mypage')->with('success', '商品を出品しました');
        }

    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();

        return view('sell', compact('categories', 'conditions'));
    }

    public function edit()
    {
        $user = Auth::user();
        $isFirst = is_null($user->name);

        return view('profile.edit', compact('user', 'isFirst'));
    }
}
