@extends('layouts.app2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('title', '商品詳細画面')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <img src="{{ $item->image }}" alt="商品画像" class="img-fluid item-image">
        </div>

        <div class="col-md-6">
            <h2>{{ $item->name }}</h2>
            <p>{{ $item->brand }}</p>
            <h4>¥{{ number_format($item->price) }} <small>(税込)</small></h4>

            <div class="d-flex align-items-center mb-3">
                <form method="POST" action="{{ route('items.toggleLike', $item->id) }}">
                    @csrf
                    @php
                        $liked = $item->isLikedBy(Auth::user());
                    @endphp
                    <button type="submit" class="btn-like  {{ $liked ? 'liked' : '' }}">
                        ★ {{ $item->likes->count() }}
                    </button>
                </form>
                <span class="ml-3 btn-like">💬 {{ $item->comments->count() }}</span>
            </div>

            <a href="{{ route('items.purchase', $item->id) }}" class="btn btn-danger btn-block mb-4">購入手続きへ</a>

            <h5>商品説明</h5>
            <p>{{ $item->description }}</p>

            <h5 class="mt-4">商品の情報</h5>
            <p>カテゴリー：
                @foreach ($item->categories as $category)
                    <span class="category-badge">{{ $category->name }}</span>
                @endforeach
            </p>
            <p>商品の状態：{{ $item->condition->name }}</p>

            <h5 class="mt-4">コメント ({{ $item->comments->count() }})</h5>
            @foreach ($item->comments as $comment)
                <div class="d-flex align-items-start mb-3">
                    <div class="comment-icon"></div>
                    <div>
                        <strong>{{ $comment->user->name }}</strong>
                        <div class="comment-box mt-1">
                            {{ $comment->content }}
                        </div>
                    </div>
                </div>
            @endforeach

            @auth
                <h6>商品へのコメント</h6>
                <form method="POST" action="{{ route('comments.store', ['item' => $item->id]) }}">
                    @csrf
                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                    <div class="form-group">
                        <textarea class="form-control" name="content" rows="3" placeholder="コメントを入力してください">{{ old('content') }}</textarea>
                        @error('content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-danger btn-block">コメントを送信する</button>
                </form>
            @else
                <p class="text-muted">コメントを投稿するにはログインが必要です。</p>
            @endauth
        </div>
    </div>
@endsection
