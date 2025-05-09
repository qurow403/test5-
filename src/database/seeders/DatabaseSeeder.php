<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create(); // ダミーユーザー5人作成

        $this->call([
            CategoryTableSeeder::class, //Categoryシーダーファイル
            ConditionTableSeeder::class, //Conditionシーダーファイル
            ItemsTableSeeder::class, //Itemsシーダーファイル
        ]);
    }
}
