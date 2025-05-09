@extends('layouts.app2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('title', '商品購入画面')

@section('content')
<div class="container mx-auto px-8 py-6">
    <div class="flex flex-wrap md:flex-nowrap gap-8">

        <!-- {{-- 左カラム（商品情報・支払い方法・配送先） --}} -->
        <div class="w-full md:w-2/3 space-y-8">

            <!-- {{-- 商品情報 --}} -->
            <div class="flex items-start gap-4">
                <div class="w-32 h-32 bg-gray-300 flex items-center justify-center text-sm">
                    <img src="{{ $item->image }}" alt="商品画像" class="img-fluid item-image">
                </div>
                <div>
                    <h2 class="text-xl font-bold">{{ $item->name }}</h2>
                    <p class="text-lg font-semibold mt-2">¥{{ number_format($item->price) }}</p>
                </div>
            </div>

            <hr>

            <!-- {{-- 支払い方法 --}} -->
            <div>
                <h3 class="text-lg font-semibold mb-2">支払い方法</h3>

                <select id="paymentSelect" name="payment_method" class="border border-gray-400 rounded px-3 py-2 w-full max-w-xs">
                    <option value="">選択してください</option>
                    <option value="コンビニ払い">コンビニ払い</option>
                    <option value="カード払い">カード払い</option>
                </select>

                @if(request('payment_method'))
                    <p class="text-sm text-gray-600 mt-2">選択中: {{ request('payment_method') }}</p>
                @endif
            </div>

            <hr>

            <!-- {{-- 配送先 --}} -->
            <div>
                <h3 class="text-lg font-semibold mb-2">配送先住所</h3>
                @if ($address)
                    <p class="mb-1">〒{{ $address->postal_code }}</p>
                    <p class="mb-1">{{ $address->address }}</p>
                    <p class="mb-4">{{ $address->building }}</p>
                    <a href="{{ route('items.address', $item->id) }}" class="text-blue-500 underline">住所を変更する</a>
                @else
                    <p class="text-red-500">住所が未登録です。</p>
                    <a href="{{ route('items.address', $item->id) }}" class="text-blue-500 underline">住所を登録する</a>
                @endif
            </div>
        </div>

        <!-- 右カラム（合計金額・支払い方法・購入ボタン） -->
        <div class="w-full md:w-1/3 space-y-4">
            <form method="POST" action="{{ route('items.purchase.complete') }}">
                @csrf
                @if ($address)
                    <input type="hidden" name="postal_code" value="{{ $address->postal_code }}">
                    <input type="hidden" name="address" value="{{ $address->address }}">
                    <input type="hidden" name="building" value="{{ $address->building }}">
                @endif
                <input type="hidden" name="item_id" value="{{ $item->id }}">

                <input type="hidden" id="paymentMethodHidden" name="payment_method" value="{{ request('payment_method') }}">

                <!-- 合計金額などの表示 -->
                <div class="border border-gray-300 p-4 space-y-2">
                    <div class="flex justify-between">
                        <span>商品代金</span>
                        <span>¥{{ number_format($item->price) }}</span>
                    </div>
                </div>

                <!-- 表示エリア -->
                <p id="selectedMethod" class="text-sm text-gray-600 mt-2">選択中: なし</p>

                <!-- 購入ボタン -->
                <button type="submit" class="w-full bg-red-400 text-white font-semibold py-3 rounded mt-6">
                    購入する
                </button>
            </form>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('paymentSelect');
        const display = document.getElementById('selectedMethod');
        const hiddenInput = document.getElementById('paymentMethodHidden');

        if (select) {
            select.addEventListener('change', function () {
                const selected = this.value;
                display.textContent = selected ? `選択中: ${selected}` : '選択中: なし';
                hiddenInput.value = selected;
            });
        }
    });
</script>
@endsection