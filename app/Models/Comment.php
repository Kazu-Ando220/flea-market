<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'item_id', 'content'];

    public function Item() { return $this->belongsTo(Item::class); }
    public function user() { return $this->belongsTo(User::class); }
}