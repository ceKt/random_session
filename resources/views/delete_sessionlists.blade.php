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
    <div>セッションを削除します</div>
    <form action="/delete_sessionlists/make_sessionlists" method="post">
        @csrf
        <p>
            セッション名：<br>
            @foreach($sessionlists as $sessionlist)
                <input type="checkbox" id="{{$sessionlist->session_id}}"name="session_id[]" value={{$sessionlist->session_id}}>{{$contents->where('content_id', $sessionlist->content_id)->first()['content_name']}}：{{$sessionlist->session_name}}：{{$sessionlist->rule}}：{{$sessionlist->numpeople}}<br>
            @endforeach
        </p>
        <p>
            <input type="submit" value="削除">
        </p>
    </form>
</body>
</html>