<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('buyer_id');
            $table->unsignedBigInteger('seller_id');

            $table->unsignedBigInteger('item_id');

            $table->enum('status', [
                'chatting',
                'completed',
                'rated',
            ])->default('chatting');

            $table->integer('buyer_rating')->nullable();
            $table->integer('seller_rating')->nullable();

            $table->timestamp('buyer_rated_at')->nullable();
            $table->timestamp('seller_rated_at')->nullable();

            $table->boolean('is_completed')->default(false);

            $table->string('shipping_name')->nullable();
            $table->string('shipping_postcode')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('shipping_tel')->nullable();

            $table->timestamps();

            $table->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
