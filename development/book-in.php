<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Users</title>
    <link rel="stylesheet" href="style.css" >
</head>
<body>
    <script>
        function reloadPage() {
            location.reload();
        }

        function resetForm(event) {
            event.preventDefault();
            document.getElementById("search_form").reset();
        }
    </script>


    <div id="pat">
    <h1 class="title">商品検索画面</h1>
    <form id="search_form" action="book-out.php" method="post">
        <div id="search_element">
            <input type="text" name="search_text">
            <p class="tmp"><button type="submit" id="search">検索</button></p>
            <button onclick="resetForm(event)">リセット</button><br>
            <p class="tmp">※未入力時は全件表示</p>
        </div>

        <div id="search_category">
            <p class="tmp">カテゴリ</p>
            <select name="category" id="category">
                <option hidden selected value="0">カテゴリを選択</option>
                <option value="1">プログラミング</option>
                <option value="2">青春小説</option>
                <option value="3">恋愛小説</option>
            </select><br>
        </div>

        <div id="search_price">
            <p class="tmp">価格</p>
            <select name="price" id="price" class="cp_s106">
                <option hidden selected value="0">価格を選択</option>
                <option value="1">0~500</option>
                <option value="2">501~1000</option>
                <option value="3">1001~2000</option>
                <option value="4">2001~3000</option>
                <option value="5">3001~5000</option>
            </select><br>
        </div>
    </form>
    </div>
</body>
</html>
