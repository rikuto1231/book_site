<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Users</title>
</head>
<body>
    <h1>商品一覧</h1>

    <?php
class Main {
    
    private $host = '***'; // データベースサーバーのホスト名
    private $dbname = '***'; // 使用するデータベース名
    private $user = '***'; // データベースのユーザー名
    private $password = '***'; // データベースのパスワード
    private $pdo; 

    private $array_category = array(
        '0' => "None",
        '1' => "プログラミング",
        '2' => "青春小説",
        '3' => "恋愛小説"
    );

    private $array_price1 = array(
        '0' => 0,
        '1' => 500,
        '2' => 1000,
        '3' => 2000,
        '4' => 3000,
        '5' => 5000,
    );

    private $array_price2 = array(
        '0' => 0,
        '1' => 0,
        '2' => 501,
        '3' => 1001,
        '4' => 2001,
        '5' => 3001,
    );

    public function __construct() {
        $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->user, $this->password);
    }

    public function displayBooks() {
        $search = $_POST['search_text'] ?? '';
        $category = $_POST['category'] ?? 0;
        $category_name = $this->array_category[$category];
        $price = $_POST['price'] ?? 0;
        $price1 = $this->array_price1[$price];
        $price2 = $this->array_price2[$price];

        if ($category == 0 && $price == 0) {
            $sql = $this->pdo->prepare('select * from Books where book_name like :search order by book_id asc');
            $sql->bindValue(':search', "%$search%");
            $sql->execute();
        } else if ($category != 0 && $price != 0) {
            $sql = $this->pdo->prepare('select * from Books where book_name like :search and category = :category and price between :price2 and :price1 order by book_id asc');
            $sql->bindValue(':search', "%$search%");
            $sql->bindValue(':category', $category_name);
            $sql->bindValue(':price2', $price2);
            $sql->bindValue(':price1', $price1);
            $sql->execute();
        } else if ($category != 0 && $price == 0) {
            $sql = $this->pdo->prepare('select * from Books where book_name like :search and category = :category order by book_id asc');
            $sql->bindValue(':search', "%$search%");
            $sql->bindValue(':category', $category_name);
            $sql->execute();
        } else {
            $sql = $this->pdo->prepare('select * from Books where book_name like :search and price between :price2 and :price1 order by book_id asc');
            $sql->bindValue(':search', "%$search%");
            $sql->bindValue(':price2', $price2);
            $sql->bindValue(':price1', $price1);
            $sql->execute();
        }

        foreach ($sql as $row) {
            echo '<div class="container">';
            echo '<div class="set1">';
            echo '<p class="syohin_id">', $row['book_id'], '</p>';
            if(isset($row['book_img'])){
                echo '<img class="syohin_img" src="img/', $row['book_img'], '">';
            }else{
                echo '<img class="syohin_img" src="img/book_null.jpg">';
            }
            
            echo '</div>';
            echo '<div class="set2">';
            echo '<h4 class="syohin_name">', $row['book_name'], '</h4>';
            echo '<h4 class="syohin_price">', $row['price'], '</h4>';
            echo '<p class="reg_date">', $row['book_detail'], '</p>';
            echo '<p class="up_date">商品更新日</p>';
            echo '<p class="syohin_exp">商品説明</p>';
            echo '</div>';
            echo '<div class="set3">';
            echo '<p><button type="submit" class="edit">編集</button></p><br>';
            echo '<p><button type="submit" class="delete">削除</button></p>';
            echo '</div>';
            echo '</div>';
        }

        echo '<p><button type="button" class="delete" onclick="history.back()">戻る</button></p>';
    }
}

// Mainのインスタンス作成
$main = new Main();
// displayBooksメソッドを呼び出して表示
$main->displayBooks();
?>


</body>
</html>
