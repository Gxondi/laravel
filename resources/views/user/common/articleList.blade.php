<style>
    .table-container {
        max-height: 400px;
        overflow-y: auto;
        border: 1px solid #ddd;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        white-space: normal;
        word-wrap: break-word;
        overflow: hidden;
        text-align: center;
    }

    th {
        background-color: #f4f4f4;
    }

</style>
<body>
<h1>文章リスト</h1>
<div class="table-container">
    <table id="articleTable">
        <thead>
        <tr>
            <th>タイト</th>
            <th>内容</th>
            <th>作成時間</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @if(isset($articles['articles']) && !empty($articles['articles']))
        @foreach($articles['articles'] as $article)
                @if($article['status'] == 1)
                    <tr>
                        <td>{{ $article['title'] }}</td>
                        <td>{{ $article['body'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($article['created_at'])->format('Y-m-d H:i:s') }}
                        </td>
                        <td>
                            <form action="{{ route('deleteArticle', ['id' => $article['id']]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">削除</button>
                            </form>
                        </td>
                    </tr>
                @endif
            @endforeach
        @else
            <tr>
                <td colspan="4">文章がない</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
