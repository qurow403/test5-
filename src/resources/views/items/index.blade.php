@extends('layouts.app2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('title', '商品一覧画面')

@section('content')
    <div class="tabs">
        <a href="{{ route('items.index') }}" class="{{ request()->page != 'mylist' ? 'active' : '' }}">
            おすすめ
        </a>
        <a href="{{ route('items.index', ['page' => 'mylist']) }}" class="{{ request()->page == 'mylist' ? 'active' : '' }}">
            マイリスト
        </a>
    </div>

    <div class="item-list">
    @if (request()->page == 'mylist' && !Auth::check())
        {{-- 何も表示しない（またはメッセージなど） --}}
    @else
        @foreach ($items as $item)
            @if (Auth::check() && $item->user_id == Auth::id())
                @continue
            @endif
            <div class="item">
                <a href="{{ route('items.show', $item->id) }}">
                    @if ($item->is_sold)
                        <span class="sold-label">sold</span>
                    @endif
                    <img src="{!! $item->image !!}" alt="商品画像">
                    <p class="item-name">{{ $item->name }}</p>
                </a>
            </div>
        @endforeach
    @endif
    </div>
@endsection