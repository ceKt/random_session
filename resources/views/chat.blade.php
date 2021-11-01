<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="youlcray">
    <meta name="format-detection" content"telephone=no,address=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel=”stylesheet” href=”/style.css”>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{ mix('js/chat.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <nav class="navbar navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <h3>Chat Room</h3>
                </a>
                <button type="button" class="btn btn btn-danger d-flex justify-content-end" id="endchat">退出</button>
            </div>
            
        </nav>
    </header>
    <div class="container-fluid">
    <div class="row">
        <div class="col-1 text-center"></div>
        <div class="col-10 text-center">
            <div>
                <p class="text-right">webサイト</p>
                <p class="text-right bg-light">このチャットルームは10分後に消滅します。それまでにID交換等お願いします。</p>
            </div>
            <div id=chat_content></div>
            <br><br><br>
            <div class="fixed-bottom">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-10 text-center"><input type="text" id="message" class="form-control"></div>
                    <div class="col-2 text-center"><button type="button" id="sendmessage"class="btn btn-primary">送信</buton></div>
                </div><br>
            </div>
            </div>
        </div>
        <div class="col-1 text-center"></div>
    
</body>
</html>