@extends('layouts.app2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('title', 'プロフィール画面')

@section('content')
<div class="mypage-container">
    <!-- ユーザー情報エリア -->
    <div class="user-info">
        <div class="user-icon">
            <img src="{{ asset('images/user-default.png') }}" alt="ユーザーアイコン">
        </div>
        <div class="user-name">{{ Auth::user()->name }}</div>
        <a href="{{ route('profile.edit') }}" class="edit-profile-button">プロフィールを編集</a>
    </div>

    <!-- タブ切り替え -->
    <div class="tabs">
        <a href="#" class="tab active" onclick="showTab('sold')">出品した商品</a>
        <a href="#" class="tab" onclick="showTab('purchased')">購入した商品</a>
    </div>

    <!-- 出品した商品 -->
    <div class="item-list" id="sold-items">
        @foreach ($soldItems as $item)
        <div class="item-card">
            <img src="{!! $item->image !!}" alt="商品画像">
            <div class="item-name">{{ $item->name }}</div>
        </div>
        @endforeach
    </div>

    <!-- 購入した商品 -->
    <div class="item-list" id="purchased-items" style="display: none;">
        @foreach ($purchasedItems as $item)
        <div class="item-card">
            <img src="{!! $item->image !!}" alt="商品画像">
            <div class="item-name">{{ $item->name }}</div>
        </div>
        @endforeach
    </div>
</div>
@endsection

<script>
function showTab(tab) {
    document.getElementById('sold-items').style.display = tab === 'sold' ? 'block' : 'none';
    document.getElementById('purchased-items').style.display = tab === 'purchased' ? 'block' : 'none';

    document.querySelectorAll('.tab').forEach(tabEl => tabEl.classList.remove('active'));
    document.querySelector('.tab[href="#"][onclick*="' + tab + '"]').classList.add('active');
}
</script>