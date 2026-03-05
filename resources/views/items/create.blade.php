@extends('layouts.default')
@section('content')

<div class="content-wrapper">
    <section class="sell-wrapper">
        <h1 class="auth-title">商品の出品</h1>

        <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- 商品画像 --}}
            <div class="form-group">
                <label class="form-label">商品画像</label>
                <div class="sell-image-area">
                    <label class="sell-image-label">
                        <div id="js-preview-container" class="preview-container">
                            <span class="sell-image-placeholder">画像を選択する</span>
                        </div>

                        <input type="file" name="img_url" accept=".jpg,.jpeg,.png"
                            class="sell-image-input js-image-input">
                    </label>
                </div>
                @error('img_url')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="sell-section">
                <h2 class="sell-section-title">商品の詳細</h2>

                {{-- カテゴリー --}}
                <div class="form-group">
                    <label class="form-label">カテゴリー</label>

                    <div class="js-category-display category-display-area"></div>

                    <div class="category-select-group">
                        <select class="form-input js-parent-category">
                            <option value="">大カテゴリを選択</option>
                            @foreach($categories->whereNull('parent_id') as $parentCategory)
                                <option value="{{ $parentCategory->id }}">{{ $parentCategory->content }}</option>
                            @endforeach
                        </select>

                        <select class="form-input js-child-category is-hidden">
                            <option value="">中カテゴリを選択</option>
                        </select>

                        <select class="form-input js-grand-category is-hidden">
                            <option value="">小カテゴリを選択</option>
                        </select>
                    </div>

                    <div class="js-category-config" data-old-id="{{ old('category_id') }}"></div>
                    <input type="hidden" name="category_id" class="js-final-category" value="{{ old('category_id') }}">

                    @error('category_id')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 商品の状態 --}}
                <div class="form-group">
                    <label class="form-label">商品の状態</label>
                    <select name="condition_id"
                        class="form-input @error('condition_id') is-invalid @enderror">
                        <option value="">選択してください</option>
                        @foreach($conditions as $condition)
                            <option value="{{ $condition->id }}" {{ old('condition_id') == $condition->id ? 'selected' : '' }}>
                                {{ $condition->content }}
                            </option>
                        @endforeach
                    </select>
                    @error('condition_id')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="sell-section">
                <h2 class="sell-section-title">商品名と説明</h2>

                {{-- 商品名 --}}
                <div class="form-group">
                    <label class="form-label">商品名</label>
                    <input type="text" name="name"
                        class="form-input @error('name') is-invalid @enderror"
                        value="{{ old('name') }}">
                    @error('name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ブランド名 --}}
                <div class="form-group">
                    <label class="form-label">ブランド名</label>
                    <input type="text" name="brand" class="form-input" value="{{ old('brand') }}">
                </div>

                {{-- 商品の説明 --}}
                <div class="form-group">
                    <label class="form-label">商品の説明</label>
                    <textarea name="description"
                        class="form-input sell-textarea @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 販売価格 --}}
                <div class="form-group">
                    <label class="form-label">販売価格</label>
                    <input type="number" name="price"
                        class="form-input @error('price') is-invalid @enderror"
                        value="{{ old('price') }}" min="0" placeholder="¥">
                    @error('price')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn-submit">出品する</button>

        </form>
    </section>
</div>

{{-- カテゴリデータをJSに渡す --}}
<script>
    window.categoryData = @json($categories);
</script>
@vite(['resources/js/sell.js'])

@endsection