<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // 主キー
            $table->string('name'); // ユーザー名
            $table->string('email')->unique(); // メールアドレス（一意）
            $table->timestamp('email_verified_at')->nullable(); // メール認証日時（任意）
            $table->string('password');// パスワード（ハッシュ）
            $table->boolean('profile_completed')->default(false);
            $table->rememberToken(); // remember_token（ログイン状態保持用）
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
