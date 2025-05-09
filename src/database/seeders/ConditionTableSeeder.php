<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Conditionモデル追加
use App\Models\Condition;

class ConditionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $conditions = ['良好', '目立った傷や汚れなし', 'やや傷や汚れあり', '状態が悪い'];
        foreach ($conditions as $name) {
            Condition::create(['name' => $name]);
        }
    }
}
