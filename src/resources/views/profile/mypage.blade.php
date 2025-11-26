@extends('layouts.app2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('title', 'プロフィール画面')

@section('content')
<div class="mypage-container">

    <div class="user-info">
        <div class="user-icon">
            <img src="{{ asset('images/user-default.png') }}" alt="ユーザーアイコン">
        </div>
        <div class="user-name">{{ Auth::user()->name }}</div>
        <a href="{{ route('profile.edit') }}" class="edit-profile-button">プロフィールを編集</a>
    </div>

    <div class="tabs">
        <a href="#" class="tab active" onclick="showTab('sold')">出品した商品</a>
        <a href="#" class="tab" onclick="showTab('purchased')">購入した商品</a>
        <a href="#" class="tab" onclick="showTab('in-progress')">取引中の商品</a>
    </div>

    <div class="item-list" id="sold-items">
        @foreach ($soldItems as $item)
        <div class="item-card">
            <img src="{!! $item->image !!}" alt="商品画像">
            <div class="item-name">{{ $item->name }}</div>
        </div>
        @endforeach
    </div>

    <div class="item-list" id="purchased-items" style="display: none;">
        @foreach ($purchasedItems as $item)
        <div class="item-card">
            <img src="{!! $item->image !!}" alt="商品画像">
            <div class="item-name">{{ $item->name }}</div>
        </div>
        @endforeach
    </div>

    @if(isset($inProgressItems))
        <div class="item-list" id="in-progress-items">
            @foreach ($inProgressItems as $item)
                <div class="item-card">
                    <img src="{!! $item->image !!}" alt="商品画像">
                    <div class="item-name">{{ $item->name }}</div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

<script>
function showTab(tab) {
    document.getElementById('sold-items').style.display = tab === 'sold' ? 'block' : 'none';
    document.getElementById('purchased-items').style.display = tab === 'purchased' ? 'block' : 'none';
    document.getElementById('in-progress-items').style.display = tab === 'in-progress' ? 'block' : 'none';

    document.querySelectorAll('.tab').forEach(tabEl => tabEl.classList.remove('active'));
    document.querySelector('.tab[href="#"][onclick*="' + tab + '"]').classList.add('active');
}
</script>