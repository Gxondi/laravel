<div class="top">
    <form id="articleForm" method="POST" action="/upload">
        <ul>
            <li class="title">
                <input type="text" name="title" id="title" placeholder="文章タイトル" required autocomplete="title">
            </li>

            <li class="body">
                <textarea name="body" id="body" cols="30" rows="10" required></textarea>
            </li>
            <li class="buttons">
                <button type="submit" class="btn" id="submitBtn">投稿</button>
                <button type="reset" class="btn">リセット</button>
            </li>
        </ul>
    </form>
</div>

<script>
    document.getElementById('articleForm').addEventListener('submit', function (event) {
        event.preventDefault();
        const form = event.target;
        const title = document.getElementById('title').value;
        const body = document.getElementById('body').value;
        const token = localStorage.getItem('token');
        console.log(title, body);
        console.log(token);
        fetch('/upload', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ title, body })
        }).then(response => response.json()).then(data => {
            if (data.success === 200) {
                alert('投稿しました');
                setTimeout(() => {
                    window.location.reload();
                }, 0);
            } else {
                //alert(data.error);
                console.error('Error:', data.message);
                alert(`Error: ${data.message}`);
            }
        }).catch(error => {
            console.error('Error:', error.message);
            alert(`Error: ${error.message}`);
        });
    });

</script>
