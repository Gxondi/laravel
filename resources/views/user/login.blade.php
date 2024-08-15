<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/headerfooter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/top.css') }}">
</head>
<body>
    <div class="container">
        <h1 style="margin-bottom: 10px;text-align: center">ログイン</h1>
        <form id="loginForm" action="{{ route('login.login') }}" method="POST">
            @csrf
            <ul>
                <li class="line">
                    <input type="text" name="username" placeholder="ユーザー名" required>
                </li>
                <li class="line">
                    <input type="password" name="password" placeholder="パスワード" required>
                </li>
                <li class="line">
                    <button type="submit" name="提交登录">ログイン</button>
                </li>
                <li class="line">
                    <p><a href="{{ route('register') }}">新規登録</a></p>
                </li>
            </ul>
        </form>
    </div>
</body>
</html>
