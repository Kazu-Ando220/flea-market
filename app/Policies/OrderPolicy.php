<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\User;

class OrderPolicy
{
    public function create(User $user, Item $item): bool
    {
        if ($item->user_id === $user->id) {
            return false;
        }

        if ($item->is_sold) {
            return false;
        }

        return true;
    }
}