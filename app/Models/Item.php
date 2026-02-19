<?php

namespace App\Models;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item_images()
    {
        return $this->hasMany(ItemImage::class);
    }
}