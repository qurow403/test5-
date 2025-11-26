<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;

use App\Http\Requests\ExhibitionRequest;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $soldItems = $user->items;
        $purchasedItems = $user->purchasedItems()->get();

        return view('profile.mypage', compact('soldItems', 'purchasedItems'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $user->update([
            'name' => $request->name,
            'address' => $request->address,
            'profile_completed' => true,
        ]);

        return redirect()->route('profile.mypage')->with('success', 'プロフィールを更新しました');
    }

    public function mypage()
    {
        $user = Auth::user();

        $soldItems = $user->items;
        $purchasedItems = $user->purchasedItems;

        $inProgressItems = $user->transactions()->where('status', 'pending')->get();

        return view('profile.mypage', compact('soldItems', 'purchasedItems'));
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
        $user = auth()->user();
        $isFirst = is_null($user->name);

        return view('profile.edit', compact('user', 'isFirst'));
    }
}
