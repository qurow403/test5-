<?php

use Illuminate\Support\Facades\Route;

// ログイン・ログアウト機能
use Illuminate\Support\Facades\Auth;

// 登録・ログイン画面
use App\Http\Controllers\AuthController;

// 商品関連画面(一覧・詳細)
use App\Http\Controllers\ItemController;

// 商品購入画面
use App\Http\Controllers\PurchaseController;

// コメント機能
use App\Http\Controllers\CommentController;

// 住所変更画面
use App\Http\Controllers\AddressController;

// マイページ画面
use App\Http\Controllers\ProfileController;

// Itemモデル追加
use App\Models\Item;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'verified'])->group(function () {
    // メール認証済みユーザーだけがアクセスできるルートを書く
});

// 会員登録画面
Route::get('/register', [AuthController::class, 'register'])->name('register');
// 会員登録の入力データ処理
Route::post('/register', [AuthController::class, 'store'])->name('register.store');

// ログイン画面
Route::get('/login', [AuthController::class, 'login'])->name('login');
// ログイン情報の入力データ処理
Route::post('/login', [AuthController::class, 'loginStore'])->name('login.store');
// ログアウト処理
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 商品一覧画面
Route::get('/', [ItemController::class, 'index'])->name('items.index');

// マイページ画面
Route::get('/mypage', [ProfileController::class, 'show'])->name('profile.mypage');
Route::put('/mypage/profile', [ProfileController::class, 'update'])->name('edit.update');

// 商品出品画面
Route::get('/sell', [ProfileController::class, 'sell'])->name('profile.sell');
// 商品出品（保存）処理
Route::post('/sell', [ProfileController::class, 'store'])->name('sell.store');

// 商品詳細画面
Route::get('/item/{item}', [ItemController::class, 'show'])->name('items.show');
// 「商品に対するいいね/解除」をトグルで切り替える
Route::post('/item/{item}/like', [ItemController::class, 'toggleLike'])->name('items.toggleLike');
// コメント機能(ログインユーザーのみコメント機能使用可能)
Route::post('/item/{item}/comments', [CommentController::class, 'store'])->middleware('auth')->name('comments.store');

// 商品購入画面
Route::get('/purchase/{item}', [PurchaseController::class, 'show'])->name('items.purchase');
// 商品購入完了
Route::post('/purchase/complete', [PurchaseController::class, 'complete'])->name('items.purchase.complete');

// 住所変更画面表示
Route::get('/purchase/address/{item}', [AddressController::class, 'edit'])->name('items.address');
// 住所変更の送信・更新処理
Route::post('/items/address/{item}', [AddressController::class, 'update'])->name('items.address.update');