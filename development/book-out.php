<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Users</title>
</head>
<body>
    <script>


    </script>
    <h1>商品一覧</h1>

    <?php
class Main {
    
    private $host = 'mysql214.phy.lolipop.lan'; // データベースサーバーのホスト名
    private $dbname = 'LAA1517437-shop'; // 使用するデータベース名
    private $user = 'LAA1517437'; // データベースのユーザー名
    private $password = 'Pass1015'; // データベースのパスワード
    private $pdo; // PDOオブジェクト

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

        echo '<a href="insert-in.php">新規登録</a>';

        foreach ($sql as $row) {
            echo '<div class="container">';
            echo '<div class="set1">';
            echo '<p class="syohin_id">', $row['book_id'], '</p>';
            if(!isset($row['book_img'])){
                echo '<img class="syohin_img" src="img/'. $row['book_path']. '">';
            }else{
                echo '<img class="syohin_img" src="img/book_null.jpg">';
            }
            
            echo '</div>';
            echo '<div class="set2">';
            echo '<h4 class="syohin_name">', $row['book_name'], '</h4>';
            echo '<h4 class="syohin_price">', $row['price'], '</h4>';
            echo '<p>'. $row['category']. '</p>';
            echo '<p class="reg_date">'.'登録日'. $row['registration']. '</p>';
            echo '<p class="up_date">'.'更新日'.$row['renewal'].'</p>';
            if(!isset($row['book_exp'])){
                echo '<p class="syohin_exp">'.'説明文が未設定です'.'</p>';
            }else{
                echo '<p class="syohin_exp">'.$row['book_exp'].'</p>';
            }
            echo '</div>';
            echo '<div class="set3">';

            echo '<form action="register.php" method="post">';
            echo '<input type="hidden" class="edit" name="id" value="',$row['book_id'],'">';
            echo '<button type="submit" class="edit">更新</button>';
            echo '</form>';

            echo '<form action="delete.php" method="post">';
            echo '<input type="hidden" class="edit" name="id" value="'.$row['book_id'],'">';
            echo '<button type="submit" class="delete">削除</button>';
            echo '</form>';

            echo '</div>';
            echo '<div style="border-top: 1px solid black;"></div>';

            echo '</div>';
        }

        echo '<p><button type="button" class="delete" onclick="history.back()">戻る</button></p>';
    }

}

$main = new Main();
$main->displayBooks();

?>


</body>
</html>
