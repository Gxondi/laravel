<header>
    @csrf
    <div class="container-full">
        <div class="site-name">
            我的网站
        </div>
        <div id="user-info">
            dsadasdasdas
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const token = localStorage.getItem('token');
        const userInfoContainer = document.getElementById('user-info');
        //debugger;
        console.log(token);
        if (token) {
            fetch('getUserInfo', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => response.json()).then(data => {
                console.log(data);
                if (data.success === 200) {
                    console.log(data.result);
                    userInfoContainer.innerHTML = `ようこそ, ${data.result.username}! <a href="{{ route('logout') }}" class="logout-button">ログアウト</a>`;
                } else {
                    window.location.href = @json(route('login'));
                }
            }).catch(error => {
                    console.error('Error:', error);
                });
        } else {
            window.location.href = @json(route('login'));
        }
    });
</script>
