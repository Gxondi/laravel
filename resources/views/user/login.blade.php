<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    {{--    css 設置する--}}
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/headerfooter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/top.css') }}">
{{--    @include('user.common.head')--}}
</head>
<body>
    <div class="container">
        <h1 style="margin-bottom: 10px;text-align: center">ログイン</h1>
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form id="loginForm" action="/doLogin" method="POST">
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
    <!-- 登录script -->
    <script>
        function showError(message) {
            alert(message);
        }

        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    showError(data.error);
                } else if (data.success === 200) {
                    localStorage.setItem('token', data.token);
                    window.location.href = data.redirect_url;
                }
            })
            .catch(error => {
                showError('通信エラーが発生しました。');
                console.error('Error:', error);
            });
        });
    </script>
</body>

</html>
