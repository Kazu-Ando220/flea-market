<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new \Illuminate\Auth\Notifications\VerifyEmail);
    }

    public function profile() { return $this->hasOne(Profile::class); }
    public function comments() { return $this->hasMany(Comment::class); }
    public function items() { return $this->hasMany(Item::class); }
    public function likes() { return $this->hasMany(Like::class); }
    public function orders() { return $this->hasMany(Order::class); }
    public function likedItems() { return $this->belongsToMany(Item::class, 'likes'); }

    public function itemsForMypage($page)
    {
        if ($page === 'buy') {
            return $this->orders()->with('item.item_images')->get()->pluck('item');
        }

        return $this->items()->with('item_images')->get();
    }

    public function updateProfileAddress(array $data)
    {
        return $this->profile()->updateOrCreate(
            ['user_id' => $this->id],
            [
                'post_code' => $data['post_code'],
                'address'   => $data['address'],
                'building'  => $data['building'],
            ]
        );
    }

    public function syncProfile(array $data): void
    {
        $profile = $this->profile ?? new \App\Models\Profile(['user_id' => $this->id]);

        if (isset($data['avatar']) && $data['avatar'] instanceof \Illuminate\Http\UploadedFile) {
            $profile->avatar = $data['avatar']->store('avatars', 'public');
        }

        $profile->fill([
            'post_code' => $data['post_code'],
            'address'   => $data['address'],
            'building'  => $data['building'] ?? null,
        ]);

        $profile->save();
    }
}