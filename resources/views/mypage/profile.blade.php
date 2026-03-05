@extends('layouts.default')
@section('content')

<div class="auth-wrapper">
    <h1 class="auth-title">プロフィール設定</h1>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="profile-avatar-section">
            <div class="avatar-wrapper">
                @if(optional($user->profile)->avatar)
                    <img src="{{ asset('storage/' . $user->profile->avatar) }}" class="avatar-image" alt="プロフィール画像">
                @else
                    <img src="{{ asset('images/no_image.png') }}" class="avatar-image" alt="デフォルトプロフィール画像">
                @endif
            </div>

            <div class="form-group">
                <label class="btn-avatar">
                    画像を選択する
                    <input type="file" name="avatar" class="js-avatar-input" hidden>
                </label>
                <span class="js-file-name"></span>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">ユーザー名</label>
            <input type="text" name="name"
                class="form-input @error('name') is-invalid @enderror"
                value="{{ old('name', $user->name) }}">
            @error('name')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">郵便番号</label>
            <input type="text" name="post_code"
                class="form-input @error('post_code') is-invalid @enderror"
                value="{{ old('post_code', $user->profile?->post_code) }}"
                placeholder="123-4567">
            @error('post_code')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">住所</label>
            <input type="text" name="address"
                class="form-input @error('address') is-invalid @enderror"
                value="{{ old('address', $user->profile?->address) }}">
            @error('address')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">建物名</label>
            <input type="text" name="building" class="form-input"
                value="{{ old('building', $user->profile?->building) }}">
        </div>

        <input type="submit" class="btn-submit" value="更新する">
    </form>
</div>

@vite(['resources/js/profile.js'])

@endsection