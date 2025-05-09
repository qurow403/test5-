<?php

namespace Database\Factories;

// Itemモデル追加
use App\Models\Item;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'price' => $this->faker->numberBetween(100, 100000),
            'description' => $this->faker->sentence(),
            'image' => 'sample.jpg', // 仮の画像ファイル名（Seederで上書き可）
            'is_sold' => false,
            'user_id' => 1, // 仮に user_id=1 のユーザーに紐づけておく
        ];
    }
}
