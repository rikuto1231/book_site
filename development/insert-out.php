<?php
const SERVER = 'mysql214.phy.lolipop.lan';
const DBNAME = 'LAA1517437-shop';
const USER = 'LAA1517437';
const PASS = 'Pass1015';

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
            return true;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            return false;
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}

$dbConnection = new DatabaseConnection(SERVER, DBNAME, USER, PASS);


if ($dbConnection->connect()) {
    $pdo = $dbConnection->getConnection();


    try {
        $sql = $pdo->prepare("INSERT INTO Books (book_name, category, book_exp, price, book_path, registration, renewal) VALUES (?, ?, ?, ?, NULL, CURDATE(), CURDATE())");
        $sql->execute([$_POST['name'], $_POST['category'], $_POST['exp'], $_POST['price']]);
        echo '<a href="book-in.php">検索画面に戻る</a>';

    } catch (Exception $e) {
        echo '登録に失敗しました。';
        echo '<a href="book-in.php">検索画面に戻る</a>';
    }
} else {
    
}
?>
