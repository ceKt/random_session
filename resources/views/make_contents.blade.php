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
    <form action="/make_contents/make_contents" method="post">
        @csrf
        <p>
            コンテンツ名：<input type="text" name="content_name">
        </p>
        <p>
            <input type="submit" value="作成">
            <input type="reset"  value="リセット">
        </p>
    </form>
</body>
</html>