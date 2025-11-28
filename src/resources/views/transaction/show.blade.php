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

        <div class="chat-header">
            <img src="{{ asset('images/default-user.png') }}" class="user-icon">
            <span class="header-text">「{{ $transaction->partner_name }}」さんとの取引画面</span>

            @if(!$isSeller)
                <button type="button" class="complete-btn" id="open-rating-modal">
                    取引を完了する
                </button>
            @endif
        </div>

        <div class="item-info">
            <img src="{{ $transaction->item_image }}" class="item-image">

            <div class="item-details">
                <div class="item-name">{{ $transaction->item_name }}</div>
                <div class="item-price">¥{{ number_format($transaction->item_price) }}</div>
            </div>
        </div>

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
                    <div class="message-content">{{ old('body', $draft) ?: '自分が送ったメッセージ' }}</div>
                    <div class="message-actions">
                        <span class="edit">編集</span>
                        <span class="delete">削除</span>
                    </div>
                </div>
                <img src="{{ asset('images/default-user.png') }}" class="message-icon">
            </div>

        </div>

        @if($errors->any())
            <div class="error-messages">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('chat.store', $transaction->id) }}" method="POST" enctype="multipart/form-data" class="chat-input-area">
            @csrf

            <input type="text" name="body" class="chat-input" placeholder="取引メッセージを記入してください" value="{{ old('body', $draft) }}">
            <input type="file" id="chat-image" name="image" style="display:none;">
            <button type="button" class="image-btn">画像を追加</button>
            <button type="submit" class="send-btn">&#9658;</button>
        </form>

    </main>

</div>

@if($isSeller && $needsRating)
    @include('layouts.rating-modal')
@endif

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const imageBtn = document.querySelector('.image-btn');
        const fileInput = document.getElementById('chat-image');

        if (imageBtn && fileInput) {
            imageBtn.addEventListener('click', () => {
                fileInput.click();
            });
        }

        const btn = document.getElementById('open-rating-modal');
        const modal = document.getElementById('rating-modal');
        if (btn && modal) {
            btn.addEventListener('click', () => {
                modal.classList.add('show');
            });
        }
</script>
@endsection
