<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Users</title>
</head>
<body>
    <h1>商品一覧</h1>
    <table border="1">
        <tr>
            <th>商品名</th>
        </tr>

        <?php
            $host = '***'; // データベースサーバーのホスト名
            $dbname = '***'; // 使用するデータベース名
            $user = '***'; // データベースのユーザー名
            $password = '***'; // データベースのパスワード
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);

            $array_category = array(
                '0' => "None",
                '1' => "プログラミング",
                '2' => "青春小説",
                '3' => "恋愛小説"
            );

            $array_price1 = array(
                '0' => 0,
                '1' => 500,
                '2' => 1000,
                '3' => 2000,
                '4' => 3000,
                '5' => 5000,
            );

            $array_price2 = array(
                '0' => 0,
                '1' => 0,
                '2' => 501,
                '3' => 1001,
                '4' => 2001,
                '5' => 3001,
            );

            $search = $_POST['search_text'];
            $category = $_POST['category'];
            $category_name = $array_category[$category];
            $price = $_POST['price'];
            $price1 = $array_price1[$price];
            $price2 = $array_price2[$price];

            if ($category == 0 and $price == 0) {
                $sql = $pdo->prepare('select * from Books where book_name like ?');
                $sql->execute(["%$search%"]);

                
            } else if ($category != 0 and $price != 0) {
                $sql = $pdo->prepare('select * from Books where book_name like ? and category =? and price between ? and ?');
                $sql->execute(["%$search%", $category_name, $price2, $price1]);

                
            } else if ($category != 0 and $price == 0) {
                $sql = $pdo->prepare('select * from Books where book_name like ? and category =?');
                $sql->execute(["%$search%", $category_name]);

                
            } else {
                $sql = $pdo->prepare('select * from Books where book_name like ? and price between ? and ?');
                $sql->execute(["%$search%", $price2, $price1]);

                
            }
            foreach ($sql as $row) {
                echo '<tr>';
                echo '<td>', $row['book_name'], '</td>';
                echo '</tr>';
            }

            echo '<p><button type="button" class="delete" onclick="history.back()">戻る</button></p>';


            //試作品枠
            //要素を出して後でcss、db調整
            echo '<div class="container">';
            echo '<div class="set1">';
            echo '<p class="syohin_id">商品ID</p>';
            echo '<img class="syohin_img" src="img/book_db.jpg">';
            echo '</div>';
            echo '<div class="set2">';
            echo '<h4 class="syohin_name">商品名</h4>';
            echo '<h4 class="syohin_price">商品単価</h4>';
            echo '<p class="reg_date">商品登録日</p>';
            echo '<p class="up_date">商品更新日</p>';
            echo '<p class="syohin_exp">商品説明</p>';
            echo '</div>';
            echo '<div class="set3">';
            echo '<p><button type="submit" class="edit">編集</button></p><br>';
            echo '<p><button type="submit" class="delete">削除</button></p>';
            echo '</div>';
            echo '</div>';
        ?>
    </table>
</body>
</html>
