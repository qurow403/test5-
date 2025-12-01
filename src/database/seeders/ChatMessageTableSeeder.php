<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChatMessage;
use App\Models\Transaction;
use App\Models\User;

class ChatMessageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactions = Transaction::all();

        foreach ($transactions as $transaction) {
            ChatMessage::create([
                'transaction_id' => $transaction->id,
                'user_id' => $transaction->buyer_id,
                'body' => "こんにちは！こちらの商品について質問です。",
            ]);

            ChatMessage::create([
                'transaction_id' => $transaction->id,
                'user_id' => $transaction->seller_id,
                'body' => "こんにちは、はい、詳細はお答えできます。",
            ]);
        }
    }
}
