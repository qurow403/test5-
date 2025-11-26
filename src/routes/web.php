<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;


use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\RatingController;

use App\Models\Item;
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

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    if (is_null($request->user()->profile)) {
        return redirect()->route('profile.edit');
    }

    return redirect()->route('items.index');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', '確認メールを再送しました。');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store'])->name('register.store');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginStore'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/item/{item}', [ItemController::class, 'show'])->name('items.show');

Route::post('/item/{item}/like', [ItemController::class, 'toggleLike'])->middleware('auth')->name('items.toggleLike');

Route::get('/purchase/{item}', [PurchaseController::class, 'show'])->middleware('auth')->name('items.purchase');

Route::middleware(['auth'])->group(function () {
    Route::get('/mypage', [ProfileController::class, 'show'])->name('profile.mypage');
    Route::put('/mypage/profile', [ProfileController::class, 'update'])->name('edit.update');
    Route::get('/mypage/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::get('/sell', [ProfileController::class, 'sell'])->name('profile.sell');
    Route::post('/sell', [ProfileController::class, 'store'])->name('sell.store');

    Route::post('/item/{item}/comments', [CommentController::class, 'store'])->name('comments.store');

    Route::post('/purchase/complete', [PurchaseController::class, 'complete'])->name('items.purchase.complete');

    Route::get('/purchase/address/{item}', [AddressController::class, 'edit'])->name('items.address');
    Route::post('/items/address/{item}', [AddressController::class, 'update'])->name('items.address.update');

    Route::get('/chat/{transaction}', [ChatController::class, 'show'])
        ->name('chat.show');
    Route::get('/chat/{transaction}', [ChatController::class, 'show'])
        ->name('chat.show');
        Route::post('/rating/submit', [RatingController::class, 'submit'])->name('rating.submit');
});
