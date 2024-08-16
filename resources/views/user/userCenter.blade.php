<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザーセンター</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/headerfooter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/top.css') }}">
</head>
<style>
    header {
        margin-bottom: 20px;
    }
    .top {
        padding: 20px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 5px;
        width: 50%;
        max-width: 600px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin: 0 auto 20px;
    }
</style>



<body>
@include('user.common.header', ['userInfo' => $userInfo])
<div class="main">
    <!-- 顶部区域 -->
    <div class="top">
        @include('user.common.top')
    </div>
    <!-- 下部区域 -->
    <div class="article">
        @include('user.common.articleList', ['articles' => $articles])
    </div>
</div>
@include('user.common.footer')

</body>
</html>
