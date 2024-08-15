<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/headerfooter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/top.css') }}">
</head>
<body>
<div class="container">
    <h1 style="margin-bottom: 10px;text-align: center">新規登録</h1>
    <form id="registerForm" action="{{route('register.register')}}" method="POST">
        @csrf
        <ul>
            <li class="line">
                <input type="text" name="username" placeholder="ユーザー名" required autocomplete="username">
            </li>
            <li class="line">
                <input type="password" name="password" placeholder="パスワード" required autocomplete="password">
            </li>
            <li class="line">
                <input type="password" name="confirm_password" placeholder="チェックパスワード" required autocomplete="new-password">
            </li>
            <li class="line">
                <button type="submit">登録</button>
            </li>
        </ul>
    </form>
</div>
</body>
</html>
