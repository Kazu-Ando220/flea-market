<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// 誰でも閲覧可能
Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');

// ログイン済ならアクセス可能（メール認証前でもOK）
Route::middleware('auth')->group(function () {
    // メール認証通知
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    // 再送アクション
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware(['auth', 'throttle:1,1'])->name('verification.send');
});

// ログイン ＋ メール認証済のみアクセス可能
Route::middleware(['auth', 'verified'])->group(function () {
    // いいね機能
    Route::post('items/{item}/like', [LikeController::class, 'store'])->name('like.store');

    // コメント投稿
    Route::post('items/{item}/comment', [CommentController::class, 'store'])->name('comment.store');

    // 商品出品 + 認可
    Route::get('/sell', [ItemController::class, 'create'])
        ->name('items.create')
        ->can('create', App\Models\Item::class);;

    Route::post('/sell', [ItemController::class, 'store'])
        ->name('items.store')
        ->can('create', App\Models\Item::class);

    // マイページ
    Route::get('/mypage', [ProfileController::class, 'index'])->name('mypage.index');
    // プロフィール設定
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');

    // 購入手続き + 認可
    Route::get('/purchase/{item}', [PurchaseController::class, 'create'])
        ->name('purchase.create')
        ->can('create', [App\Models\Order::class, 'item']);

    Route::post('/purchase/{item}', [PurchaseController::class, 'store'])
        ->name('purchase.store')
        ->can('create', [App\Models\Order::class, 'item']);

    Route::get('/purchase/success/{item}', [PurchaseController::class, 'success'])
        ->name('purchase.success');

    // 配送先関連
    Route::get('/purchase/address/{item}', [AddressController::class, 'edit'])->name('address.edit');
    Route::patch('/purchase/address/{item}', [AddressController::class, 'update'])->name('address.update');
});