<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Users</title>
</head>
<body>

    <form method="POST" action="getuser.php">
        <label for="username">ユーザー名：</label>
        <input type="text" name="username" id="username">
        
        <br>
        <input type="submit" value="送信">
    </form>
    <hr>


    <?php
    $dsn = 'mysql:host=localhost;dbname=product';
    $user = 'root';
    //微妙にわからん
    $password = '';

    //try,catchは接続確認用
    try {
        //POD拡張機能のPODインスタンス
        $dbh = new PDO($dsn, $user, $password);
        echo "<p>Succeed!</p>";
            
        $sql = 'select * from user';
        //prepareメッソドがsqlクエリの準備
        $sth = $dbh->prepare($sql);
        //executeメソッドで実行
        $sth->execute();
        //fetchAllメソッドがクエリ実行結果を配列で返す
        $result = $sth->fetchAll();

        //なんでasで名前変える？ A.どのカラムか分かる
        // * だから複数出てる
        foreach ($result as $row) {
            echo $row['id']." ";
            echo $row['name']." ";
            echo $row['age']." ";
            echo "<br />";
        }
    } catch (PDOException $e) {
        echo  "<p>Failed : " . $e->getMessage()."</p>";
        exit();
    }

    //ログイン機能検証

    //初手だけエラー出る,初回分余計に回ってる
    $username = $_POST['username'];

    //echo $username;

    // $sql = 'INSERT INTO user (name) VALUES ($username)';
    // $stmt = $dbh->prepare($sql);

    // $stmt->bindValue(1, $username, PDO::PARAM_STR);
    // $stmt->execute();
    // $pdo = null;
    echo $username;

    ?>
</body>
</html>