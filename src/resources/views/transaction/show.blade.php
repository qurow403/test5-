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
            <a href="{{ route('chat.show', $item->id) }}" class="sidebar-item">{{ $item->name }}</a>
        @empty
            <p class="no-items">取引中の商品はありません</p>
        @endforelse
    </aside>

    <main class="chat-main">

        <div class="chat-header">
            <img src="{{ asset('images/default-user.png') }}" class="user-icon">
            <span class="header-text">「{{ $partner->name }}」さんとの取引画面</span>

            @php
                $userId = Auth::id();
                $isBuyer = ($transaction->buyer_id === $userId);
                $isSeller = ($transaction->seller_id === $userId);
            @endphp

            @if($isBuyer || $isSeller)
            <div class="complete-btn-wrapper">
                <button type="button" class="complete-btn" id="open-rating-modal">
                    取引を完了する
                </button>
            </div>
            @endif

            <div id="rating-modal" class="rating-modal">
                <div class="modal-content">
                    <h2>取引が完了しました。</h2>
                    <p>今回の取引相手はどうでしたか？</p>

                    <div class="stars" data-transaction-id="{{ $transaction->id }}">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star" data-value="{{ $i }}">★</span>
                        @endfor
                    </div>

                    <form action="{{ route('rating.submit') }}" method="POST" class="rating-form">
                        @csrf
                        <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                        <input type="hidden" name="rating" class="rating-value">
                        <button type="submit" class="submit-btn">送信する</button>
                    </form>
                </div>
            </div>

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

                        <form action="{{ route('chat.update', $message->id) }}" method="POST" id="edit-form-{{ $message->id }}" style="display:none;">
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
                                    @csrf @method('DELETE')
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

        @if ($errors->any())
                <div class="error-messages">
                    <ul>
                        @foreach ($errors->all() as $error)
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
            <button type="submit" class="send-btn">
                <img src="{{ asset('images/images.png') }}" class="send-icon" alt="送信">
            </button>
        </form>

    </main>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const imgBtn = document.querySelector('.image-btn');
    const fileInput = document.getElementById('chat-image');
    if(imgBtn && fileInput) imgBtn.addEventListener('click', () => fileInput.click());
    const openBtn = document.getElementById('open-rating-modal');
    const modal = document.getElementById('rating-modal');

    openBtn?.addEventListener('click', () => modal.classList.add('show'));
    modal?.addEventListener('click', (e) => { if(e.target === modal) modal.classList.remove('show'); });

    const form = modal.querySelector('.rating-form');
    const stars = modal.querySelectorAll('.star');
    const ratingInput = form.querySelector('.rating-value');

    stars.forEach((star) => {
        star.addEventListener('click', () => {
            ratingInput.value = star.dataset.value;
            stars.forEach(s => s.classList.remove('selected'));
            for (let i=0;i<ratingInput.value;i++) stars[i].classList.add('selected');
        });
    });

    form.addEventListener('submit', async e => {
        e.preventDefault();
        if(!ratingInput.value) return alert("評価を選択してください");

        try {
            const formData = new FormData(form);
            const res = await fetch(form.action, {
                method: 'POST',
                body: formData
            });

            if (!res.ok) {
                const text = await res.text();
                console.error('Error Response:', text, res.status, res.statusText);
                throw new Error('送信に失敗しました');
            }

            const data = await res.json();
            alert(data.message || '評価を送信しました');

            window.location.href = "{{ route('items.index') }}";

        } catch (err) {
            console.error(err);
            alert(err.message);
        }
    });

    const msgBox = document.querySelector('.messages');
    if(msgBox) msgBox.scrollTop = msgBox.scrollHeight;

    const input = document.querySelector('.chat-input');
    if(input){
        let timer;
        input.addEventListener('input', () => {
            clearTimeout(timer);
            timer = setTimeout(() => {
                fetch("{{ route('chat.draft', $transaction->id) }}",{
                    method:"POST",
                    headers:{
                        "X-CSRF-TOKEN":"{{ csrf_token() }}",
                        "Content-Type":"application/json"
                    },
                    body:JSON.stringify({body: input.value})
                });
            },500);
        });
    }
});

function editMessage(id){
    document.getElementById(`message-content-${id}`).style.display='none';
    document.getElementById(`edit-form-${id}`).style.display='block';
}
function cancelEdit(id){
    document.getElementById(`edit-form-${id}`).style.display='none';
    document.getElementById(`message-content-${id}`).style.display='block';
}
function deleteMessage(id){
    if(confirm("このメッセージを削除しますか？")){
        document.getElementById(`delete-form-${id}`).submit();
    }
}
</script>
@endsection
