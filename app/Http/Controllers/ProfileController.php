<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Services\ProfileService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(private ProfileService $profileService) {}

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
        $this->profileService->updateProfile(Auth::user(), $request->validated());

        return redirect()
            ->route('items.index')
            ->with('success', 'プロフィールを更新しました。');
    }
}