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
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('item.show');

// 認証が必要な機能
Route::middleware('auth')->group(function () {
    // 商品関連（出品）
    Route::get('/sell', [ItemController::class, 'create'])->name('item.create');
    Route::post('/sell', [ItemController::class, 'store'])->name('item.store');

    // マイページ関連
    Route::get('/mypage', [ProfileController::class, 'index'])->name('mypage.index');
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');

    // 購入関連
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'store'])->name('purchase.store');

    // 配送先関連
    Route::get('/purchase/address/{item_id}', [AddressController::class, 'edit'])->name('address.edit');
    Route::patch('/purchase/address/{item_id}', [AddressController::class, 'update'])->name('address.update');

    // コメント・いいね
    Route::post('item/{item_id}/comment', [CommentController::class, 'store'])->name('comment.store');
    Route::post('item/{item_id}/like', [LikeController::class, 'store'])->name('like.store');
});