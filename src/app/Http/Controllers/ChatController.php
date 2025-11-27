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
        $transaction->partner_name = 'a';
        $transaction->partner_avatar = asset('images/default-user.png');
        $transaction->item_name = 'サンプル商品A';
        $transaction->item_image = asset('images/sample-item.png');
        $transaction->item_price = 2500;

        $isSeller = true;
        $needsRating = false;

        $items = [
            (object)['id' => 1, 'name' => 'サンプル商品A', 'user_id' => 2],
            (object)['id' => 2, 'name' => 'サンプル商品B', 'user_id' => 3],
            (object)['id' => 3, 'name' => 'サンプル商品C', 'user_id' => 1],
        ];

        return view('transaction.show', compact('transaction', 'isSeller', 'needsRating', 'items'));
    }
}
