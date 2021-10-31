<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="youlcray">
    <meta name="format-detection" content"telephone=no,address=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel=”stylesheet” href=”/style.css”>
</head>

<body>
    <div>コンテンツを追加します</div>
    <form action="/make_sessionlists/make_sessionlists" method="post">
        @csrf
        <p>
            コンテンツ名：
            @foreach($contents as $content)
                <input type="radio" name="content_id" value={{$content->content_id}}>{{$content->content_name}}
            @endforeach
        </p>
        <p>
            セッション名 ：<input type="text" name="session_name">
        </p>
        <p>
            ルール ：<input type="text" name="rule">
        </p>
        <p>
            必要人数 ：<input type="number" name="numpeople">
        </p>
        <p>
            <input type="submit" value="作成">
            <input type="reset"  value="リセット">
        </p>
    </form>
</body>
</html>