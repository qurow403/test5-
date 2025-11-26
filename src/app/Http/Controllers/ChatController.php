<?php

namespace App\Http\Controllers;

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
        $transaction->seller_id = 1;
        $transaction->buyer_id = 2;
        $transaction->rating = null;

        $isSeller = true;
        $needsRating = true;

        return view('transaction.show', compact('transaction', 'isSeller', 'needsRating'));
    }
}
