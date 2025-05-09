@extends('layouts.app2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('title', '住所変更画面')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-xl font-bold text-center mb-8">住所の変更</h1>

    <form action="{{ route('items.address.update', ['item' => $item->id]) }}" class="max-w-md mx-auto space-y-6" method="POST">
        @csrf

        <!-- 郵便番号 -->
        <div>
            <label for="postal_code" class="block text-sm font-semibold mb-1">郵便番号</label>
            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $address->postal_code ?? '') }}" class="w-full border rounded px-3 py-2">
            @error('postal_code')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- 住所 -->
        <div>
            <label for="address" class="block text-sm font-semibold mb-1">住所</label>
            <input type="text" id="address" name="address" value="{{ old('address', $address->address ?? '') }}" class="w-full border rounded px-3 py-2">
            @error('address')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- 建物名 -->
        <div>
            <label for="building" class="block text-sm font-semibold mb-1">建物名</label>
            <input type="text" id="building" name="building" value="{{ old('building', $address->building ?? '') }}" class="w-full border rounded px-3 py-2">
            @error('building')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- 更新ボタン -->
        <div class="text-center">
            <button type="submit" class="bg-red-400 text-white font-semibold py-2 px-6 rounded hover:bg-red-500">
                更新する
            </button>
        </div>
    </form>
</div>
@endsection