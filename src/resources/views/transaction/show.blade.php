@extends('layouts.app')

@section('title', '取引チャット画面')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/chat.css') }}">
<link rel="stylesheet" href="{{ asset('css/chat-modal.css') }}">
@endsection

@section('content')
<div class="chat-page">

    <aside class="sidebar">
        <div class="sidebar-title">その他の取引</div>
        @forelse($items as $item)
            <a href="{{ route('chat.show', $item->id) }}" class="sidebar-item">
                {{ $item->name }}
            </a>
        @empty
            <p class="no-items">取引中の商品はありません</p>
        @endforelse
    </aside>

    <main class="chat-main">

        <!-- 上部：取引相手表示 -->
        <div class="chat-header">
            <img src="{{ asset('images/default-user.png') }}" class="user-icon">
            <span class="header-text">「{{ $transaction->partner_name }}」さんとの取引画面</span>
        </div>

        <!-- 商品情報 -->
        <div class="item-info">
            <img src="{{ $transaction->item_image }}" class="item-image">

            <div class="item-details">
                <div class="item-name">{{ $transaction->item_name }}</div>
                <div class="item-price">¥{{ number_format($transaction->item_price) }}</div>
            </div>
        </div>

        <!-- チャットメッセージ -->
        <div class="messages">

            {{-- 相手のメッセージ --}}
            <div class="message-row left">
                <img src="{{ asset('images/default-user.png') }}" class="message-icon">
                <div class="message-box">
                    <div class="message-user">{{ $transaction->partner_name }}</div>
                    <div class="message-content">相手のメッセージ例です。</div>
                </div>
            </div>

            {{-- 自分のメッセージ --}}
            <div class="message-row right">
                <div class="message-box my-message">
                    <div class="message-user">あなた</div>
                    <div class="message-content">自分が送ったメッセージ</div>
                    <div class="message-actions">
                        <span class="edit">編集</span>
                        <span class="delete">削除</span>
                    </div>
                </div>
                <img src="{{ asset('images/default-user.png') }}" class="message-icon">
            </div>

        </div>

        <!-- 入力欄 -->
        <form class="chat-input-area">
            <input type="text" class="chat-input" placeholder="取引メッセージを記入してください">
            <button type="button" class="image-btn">画像を追加</button>
            <button type="submit" class="send-btn">&#9658;</button>
        </form>

    </main>

</div>

@if($isSeller && $needsRating)
    @include('layouts.rating-modal')
@endif
@endsection
