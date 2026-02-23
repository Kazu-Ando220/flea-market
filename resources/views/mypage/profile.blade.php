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
                    <img src="{{ asset('storage/' . $user->profile->avatar) }}" class="avatar-image">
                @else
                    <div class="user-avatar"></div>
                @endif
            </div>

            <div class="form-group">
                <label for="avatarInput" class="btn-avatar">
                    画像を選択する
                    <input type="file" name="avatar" id="avatarInput" hidden>
                </label>
                <span id="fileName"></span>
            </div>

        </div>

        <div class="form-group">
            <label class="form-label">ユーザー名</label>
                <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}">
        </div>

        <div class="form-group">
            <label class="form-label">郵便番号</label>
                <input type="text" name="post_code" class="form-input" value="{{ old('post_code', $user->profile?->post_code) }}">
        </div>

        <div class="form-group">
            <label class="form-label">住所</label>
                <input type="text" name="address" class="form-input" value="{{ old('address', $user->profile?->address) }}">
        </div>

        <div class="form-group">
            <label class="form-label">建物名</label>
                <input type="text" name="building" class="form-input" value="{{ old('building', $user->profile?->building) }}">
        </div>

        <input type="submit" class="btn-submit" value="更新する">
    </form>
</div>

{{-- 画像選択時にファイル名表示 --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('avatarInput');

    if (input) {
        input.addEventListener('change', function () {
            const file = input.files[0];
            if (file) {
                document.getElementById('fileName').textContent = file.name;
            }
        });
    }
});
</script>

@endsection