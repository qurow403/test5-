<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\User;
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

        // ユーザーを3人用意（A, B, C）
        $users = User::take(3)->pluck('id')->toArray();

        $userA = User::where('email', 'userA@example.com')->first();
        $userB = User::where('email', 'userB@example.com')->first();
        $userC = User::where('email', 'userC@example.com')->first();

        // Condition 名 → ID のマップ
        $conditionMap = Condition::pluck('id', 'name')->toArray();

        // CO01〜CO05（ユーザーA）
        $itemsA = [
            ['name' => '腕時計', 'price' => 15000,
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'image' => $baseUrl.'Armani+Mens+Clock.jpg',
                'condition' => '良好'
            ],
            ['name' => 'HDD', 'price' => 5000,
                'description' => '高速で信頼性の高いハードディスク',
                'image' => $baseUrl.'HDD+Hard+Disk.jpg',
                'condition' => '目立った傷や汚れなし'
            ],
            ['name' => '玉ねぎ3束', 'price' => 300,
                'description' => '新鮮な玉ねぎ3束のセット',
                'image' => $baseUrl.'iLoveIMG+d.jpg',
                'condition' => 'やや傷や汚れあり'
            ],
            ['name' => '革靴', 'price' => 4000,
                'description' => 'クラシックなデザインの革靴',
                'image' => $baseUrl.'Leather+Shoes+Product+Photo.jpg',
                'condition' => '状態が悪い'
            ],
            ['name' => 'ノートPC', 'price' => 45000,
                'description' => '高性能なノートパソコン',
                'image' => $baseUrl.'Living+Room+Laptop.jpg',
                'condition' => '良好'
            ],
        ];

        // CO06〜CO10（ユーザーB）
        $itemsB = [
            ['name' => 'マイク', 'price' => 8000,
                'description' => '高音質のレコーディング用マイク',
                'image' => $baseUrl.'Music+Mic+4632231.jpg',
                'condition' => '目立った傷や汚れなし'
            ],
            ['name' => 'ショルダーバッグ', 'price' => 3500,
                'description' => 'おしゃれなショルダーバッグ',
                'image' => $baseUrl.'Purse+fashion+pocket.jpg',
                'condition' => 'やや傷や汚れあり'
            ],
            ['name' => 'タンブラー', 'price' => 500,
                'description' => '使いやすいタンブラー',
                'image' => $baseUrl.'Tumbler+souvenir.jpg',
                'condition' => '状態が悪い'
            ],
            ['name' => 'コーヒーミル', 'price' => 4000,
                'description' => '手動のコーヒーミル',
                'image' => $baseUrl.'Waitress+with+Coffee+Grinder.jpg',
                'condition' => '良好'
            ],
            ['name' => 'メイクセット', 'price' => 2500,
                'description' => '便利なメイクアップセット',
                'image' => $baseUrl.urlencode('外出メイクアップセット.jpg'),
                'condition' => '目立った傷や汚れなし'
            ],
        ];

        // 商品生成（ユーザーA）
        foreach ($itemsA as $item) {
            Item::create([
                'name' => $item['name'],
                'price' => $item['price'],
                'description' => $item['description'],
                'image' => $item['image'],
                'user_id' => $userA->id,
                'is_sold' => false,
            ]);
        }

        // 商品生成（ユーザーB）
        foreach ($itemsB as $item) {
            Item::create([
                'name' => $item['name'],
                'price' => $item['price'],
                'description' => $item['description'],
                'image' => $item['image'],
                'user_id' => $userB->id,
                'is_sold' => false,
            ]);
        }
    }
}
