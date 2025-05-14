@extends('layouts.app2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/edit.css') }}">
@endsection

@section('title', 'プロフィール設定画面')

@section('content')
<div class="edit-container">
    <h2 class="edit-title">プロフィール設定</h2>

    <form action="{{ route('edit.update') }}" method="POST" enctype="multipart/form-data" class="edit-form">
        @csrf
        @method('PUT')

        <!-- プロフィール画像 -->
        <div class="edit-image-container">
            <img src="{{ asset('images/default-edit.png') }}" alt="プロフィール画像" class="edit-image">
            <label class="image-upload-button">
                画像を選択する
                <input type="file" name="edit_image" style="display: none;">
            </label>
        </div>

        <!-- ユーザー名 -->
        <div class="form-group">
            <label for="name">ユーザー名</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name ?? '') }}">
        </div>

        <!-- 郵便番号 -->
        <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->postal_code ?? '') }}">
        </div>

        <!-- 住所 -->
        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" id="address" name="address" value="{{ old('address', optional($user->address)->address) }}"
>
        </div>

        <!-- 建物名 -->
        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" id="building" name="building" value="{{ old('building', $user->building ?? '') }}">
        </div>

        <!-- 更新ボタン -->
        <div class="form-group">
            <button type="submit" class="btn-update">更新する</button>
        </div>
    </form>
</div>
@endsection
