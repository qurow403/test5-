<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 商品名
            $table->integer('price'); // 価格
            $table->text('description')->nullable(); // 説明（null許可）
            $table->boolean('is_sold')->default(false); // 売り切れフラグ
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // 出品者（usersテーブルのid）
            $table->foreignId('condition_id')->constrained('conditions')->onDelete('cascade'); // 商品の状態
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['condition_id']);
        });

        Schema::dropIfExists('items');
    }
}
