<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // 追加

// Itemモデル追加
use App\Models\Item;

// Userモデル追加
use App\Models\User;

// Conditionモデル追加
use App\Models\Condition;


class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $baseUrl = 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/';

        $userIds = User::pluck('id')->toArray();

        // 条件名からIDを取得するマッピング
        $conditionMap = Condition::pluck('id', 'name')->toArray();


        $items = [
            [
                'name' => '腕時計',
                'price' => 15000,
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'condition_id' => $conditionMap['良好'],
                'image' => $baseUrl . 'Armani+Mens+Clock.jpg',
                'is_sold' => false,
                'user_id' => $userIds[array_rand($userIds)],
            ],
            [
                'name' => 'HDD',
                'price' => 5000,
                'description' => '高速で信頼性の高いハードディスク',
                'condition_id' => $conditionMap['目立った傷や汚れなし'],
                'image' => $baseUrl . 'HDD+Hard+Disk.jpg',
                'is_sold' => false,
                'user_id' => $userIds[array_rand($userIds)],
            ],
            [
                'name' => '玉ねぎ3束',
                'price' => 300,
                'description' => '新鮮な玉ねぎ3束のセット',
                'condition_id' => $conditionMap['やや傷や汚れあり'],
                'image' => $baseUrl . 'iLoveIMG+d.jpg',
                'is_sold' => false,
                'user_id' => $userIds[array_rand($userIds)],
            ],
            [
                'name' => '革靴',
                'price' => 4000,
                'description' => 'クラシックなデザインの革靴',
                'condition_id' => $conditionMap['状態が悪い'],
                'image' => $baseUrl . 'Leather+Shoes+Product+Photo.jpg',
                'is_sold' => false,
                'user_id' => $userIds[array_rand($userIds)],
            ],
            [
                'name' => 'ノートPC',
                'price' => 45000,
                'description' => '高性能なノートパソコン',
                'condition_id' => $conditionMap['良好'],
                'image' => $baseUrl . 'Living+Room+Laptop.jpg',
                'is_sold' => false,
                'user_id' => $userIds[array_rand($userIds)],
            ],
            [
                'name' => 'マイク',
                'price' => 8000,
                'description' => '高音質のレコーディング用マイク',
                'condition_id' => $conditionMap['目立った傷や汚れなし'],
                'image' => $baseUrl . 'Music+Mic+4632231.jpg',
                'is_sold' => false,
                'user_id' => $userIds[array_rand($userIds)],
            ],
            [
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'description' => 'おしゃれなショルダーバッグ',
                'condition_id' => $conditionMap['やや傷や汚れあり'],
                'image' => $baseUrl . 'Purse+fashion+pocket.jpg',
                'is_sold' => false,
                'user_id' => $userIds[array_rand($userIds)],
            ],
            [
                'name' => 'タンブラー',
                'price' => 500,
                'description' => '使いやすいタンブラー',
                'condition_id' => $conditionMap['状態が悪い'],
                'image' => $baseUrl . 'Tumbler+souvenir.jpg',
                'is_sold' => false,
                'user_id' => $userIds[array_rand($userIds)],
            ],
            [
                'name' => 'コーヒーミル',
                'price' => 4000,
                'description' => '手動のコーヒーミル',
                'condition_id' => $conditionMap['良好'],
                'image' => $baseUrl . 'Waitress+with+Coffee+Grinder.jpg',
                'is_sold' => false,
                'user_id' => $userIds[array_rand($userIds)],
            ],
            [
                'name' => 'メイクセット',
                'price' => 2500,
                'description' => '便利なメイクアップセット',
                'condition_id' => $conditionMap['目立った傷や汚れなし'],
                'image' => $baseUrl . urlencode('外出メイクアップセット.jpg'),
                'is_sold' => false,
                'user_id' => $userIds[array_rand($userIds)],
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
