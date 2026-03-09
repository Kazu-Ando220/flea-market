<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;

class ItemService
{
    // タブ・キーワードで絞り込んだ商品一覧を取得
    public function getItemsForIndex(string $tab, ?string $keyword)
    {
        return Item::query()
            ->with(['item_images'])
            ->tab($tab)
            ->keyword($keyword)
            ->get();
    }

    public function getFormData(): array
    {
        return [
            'categories' => Category::all(),
            'conditions' => Condition::all(),
        ];
    }

    public function createItem(array $data, int $userId): Item
    {
        return Item::createItem($data, $userId);
    }

    // 商品詳細表示に必要なリレーションを一括ロード。ログインユーザーのいいね状態とともに返す
    public function getItemDetail(Item $item): array
    {
        $item->load(['user', 'category', 'condition', 'item_images', 'comments.user', 'likes']);

        return [
            'item'    => $item,
            'isLiked' => $item->isLikedByCurrentUser(),
        ];
    }
}