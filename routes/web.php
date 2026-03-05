<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;

use Illuminate\Support\Facades\Route;

// 商品一覧（未認証でも閲覧可能）
Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');

// 認証が必要な機能
Route::middleware('auth')->group(function () {
    // いいね機能
    Route::post('items/{item}/like', [LikeController::class, 'store'])->name('like.store');

    // コメント投稿
    Route::post('items/{item}/comment', [CommentController::class, 'store'])->name('comment.store');

    // 商品関連（出品）
    Route::get('/sell', [ItemController::class, 'create'])
        ->name('items.create')
        ->can('create', App\Models\Item::class);;

    Route::post('/sell', [ItemController::class, 'store'])
        ->name('items.store')
        ->can('create', App\Models\Item::class);

    // マイページ関連
    Route::get('/mypage', [ProfileController::class, 'index'])->name('mypage.index');
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');

    // 購入関連
    Route::get('/purchase/{item}', [PurchaseController::class, 'create'])
        ->name('purchase.create')
        ->can('create', [App\Models\Order::class, 'item']);

    Route::post('/purchase/{item}', [PurchaseController::class, 'store'])
        ->name('purchase.store')
        ->can('create', [App\Models\Order::class, 'item']);

    // 配送先関連
    Route::get('/purchase/address/{item}', [AddressController::class, 'edit'])->name('address.edit');
    Route::patch('/purchase/address/{item}', [AddressController::class, 'update'])->name('address.update');
});