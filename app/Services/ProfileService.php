<?php

namespace App\Services;

use App\Models\User;

class ProfileService
{
    public function updateProfile(User $user, array $data): void
    {
        $user->update(['name' => $data['name']]);
        $user->syncProfile($data);
    }
}