<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Item;

class TransactionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userA = User::where('email', 'userA@example.com')->first();
        $userB = User::where('email', 'userB@example.com')->first();

        $itemsA = Item::where('user_id', $userA->id)->get();

        foreach ($itemsA as $item) {
            Transaction::create([
                'item_id' => $item->id,
                'buyer_id' => $userB->id,
                'seller_id' => $userA->id,
                'status' => 'chatting',
            ]);
        }

        $itemsB = Item::where('user_id', $userB->id)->get();

        foreach ($itemsB as $item) {
            Transaction::create([
                'item_id' => $item->id,
                'buyer_id' => $userA->id,
                'seller_id' => $userB->id,
                'status' => 'chatting',
            ]);
        }

        $this->command->info('Transaction データを作成しました。');
    }
}
