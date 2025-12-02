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
            <span class="header-text">「{{ $partner->name }}」さんとの取引画面</span>

            @if(!$isSeller)
                <button type="button" class="complete-btn" id="open-rating-modal">
                    取引を完了する
                </button>
            @endif
        </div>

        <div class="item-info">
            <img src="{{ $transaction->item->image ?? asset('images/default-item.png') }}" class="item-image">

            <div class="item-details">
                <div class="item-name">{{ $transaction->item->name }}</div>
                <div class="item-price">¥{{ number_format($transaction->item->price) }}</div>
            </div>
        </div>

        <div class="messages">

            @foreach($messages as $message)
                <div class="message-row {{ $message->user_id === Auth::id() ? 'right' : 'left' }}">
                    @if($message->user_id !== Auth::id())
                        <img src="{{ asset('images/default-user.png') }}" class="message-icon">
                    @endif

                    <div class="message-box {{ $message->user_id === Auth::id() ? 'my-message' : '' }}" id="message-box-{{ $message->id }}">
                        <div class="message-user">{{ $message->user->name }}</div>

                        <div class="message-content" id="message-content-{{ $message->id }}">
                            {{ $message->body }}
                        </div>

                            <form action="{{ route('chat.update', $message->id) }}" method="POST" style="display:none;" id="edit-form-{{ $message->id }}">
                                @csrf
                                @method('PATCH')
                                <input type="text" name="body" value="{{ $message->body }}" class="edit-input">
                                <button type="submit">保存</button>
                                <button type="button" onclick="cancelEdit({{ $message->id }})">キャンセル</button>
                            </form>

                            @if($message->user_id === Auth::id())
                                <div class="message-actions">
                                    <span class="edit-btn" onclick="editMessage({{ $message->id }})">編集</span>

                                    <form id="delete-form-{{ $message->id }}" action="{{ route('chat.destroy', $message->id) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <span class="delete-btn" onclick="deleteMessage({{ $message->id }})">削除</span>
                                </div>
                            @endif
                        </div>

                    @if($message->user_id === Auth::id())
                        <img src="{{ asset('images/default-user.png') }}" class="message-icon">
                    @endif
                </div>
            @endforeach

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

        const chatInput = document.querySelector('.chat-input');
        if (!chatInput) return;

        let timer = null;

        chatInput.addEventListener('input', () => {
            clearTimeout(timer);
            timer = setTimeout(() => {
                saveDraft(chatInput.value);
            }, 500);
        });

        function saveDraft(body) {
            fetch("{{ route('chat.draft', $transaction->id) }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ body: body })
            });
        }

        const messagesContainer = document.querySelector('.messages');

        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    });

    window.editMessage = function(id) {
        document.getElementById(`message-content-${id}`).style.display = 'none';
        document.getElementById(`edit-form-${id}`).style.display = 'block';
    }

    window.cancelEdit = function(id) {
        document.getElementById(`edit-form-${id}`).style.display = 'none';
        document.getElementById(`message-content-${id}`).style.display = 'block';
    }

    window.deleteMessage = function(id) {
        if (confirm("このメッセージを削除しますか？")) {
            document.getElementById(`delete-form-${id}`).submit();
        }
    }
</script>
@endsection
