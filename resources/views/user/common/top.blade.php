<div class="top">
    <form id="articleForm" method="POST" action="{{ route('upload') }}">
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

