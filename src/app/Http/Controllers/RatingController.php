<?php

namespace App\Http\Controllers;

use App\Mail\TransactionCompletedMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Transaction;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        return back();
    }

    public function submit(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $transaction = Transaction::find($request->transaction_id);

        if ($request->role === 'buyer') {
            $transaction->buyer_rating = $request->rating;
            $transaction->buyer_rated_at = now();
        } else {
            $transaction->seller_rating = $request->rating;
            $transaction->seller_rated_at = now();
        }

        $transaction->save();

        $sellerEmail = $transaction->item->user->email;
        Mail::to($sellerEmail)->send(new TransactionCompletedMail($transaction));

        return redirect()
            ->route('items.index')
            ->with('success', '評価を送信しました');
    }
}
