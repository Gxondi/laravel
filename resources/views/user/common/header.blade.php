<header>
    <form id="userInfoForm" action="{{ route('userCenter') }}" method="GET">
        @csrf
        <div class="container-full">
            <div class="site-name">
                記事管理システム
            </div>
            @if($userInfo)
                <div class="user-info">
{{--                    @dd($userInfo)--}}
                    <span>ようこそ, {{ $userInfo['user']['username'] }}!</span>
                    <a href="{{ route('logout') }}" class="logout-button">ログアウト</a>
                </div>
            @else
                <div class="user-info">
                    <span>ログインしてください。</span>
                    <a href="{{ route('login') }}" class="login-button">ログイン</a>
                </div>
            @endif
        </div>
    </form>
</header>
