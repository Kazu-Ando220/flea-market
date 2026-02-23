<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user()->load('profile');

        return view('mypage.profile', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = $request->user();
        $user->update(['name' => $request->name,]);
        $profile = $user->profile ?? $user->profile()->create([]);

        if ($request->hasFile('avatar')) {
            $profile->avatar = $request->file('avatar')
                ->store('avatars', 'public');
        }

        $profile->update($request->only(['post_code', 'address', 'building']));

        return redirect()->route('items.index')
            ->with('success', 'プロフィールを更新しました。');
    }
}