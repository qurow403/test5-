@extends('layouts.app')

@section('title', '取引チャット画面')

@section('css')
<link rel="stylesheet" href="{{ asset('css/chat.css') }}">
<link rel="stylesheet" href="{{ asset('css/chat-modal.css') }}">
@endsection

@section('content')
<div class="chat-container">

    <aside class="chat-sidebar">
        @if($isSeller)
            @include('components.chat-sidebar-seller')
        @else
            @include('components.chat-sidebar-buyer')
        @endif
    </aside>

    <section class="">

    </section>

    <section class="chat-main">
        @include('components.chat-header')

        @include('components.chat-messages')

        @include('components.chat-input')
    </section>

</div>

@if($isSeller && $needsRating)
    @include('layouts.rating-modal')
@endif
@endsection