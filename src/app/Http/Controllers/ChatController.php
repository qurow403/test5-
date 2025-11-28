<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatMessageRequest;
use Illuminate\Http\Request;
use App\Models\Transaction;

use stdClass;

class ChatController extends Controller
{
    public function show($transactionId)
    {
        // $transaction = Transaction::find($transactionId);

        // if (!$transaction) {
        //     abort(404);
        // }

        $transaction = new stdClass();
        $transaction->id = $transactionId;
        $transaction->partner_name = 'a';
        $transaction->partner_avatar = asset('images/default-user.png');
        $transaction->item_name = 'サンプル商品A';
        $transaction->item_image = asset('images/sample-item.png');
        $transaction->item_price = 2500;

        $draft = session("chat_draft_$transactionId");

        $isSeller = true;
        $needsRating = false;

        $items = [
            (object)['id' => 1, 'name' => 'サンプル商品A', 'user_id' => 2],
            (object)['id' => 2, 'name' => 'サンプル商品B', 'user_id' => 3],
            (object)['id' => 3, 'name' => 'サンプル商品C', 'user_id' => 1],
        ];

        return view('transaction.show', compact('transaction', 'isSeller', 'needsRating', 'items', 'draft'));
    }

    public function store(ChatMessageRequest $request, $transactionId)
    {
        $data = $request->validated();

        if($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('chat_images', 'public');
        }

        // データベース保存処理
        // Chat::create([...]);

        return redirect()->back()->withInput();
    }

    public function draft(Request $request, $transactionId)
    {
        session(["chat_draft_$transactionId" => $request->body]);
        return response()->json(['status' => 'ok']);
    }
}
