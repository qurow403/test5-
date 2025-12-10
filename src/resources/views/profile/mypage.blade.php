@extends('layouts.app2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('title', 'マイページ')

@section('content')
<div class="mypage-container">

    <div class="user-info">
    <div class="user-info-wrapper">
        <div class="user-left">
            <div class="user-icon">
                <img src="{{ asset('images/default-user.png') }}" alt="ユーザーアイコン">
            </div>

            <div class="user-details">
                <div class="user-name">{{ Auth::user()->name }}</div>

                @if ($sellerRatingCount > 0)
                    <div class="stars average-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star {{ $i <= $sellerRatingAvg ? 'active' : '' }}">★</span>
                        @endfor
                    </div>
                @endif

                @if ($buyerRatingCount > 0)
                    <div class="stars average-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star {{ $i <= $buyerRatingAvg ? 'active' : '' }}">★</span>
                        @endfor
                    </div>
                @endif
            </div>
        </div>

        <div class="edit-profile">
            <a href="{{ route('profile.edit') }}" class="edit-profile-button">プロフィールを編集</a>
        </div>
    </div>
</div>

    <div class="tabs">
        <a href="#" id="tab-sold" class="tab active" onclick="showTab('sold')">出品した商品</a>
        <a href="#" id="tab-purchased" class="tab" onclick="showTab('purchased')">購入した商品</a>
        <a href="#" id="tab-in-progress" class="tab" onclick="showTab('in-progress')">取引中の商品
            @if ($unreadTotal > 0)
                <span class="tab-badge">{{ $unreadTotal }}</span>
            @endif
        </a>
    </div>

    <div class="item-list" id="sold-items">
        @foreach ($soldItems as $item)
            <a href="#" class="item-card">
                <img src="{{ $item->image }}" alt="商品画像">
                <div class="item-name">{{ $item->name }}</div>
            </a>
        @endforeach
    </div>

    <div class="item-list" id="purchased-items" style="display:none;">
        @foreach ($purchasedItems as $item)
            <a href="#" class="item-card">
                <img src="{{ $item->image }}" alt="商品画像">
                <div class="item-name">{{ $item->name }}</div>
            </a>
        @endforeach
    </div>

    <div class="item-list" id="in-progress-items" style="display:none;">
        @foreach ($inProgressItems as $item)
            <a href="{{ route('chat.show', ['transaction' => $item->transaction_id]) }}" class="item-card">

                @if ($item->unread_count > 0)
                    <span class="badge">{{ $item->unread_count }}</span>
                @endif

                <img src="{{ $item->image }}" alt="商品画像">
                <div class="item-name">{{ $item->name }}</div>
            </a>
        @endforeach
    </div>

</div>

@push('scripts')
<script>
function showTab(tab) {
    document.getElementById('sold-items').style.display = (tab === 'sold') ? 'grid' : 'none';
    document.getElementById('purchased-items').style.display = (tab === 'purchased') ? 'grid' : 'none';
    document.getElementById('in-progress-items').style.display = (tab === 'in-progress') ? 'grid' : 'none';

    document.querySelectorAll('.tab').forEach(el => el.classList.remove('active'));
    document.getElementById('tab-' + tab).classList.add('active');
}
</script>
@endpush
@endsection
