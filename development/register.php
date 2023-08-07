<?php
session_start();

class Database
{
    private $pdo;

    public function __construct($server, $dbname, $user, $pass)
    {
        $connect = 'mysql:host=' . $server . ';dbname=' . $dbname . ';charset=utf8';
        $this->pdo = new PDO($connect, $user, $pass);
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}

class FormGenerator
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function generateForm($id)
    {
        $sql = $this->pdo->prepare("SELECT * FROM Books WHERE book_id = ?");
        $sql->execute([$id]);

        foreach ($sql as $row) {
            echo '<form action="register-out.php" method="post">';
            echo '<td><input type="text" name="name" value="', $row['book_name'], '"></td>';
            echo '<td><input type="text" name="price" value="', $row['price'], '"></td>';
            echo '<td><select name="category" id="category">
                    <option selected value="プログラミング">プログラミング</option>
                    <option value="青春小説">青春小説</option>
                    <option value="恋愛小説">恋愛小説</option>
                </select>';
            echo '<td>';
            if (!isset($row['book_exp'])) {
                echo ' <input type="text" name="exp" value="' . '文字が未設定です' . '">';
            } else {
                echo ' <input type="text" name="exp" value="', $row['book_exp'], '">';
            }
            echo '</td>';
            echo '<td><input type="submit" value="更新"></td>';
            echo '</form>';
        }
    }
}

const SERVER = 'mysql214.phy.lolipop.lan';
const DBNAME = 'LAA1517437-shop';
const USER = 'LAA1517437';
const PASS = 'Pass1015';

$db = new Database(SERVER, DBNAME, USER, PASS);
$pdo = $db->getPdo();

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>練習6-6-input</title>
</head>

<body>
<table>
        <tr><th>商品名</th><th>価格</th><th>カテゴリ</th><th>書籍説明</th></tr>



    <?php
    

    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $_SESSION['id'] = $id;

        $formGenerator = new FormGenerator($pdo);
        $formGenerator->generateForm($id);
    }
    ?>
    </table>

</body>

</html>
