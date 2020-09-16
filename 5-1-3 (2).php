<!DOCTYPE HTML>
<html lang="ja">
    <head>
         <meta charaset="UTF-8">
         <title>5-1-2</title>
    </head>
    <body>
        <span style="font-size: 20px;">新規入力</span>
        <form method="POST" action="">
        <label for="name">名前：</label><input type="text" name="name" required><required></p>
        <label for="comment"></label>コメント：</label><input type="text" name="comment"><required></p>    
        <label for="password">パスワード：</label><input type="text" name="password"><required></p> 
        <input type="submit" name="send" value="送信"></p>
        </form>
        <hr>
        <span style="font-size: 20px;">編集</span>
        <form method="POST" action="">
        <label for="number">編集したいコメントの番号:</label><input type="number" name="edit_number" required><required></p>
        <label for="comment"></label>コメントの修正内容：</label><input type="text" name="edit_comment"><required></p> 
        <label for="password">パスワード：</label><input type="text" name="edit_password"><required></p> 
        <input type="submit" name="edit" value="編集"></p>
        </form>
        <hr>
        <span style="font-size: 20px;">削除</span>
        <form method="POST" action="">
        <label for="number">削除したいコメントの番号:</label><input type="number" name="delite_number" required><required></p>
        <label for="password">パスワード：</label><input type="text" name="delite_password"><required></p> 
        <input type="submit" name="delite" value="削除"></p>
        </form>
     
<?php
// DB接続設定 投稿フォームのみ   }   
    
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
	$sql = "CREATE TABLE if not exists tbtest2"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name varchar(32),"
	. "comment TEXT,"
	. "password varchar(32)"
	.");";
	$stmt = $pdo->query($sql);
    
    if (isset($_POST['name'], $_POST['comment'], $_POST['password']) && $_POST['name'] !== ''&& $_POST['commnent'] !== '' 
    && $_POST['password'] !== '')  {
            $name = $_POST['name'];
            $comment = $_POST['comment'];
            $password = $_POST['password'];
 
            $sql = "INSERT INTO tbtest2 (name, comment, password) VALUES ('$name', '$comment', '$password')";
            $res = $pdo->query($sql);
            
            //データの挿入失敗
            if (!$sql) {
            echo "新規入力失敗";
            }
            //データの挿入成功
            if ($sql) {
            echo "新規入力成功！";
            }
            echo '<br>';
            
    
        $sql = 'SELECT * FROM  tbtest2';
	    $stmt = $pdo->query($sql);
	    $results = $stmt->fetchAll();
	    foreach ($results as $row){
	    //$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].'<br>';
    	echo "<hr>";
    	}
    }
    
    // 投稿されたデータの削除
    if (isset($_POST['delite_number'], $_POST['delite_password']) && $_POST['delite_number'] !== ''&& $_POST['delite_password'] !== '' )  {
    $id = $_POST['delite_number'];
	$sql = 'delete from tbtest2 where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	
	 //データの削除失敗
            if (!$sql) {
            echo "削除失敗！";
            }
            echo '<br>';
            ////データの削除成功！
            if ($sql) {
            echo "削除成功！";
            }
            echo '<br>';
            echo '<br>';
             
	$sql = 'SELECT * FROM  tbtest2';
	    $stmt = $pdo->query($sql);
	    $results = $stmt->fetchAll();
	    foreach ($results as $row){
	    //$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].'<br>';
    	echo "<hr>";
    	}
    
           
        
    }
    
   // 投稿されたデータの編集
        if (isset($_POST['edit_number'], $_POST['edit_comment'], $_POST['edit_password'])
        && $_POST['edit_number'] !== ''&& $_POST['edit_comment'] !== '' && $_POST['edit_password'] !== '')  {
            
        $id = $_POST['edit_number']; //変更する投稿番号
	    $comment = $_POST['edit_comment'];//変更したいコメント
    
       	$sql = 'UPDATE tbtest2 SET comment = :comment WHERE id = :id ';
	    $stmt = $pdo->prepare($sql);
	    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	    $stmt->execute();    
        
    	if (!$sql) {
        echo "編集失敗";
        }
        if ($sql) {
        echo "編集成功！";
        echo "<hr>";
        }
        
        $sql = 'SELECT * FROM  tbtest2';
	    $stmt = $pdo->query($sql);
	    $results = $stmt->fetchAll();
	    foreach ($results as $row){
	    //$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].'<br>';
    	echo "<hr>";
    	}
}
        
        
?>
</body>
</html>