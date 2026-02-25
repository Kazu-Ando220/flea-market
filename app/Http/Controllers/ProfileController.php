<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user()->load('profile');
        $page = $request->query('page', 'sell');
        $items = $user->itemsForMyPage($page);

        return view('mypage.index', compact('user', 'page', 'items'));
    }

    public function edit()
    {
        $user = Auth::user()->load('profile');

        return view('mypage.profile', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $user->update(['name' => $request->name]);
        $profile = $user->profile ?? $user->profile()->create();

        if ($request->hasFile('avatar')) {
            $profile->avatar = $request->file('avatar')
                ->store('avatars', 'public');
        }
        $profile->fill($request->only(['post_code', 'address', 'building']))->save();

        return redirect()->route('items.index')->with('success', 'プロフィールを更新しました。');
    }
}