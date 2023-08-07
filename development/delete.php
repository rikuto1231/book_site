<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Users</title>
    <link rel="stylesheet" href="style.css" >
</head>
<body>

<?php
class DatabaseConnection
{
    private $server;
    private $dbname;
    private $user;
    private $pass;
    private $charset;
    private $pdo;

    public function __construct($server, $dbname, $user, $pass, $charset = 'utf8')
    {
        $this->server = $server;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->pass = $pass;
        $this->charset = $charset;
    }

    public function connect()
    {
        $dsn = 'mysql:host=' . $this->server . ';dbname=' . $this->dbname . ';charset=' . $this->charset;
        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass);

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('接続エラー: ' . $e->getMessage());
        }
    }

    public function getPDO()
    {
        return $this->pdo;
    }
}

// データベース接続情報
$server = 'mysql214.phy.lolipop.lan';
$dbname = 'LAA1517437-shop';
$user = 'LAA1517437';
$pass = 'Pass1015';

// DatabaseConnectionクラスを使ってデータベースに接続
$dbConnection = new DatabaseConnection($server, $dbname, $user, $pass);
$dbConnection->connect();

// データベース接続を取得
$pdo = $dbConnection->getPDO();

// 削除処理
if (isset($_POST['id'])) {
    $sql = $pdo->prepare("DELETE FROM Books WHERE book_id=?");
    if ($sql->execute([$_POST['id']])) {
        echo '削除に成功しました。';
    } else {
        echo '削除に失敗しました。';
    }
}

// 書籍一覧表示
echo '<table>';
echo '<tr><th>商品番号</th><th>商品名</th><th>価格</th><th>カテゴリ</th><th>価格</th><th>書籍説明</th><th>登録日</th><th>更新日</th></tr>';


foreach ($pdo->query('SELECT * FROM Books') as $row) {
    echo '<tr>';
    echo '<td>', $row['book_id'], '</td>';
    echo '<td>', $row['book_name'], '</td>';
    echo '<td>', $row['category'], '</td>';
    echo '<td>', $row['price'], '</td>';
    echo '<td>', $row['book_exp'], '</td>';
    echo '<td>', $row['registration'], '</td>';
    echo '<td>', $row['renewal'], '</td>';
    echo '</tr>';
    echo "\n";
}

echo '</table>';
?>

<button onclick="location.href='book-in.php'">検索画面へ戻る</button>

</body>
</html>