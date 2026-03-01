@extends('layouts.default')
@section('content')

    <div class="auth-wrapper">
        <h1 class="auth-title">住所の変更</h1>

        <form method="POST" action="{{ route('address.update', $item->id) }}" class="address-form">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label class="form-label">郵便番号
                    <input type="text" name="post_code" class="form-input @error('post_code') is-invalid @enderror"
                    value="{{ old('post_code', $user->profile?->post_code) }}" placeholder="123-4567">

                    @error('post_code')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </label>
            </div>

            <div class="form-group">
                <label class="form-label">住所
                    <input type="text" name="address" class="form-input @error('address') is-invalid @enderror"
                    value="{{ old('address', $user->profile?->address) }}">

                    @error('address')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </label>
            </div>

            <div class="form-group">
                <label class="form-label">建物名
                    <input type="text" name="building" class="form-input"
                    value="{{ old('building', $user->profile?->building) }}">
                </label>
            </div>

            <input type="submit" class="btn-submit" value="更新する">
        </form>
    </div>

@endsection