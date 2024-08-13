<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>文章列表</title>
    <style>
        .table-container {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            white-space: nowrap;
        }
    </style>
</head>
<body>
<h1>文章列表</h1>
<div class="table-container">
    <table id="articleTable">
        <thead>
        <tr>
            <th>タイトル</th>
            <th>内容</th>
            <th>作成時間</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <!-- 文章数据 -->
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const token = localStorage.getItem('token');
        if (token) {
            fetch('/getArticles', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => response.json()).then(data => {
                console.log(data);
                if (data.error) {
                    alert(data.error);
                } else if (data.success === 200) {
                    const articles = data.result;
                    if (Array.isArray(articles)) {
                        const tableBody = document.querySelector('#articleTable tbody');
                        articles.forEach(article => {
                            //debugger;
                            if(article.status === "1"){
                                const row = document.createElement('tr');
                                const titleEl = document.createElement('td');
                                const bodyEl = document.createElement('td');
                                const timeEl = document.createElement('td');
                                const actionTd = document.createElement('td');
                                const actionEl = document.createElement('button')
                                actionTd.appendChild(actionEl);
                                titleEl.textContent = article.title;
                                bodyEl.textContent = article.body;
                                timeEl.textContent = article.createTime;
                                actionEl.textContent = '削除';
                                actionEl.addEventListener('click', function () {
                                    fetch(`/deleteArticle/${article.id}`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'Authorization': `Bearer ${token}`,
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({
                                            id: article.id
                                        })
                                    }).then(response => response.json()).then(data => {
                                        if (data.error) {
                                            alert(data.error);
                                        } else if (data.success === 200) {
                                            row.remove();
                                        } else {
                                            console.error('削除エラー1:', data);
                                        }
                                    }).catch(error => {
                                        console.error('削除エラー2', error.message);
                                    });
                                });
                                row.appendChild(titleEl);
                                row.appendChild(bodyEl);
                                row.appendChild(timeEl);
                                row.appendChild(actionTd);
                                tableBody.appendChild(row);
                            }
                        });
                    } else {
                        console.error('リスト　エラー:', articles);
                    }
                } else {
                    console.error('文章がない:', data.success);
                }
            }).catch(error => {
                console.error('システム　エラー:', error);
            });
        }
    });
</script>
</body>
</html>
