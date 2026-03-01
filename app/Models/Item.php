<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'condition_id',
        'name',
        'brand',
        'price',
        'description',
        'is_sold'
    ];

    protected $casts = [
        'is_sold' => 'boolean',
    ];

    // リレーション
    public function category() { return $this->belongsTo(Category::class); }
    public function condition() { return $this->belongsTo(Condition::class); }
    public function user() { return $this->belongsTo(User::class); }

    public function order() { return $this->hasOne(Order::class); }

    public function comments() { return $this->hasMany(Comment::class); }
    public function item_images() { return $this->hasMany(ItemImage::class); }
    public function likes() { return $this->hasMany(Like::class); }

    public function likedUsers() { return $this->belongsToMany(User::class, 'likes'); }

    // スコープ
    public function scopeTab($query, $tab)
    {
        if ($tab === 'mylist') {
            if (!auth()->check()) {
                return $query->where('id', 0);
            }

            return $query
                ->whereHas('likes', function ($q) {
                    $q->where('user_id', auth()->id());
                });
        }

        if (auth()->check()) {
            $query->where('user_id', '!=', auth()->id());
        }

        return $query;
    }

    public function scopeKeyword($query, $keyword)
    {
        if ($keyword) {
            $query->where('name', 'like', "%{$keyword}%");
        }

        return $query;
    }

    public function toggleLike($user_id)
    {
        $like = $this->likes()->where('user_id', $user_id)->first();

        if ($like) {
            $like->delete();
        } else {
            $this->likes()->create(['user_id' => $user_id]);
        }
    }

    // 特定ユーザーのいいね判定
    public function isLikedBy($user_id)
    {
        return $this->likes()->where('user_id', $user_id)->exists();
    }

    // ログインユーザーのいいね判定
    public function isLikedByCurrentUser()
    {
        if (!auth()->check()) {
            return false;
        }
        return $this->isLikedBy(auth()->id());
    }

    public function purchase(array $data, int $userId): void
    {
        // 二重購入防止
        if ($this->is_sold) {
            abort(403);
        }

        $user = User::with('profile')->findOrFail($userId);

        // 住所未登録チェック
        if (!$user->profile) {
            abort(403, '配送先が登録されていません。');
        }

        // 注文履歴の作成：購入時点の配送先住所をスナップショットとして保存
        $this->order()->create([
            'user_id'        => $userId,
            'payment_method' => $data['payment_method'],
            'post_code'      => $user->profile->post_code,
            'address'        => $user->profile->address,
            'building'       => $user->profile->building,
        ]);

        $this->update(['is_sold' => true]);
    }
}