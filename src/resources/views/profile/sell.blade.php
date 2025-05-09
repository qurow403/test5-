@extends('layouts.app2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('title', '商品出品画面')

@section('content')
    <div class="container">
    <h1 class="title">商品出品</h1>

    <form action="{{ route('sell.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- {{-- 商品画像 --}} -->
        <div class="form-group">
            <label for="image">商品画像</label>
            <input type="file" name="image" id="image" class="form-control">
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- {{-- 商品の詳細 --}} -->
        <div class="form-group">
            <h2>商品の詳細</h2>

            <!-- {{-- カテゴリー --}} -->
            <label for="category_id">カテゴリー</label>
            <div class="form-group">
                @foreach ($categories as $category)
                    <div class="form-check">
                    <input type="checkbox" name="category_id[]" value="{{ $category->id }}"
                    {{ in_array($category->id, old('category_id', [])) ? 'checked' : '' }}>
                    <label class="form-check-label">{{ $category->name }}</label>
                    </div>
                @endforeach
            </div>
            @error('category_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- {{-- 商品の状態 --}} -->
        <div class="form-group">
            <label for="condition_id">商品の状態</label>
            <select name="condition_id" id="condition_id" class="form-control">
                <option value="">選択してください</option>
                @foreach ($conditions as $condition)
                    <option value="{{ $condition->id }}" {{ old('condition_id') == $condition->id ? 'selected' : '' }}>
                    {{ $condition->name }}
                    </option>
                @endforeach
            </select>
            @error('condition_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- {{-- 商品名 --}} -->
        <div class="form-group">
            <label for="name">商品名</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- {{-- ブランド名 --}} -->
        <div class="form-group">
            <label for="brand">ブランド名</label>
            <input type="text" name="brand" id="brand" value="{{ old('brand') }}" class="form-control">
            @error('brand')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- {{-- 商品の説明 --}} -->
        <div class="form-group">
            <label for="description">商品の説明</label>
            <textarea name="description" id="description" rows="5" class="form-control">{{ old('description') }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- {{-- 販売価格 --}} -->
        <div class="form-group">
            <label for="price">販売価格</label>
            <div class="price-input">
                <span>¥</span>
                <input type="text" name="price" id="price" value="{{ old('price') }}" class="form-control">
            </div>
            @error('price')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- {{-- 出品ボタン --}} -->
        <div class="form-group">
            <button type="submit" class="submit-button">出品する</button>
        </div>

    </form>
</div>
@endsection