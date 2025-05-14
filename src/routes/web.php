<?php

// メール認証機能
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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

// メール認証機能リクエスト追加
use Illuminate\Http\Request;

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

// ================================
// メール認証ルート
// ================================
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    // プロフィール未設定ならプロフィール編集画面へ、それ以外は商品一覧へ
    if (is_null($request->user()->profile)) {
        return redirect()->route('profile.edit');
    }

    return redirect()->route('items.index');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', '確認メールを再送しました。');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// ================================
// ゲスト用ルート（認証不要）
// ================================

// 会員登録
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store'])->name('register.store');

// ログイン・ログアウト
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginStore'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 商品一覧・詳細（誰でも見れる）
Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/item/{item}', [ItemController::class, 'show'])->name('items.show');

// いいね機能（ログインのみ可）
Route::post('/item/{item}/like', [ItemController::class, 'toggleLike'])->middleware('auth')->name('items.toggleLike');

// 商品購入画面（ログインしていれば閲覧可）
Route::get('/purchase/{item}', [PurchaseController::class, 'show'])->middleware('auth')->name('items.purchase');

// ================================
// 認証ユーザー専用ルート（auth）
// ================================
Route::middleware(['auth'])->group(function () {

    // マイページ・プロフィール
    Route::get('/mypage', [ProfileController::class, 'show'])->name('profile.mypage');
    Route::put('/mypage/profile', [ProfileController::class, 'update'])->name('edit.update');
    Route::get('/mypage/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    // 商品出品
    Route::get('/sell', [ProfileController::class, 'sell'])->name('profile.sell');
    Route::post('/sell', [ProfileController::class, 'store'])->name('sell.store');

    // コメント投稿
    Route::post('/item/{item}/comments', [CommentController::class, 'store'])->name('comments.store');

    // 商品購入完了
    Route::post('/purchase/complete', [PurchaseController::class, 'complete'])->name('items.purchase.complete');

    // 住所変更
    Route::get('/purchase/address/{item}', [AddressController::class, 'edit'])->name('items.address');
    Route::post('/items/address/{item}', [AddressController::class, 'update'])->name('items.address.update');
});
