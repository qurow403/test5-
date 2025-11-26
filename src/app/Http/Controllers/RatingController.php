<?php

namespace App\Http\Controllers;

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

        $transaction->rating = $request->rating;
        $transaction->save();

        return redirect()->route('chat.show', $transaction->id)
                        ->with('success', '評価を送信しました');
    }
}
