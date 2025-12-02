<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>取引完了のお知らせ</title>
</head>
<body>
    <p>{{ $transaction->buyer->name }} さんとの取引が完了しました。</p>

    <p>評価:
        @if($transaction->buyer_rated_at)
            購入者から: {{ $transaction->buyer_rating }} / 5
        @endif
        @if($transaction->seller_rated_at)
            出品者から: {{ $transaction->seller_rating }} / 5
        @endif
    </p>

    <p>詳細はチャット画面で確認できます。</p>
</body>
</html>