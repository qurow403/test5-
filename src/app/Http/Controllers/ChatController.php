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
        $userId = Auth::id();

        $transaction = Transaction::with(['item', 'buyer', 'seller', 'chatMessages.user'])
            ->findOrFail($transactionId);

        $isSeller = $transaction->seller_id === $userId;
        $partner = $isSeller ? $transaction->buyer : $transaction->seller;

        $draft = session()->get("chat_draft_$transactionId", '');

        $needsRating = !$transaction->is_completed;

        $items = $userId === $transaction->seller_id
            ? $transaction->seller->items()->where('items.id', '!=', $transaction->item_id)->get()
            : $transaction->buyer->purchasedItems()->where('items.id', '!=', $transaction->item_id)->get();

        $messages = $transaction->chatMessages->sortBy('created_at')->values();

        return view('transaction.show', compact(
            'transaction',
            'partner',
            'isSeller',
            'needsRating',
            'items',
            'draft',
            'messages'
        ));
    }

    public function store(ChatMessageRequest $request, $transactionId)
    {
        $transaction = Transaction::findOrFail($transactionId);

        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['transaction_id'] = $transactionId;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('chat_images', 'public');
        }

        ChatMessage::create($data);

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

}
