<?php
class DatabaseConnection
{
    private $server;
    private $dbname;
    private $user;
    private $pass;
    private $pdo;

    public function __construct($server, $dbname, $user, $pass)
    {
        $this->server = $server;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->pass = $pass;
    }

    public function connect()
    {
        $connect = 'mysql:host=' . $this->server . ';dbname=' . $this->dbname . ';charset=utf8';
        try {
            $this->pdo = new PDO($connect, $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    public function getPDO()
    {
        return $this->pdo;
    }
}

class BookForm
{
    private $categoryOptions = [
        'プログラミング' => 'プログラミング',
        '青春小説' => '青春小説',
        '恋愛小説' => '恋愛小説',
    ];

    public function renderForm()
    {
        echo '<div id="form-insert">';
        echo '<form action="insert-out.php" method="post">';
        echo '<p>書籍名</p><input type="text" name="name" class="insert" value=""><br><br>';
        echo '<select name="category" id="category">';
        foreach ($this->categoryOptions as $value => $label) {
            echo '<option value="' . $value . '">' . $label . '</option>';
        }
        echo '</select><br>';
        echo '<p>価格</p><input type="text" name="price" class="insert" value=""><br>';
        echo '<p>書籍説明</p><input type="text" name="exp" class="insert" value=""><br>';
        echo '<button type="submit" id="new_insert">登録</button>';
        echo '</form>';
        echo '</div>';
    }
}


$databaseConnection = new DatabaseConnection('mysql214.phy.lolipop.lan', 'LAA1517437-shop', 'LAA1517437', 'Pass1015');
$databaseConnection->connect();
$pdo = $databaseConnection->getPDO();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>練習6-6-input</title>
</head>
<body>

<?php
// フォームの生成
$bookForm = new BookForm();
$bookForm->renderForm();
?>

</body>
</html>
