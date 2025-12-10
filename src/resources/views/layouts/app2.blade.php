<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app2.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">

            <div class="header__logo">COACHTECH</div>

            <form action="" method="GET" class="search-form">
                <input type="text" name="keyword" class="search-form__item-input" value="{{ old('keyword') }}" placeholder="なにをお探しですか？">
                <button type="submit">検索</button>
            </form>

            <nav class="nav">
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit">ログアウト</button>
                </form>
                <a href="{{ route('profile.mypage') }}">マイページ</a>
                <a href="{{ route('profile.sell') }}" class="btn-sell">出品</a>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    @stack('scripts')

</body>
</html>
