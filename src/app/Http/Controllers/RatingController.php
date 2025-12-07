<?php

namespace App\Http\Controllers;

use App\Mail\TransactionCompletedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Transaction;

class RatingController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'rating' => 'required|integer|min:1|max:5',
            'role' => 'required|in:buyer,seller',
        ]);

        $transaction = Transaction::findOrFail($request->transaction_id);

        if ($request->role === 'buyer') {
            $transaction->buyer_rating = $request->rating;
            $transaction->buyer_rated_at = now();
        } else {
            $transaction->seller_rating = $request->rating;
            $transaction->seller_rated_at = now();
        }

        if ($transaction->buyer_rated_at && $transaction->seller_rated_at) {
            $transaction->is_completed = true;
        }

        $transaction->save();

        $recipientEmail = $transaction->item->user->email;
        Mail::to($recipientEmail)->send(new TransactionCompletedMail($transaction));

        return response()->json([
            'success' => true,
            'message' => '評価を送信しました'
        ]);
    }
}https://jmanga.online/manga/1774
