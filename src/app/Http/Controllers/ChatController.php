<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatMessageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\ChatMessage;

use stdClass;

class ChatController extends Controller
{
    public function show($transactionId)
    {
        $loginUserId = Auth::id();

        $transaction = new stdClass();
        $transaction->id = $transactionId;
        $transaction->partner_name = 'サンプル太郎';
        $transaction->partner_avatar = asset('images/default-user.png');
        $transaction->item_name = 'サンプル商品A';
        $transaction->item_image = asset('images/sample-item.png');
        $transaction->item_price = 2500;

        $draft = session()->get("chat_draft_$transactionId", '');

        $isSeller = ($transactionId % 2 === 1);
        $needsRating = true;

        $items = [
            (object)['id' => 1, 'name' => 'サンプル商品A', 'user_id' => 2],
            (object)['id' => 2, 'name' => 'サンプル商品B', 'user_id' => 3],
            (object)['id' => 3, 'name' => 'サンプル商品C', 'user_id' => 1],
        ];

        $messages = [
            (object)[
                'id' => 1,
                'user_id' => $loginUserId,
                'user_name' => Auth::user()->name,
                'body' => '自分のメッセージ例',
            ],
            (object)[
                'id' => 2,
                'user_id' => 2,
                'user_name' => $transaction->partner_name,
                'body' => '相手のメッセージ例',
            ],
        ];


        return view('transaction.show', compact(
            'transaction',
            'isSeller',
            'needsRating',
            'items',
            'draft',
            'messages'
        ));
    }

    public function store(ChatMessageRequest $request, $transactionId)
    {
        $data = $request->validated();

        if($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('chat_images', 'public');
        }

        session()->forget("chat_draft_$transactionId");

        return redirect()->route('chat.show', $transactionId);
    }

    public function draft(Request $request, $transactionId)
    {
        session(["chat_draft_$transactionId" => $request->body]);
        return response()->json(['status' => 'ok']);
    }

    public function update(Request $request, ChatMessage $message)
    {
        $this->authorize('update', $message);

        $request->validate([
            'body' => 'required|string',
        ]);

        $message->update([
            'body' => $request->body
        ]);

        return redirect()->back();
    }

    public function destroy(ChatMessage $message)
    {
        $this->authorize('delete', $message);

        $message->delete();

        return redirect()->back();
    }

    public function saveDraft(Request $request, $transactionId)
    {
        session()->put("chat_draft_$transactionId", $request->body);
        return response()->json(['status' => 'saved']);
    }
}
