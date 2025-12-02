# test5

## 概要
このプロジェクトは フリマアプリ作成を目的としたものです。


## 環境構築
・Dockerビルド
1.git clone git@github.com:qurow403/test5-.git
2.docker-compose up -d


・Laravel環境構築
1.docker-compose exec php bash
2.composer install
3.データベースに接続するために.envファイルを作成
  .envファイルは、.env.exampleファイルをコピーして作成
  cp .env.example .env
  作成後、環境変数を設定
4.php artisan key:generate
5.php artisan migrate
6.php artisan db:seed
7.php artisan test


・ダミーデータ（初期ユーザー）について
開発時に利用できるテストユーザーが DatabaseSeeder 経由で自動作成されます。
UserTableSeeder により、以下のユーザーが登録されます。

- User A
  email: userA@example.com
  password: password123

- User B
  email: userB@example.com
  password: password123

- User C（商品を持たないユーザー）
  email: userC@example.com
  password: password123

これらのユーザーは php artisan db:seed 実行時に作成されます。
開発時のログイン確認は上記のテストユーザーで行えます。


・使用技術
PHP 8.4.3
Laravel 8.83.29
MySQL 15.1
MailHog


・ER図
以下は本アプリケーションのエンティティ・リレーション図です。
![ER図](docs/er-diagram.png)


・開発用URL
開発環境:http://localhost/
phpMyAdmin:http://localhost:8080/# test5-
MailHog:http://localhost:8025/


・プロフィール画面のタブ表示（購入商品一覧・出品商品一覧）について
/mypage?tab=buy および /mypage?tab=sell のルートは Laravelのルーティングには定義されていません。
これらの画面表示は、mypage.blade.php 内の JavaScriptによるタブ切り替え処理によって実装されています。
そのため、web.php のルーティング一覧には /mypage?tab=buy や /mypage?tab=sell の記述はありません。
	•	実際のルーティング先： /mypage（ProfileController@mypage に対応）
	•	動的切り替えの方法：JavaScript によりタブ表示が切り替わり、それぞれ「出品商品」「購入商品」が表示されます
