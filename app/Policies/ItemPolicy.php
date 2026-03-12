<?php

namespace App\Policies;

use App\Models\User;

class ItemPolicy
{
    public function create(User $user)
    {
        return true;
    }
}