# test5

## 概要
このプロジェクトは フリマアプリ作成を目的としたものです。


## 環境構築
・Dockerビルド
1.git clone git@github.com:qurow403/test5-.git
2.docker-compose up -d


・Laravel環境構築
1.docker-compose exec php bash
3.composer install
4.データベースに接続するために.envファイルを作成
  .envファイルは、.env.exampleファイルをコピーして作成
  cp .env.example .env
  作成後、環境変数を設定
5.php artisan key:generate
6.php artisan migrate
7.php artisan db:seed


・使用技術
PHP 8.4.3
Laravel 8.83.29
MySQL 15.1


・ER図
以下は本アプリケーションのエンティティ・リレーション図です。
![ER図](docs/er-diagram.png)


・開発用URL
開発環境：http://localhost/
phpMyAdmin:http://localhost:8080/# test5-


・プロフィール画面のタブ表示（購入商品一覧・出品商品一覧）について
/mypage?tab=buy および /mypage?tab=sell のルートは Laravelのルーティングには定義されていません。
これらの画面表示は、mypage.blade.php 内の JavaScriptによるタブ切り替え処理によって実装されています。
そのため、web.php のルーティング一覧には /mypage?tab=buy や /mypage?tab=sell の記述はありません。
	•	実際のルーティング先： /mypage（ProfileController@mypage に対応）
	•	動的切り替えの方法：JavaScript によりタブ表示が切り替わり、それぞれ「出品商品」「購入商品」が表示されます
