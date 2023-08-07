<?php
    session_start();
    const SERVER = 'mysql214.phy.lolipop.lan';
    const DBNAME = 'LAA1517437-shop';
    const USER = 'LAA1517437';
    const PASS = 'Pass1015';

    $connect = 'mysql:host='. SERVER . ';dbname='. DBNAME . ';charset=utf8';
?>

<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<title>更新</title>
	</head>
	<body>
<?php
    $pdo=new PDO($connect, USER, PASS);


    $sql = $pdo->prepare("update Books set book_name=?,price=?,category=?,book_exp=?,renewal=CURDATE() where book_id=?");

    if (empty($_POST['name'])) {
        echo '商品名を入力してください。';
    } else
    if (!preg_match('/[0-9]+/', $_POST['price'])) {
        echo '商品価格を整数で入力してください。';
    } else
    
    if ($sql->execute([htmlspecialchars($_POST['name']),($_POST['price']),($_POST['category']),($_POST['exp']),($_SESSION['id'])])) {
        echo '更新に成功しました';
    }else{
        echo '更新に失敗しました';
    }
?>
        <hr>
        <table>
        <tr><th>商品番号</th><th>商品名</th><th>商品価格</th><th>カテゴリ</th><th>書籍説明</th></tr>

<?php
foreach ($pdo->query('select * from Books') as $row) {
    echo '<tr>';
    echo '<td>', $row['book_id'], '</td>';
    echo '<td>', $row['book_name'], '</td>';
    echo '<td>', $row['price'], '</td>';
    echo '<td>', $row['category'], '</td>';
    echo '<td>', $row['book_exp'], '</td>';
    echo '</tr>';
    echo "\n";
}

?>
        </table>
        <button onclick="location.href='book-in.php'">検索画面へ戻る</button>
    </body>
</html>

