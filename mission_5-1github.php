<html>
<head>
<meta charset="utf-8">
<title>簡易掲示板</title>
</head>
<body>
<?php
///データベース接続
$dsn ='database';
$user ='user';
$password ='password';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));

///変数
$name = @$_POST["name"];
$comment = @$_POST["comment"];
$date = date("Y-m-d H:i:s");
$pass = @$_POST['pass'];

//編集選択
if(!empty($_POST["send_hensyu"])){
	$id = $_POST["newtext"];
	$pass = $_POST["pass_hensyu"];
	$sql = 'select * from mykeiziban where id=:id AND pass=:pass';
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(":id" => $id, ":pass" => $pass));
	$data = $stmt->fetch();
if($data['id']==$id and $data['pass']==$pass){
	$id = $_POST["newtext"];
	$pass = $_POST["pass_hensyu"];
	$sql = 'select * from mykeiziban where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(":id" => $id));
	$data = $stmt->fetch();
	$newname = $data['name'];
	$newcome = $data['comment'];
} else { 
	echo "パスワードが違います。";	

}
}
//編集
if(!empty($_POST["number"])){
	$id = $_POST["number"];
	$pass = $_POST["pass"];
	$sql = 'select * from mykeiziban where id=:id AND pass=:pass';
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(":id" => $id, ":pass" => $pass));
	$data = $stmt->fetch();
 if($data['pass'] == $pass ){
  	if(@$_POST["number"]){
	$id = $_POST["number"];
	$name = $_POST["name"];
	$comment = $_POST["comment"];
	$sql = 'update mykeiziban set name=:name,comment=:comment where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	echo "投稿番号".$id."番の投稿を編集しました。";		}
 } else {
	echo "パスワードが違います。";
 }
}
//削除
if(!empty($_POST["send_del"])){
	$id = $_POST["delete"];
	$pass = $_POST["pass_del"];
	$sql = 'select * from mykeiziban where id=:id AND pass=:pass';
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(":id" => $id, ":pass" => $pass));
	$data = $stmt->fetch();
if($data['id']==$id and $data['pass']==$pass ){
	$id = $_POST["delete"];
	$pass = $_POST["pass_del"];
	$sql = 'delete from mykeiziban where id=:id AND pass=:pass';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->bindParam(':pass', $pass, PDO::PARAM_INT);
	$stmt->execute();
			echo "投稿番号".$id."番の投稿を削除しました。";
}else{
	echo"パスワードが違います。";
}
}
?>

<form action="mission_5-1.php" method= "post">
自由に投稿お願いします。<br>
名前:
<input type="text" name="name"  value="<?php
					if(isset($_POST["newtext"])){
					echo $newname;
					}
					?>"
					placeholder="名前"><br>
コメント:
<input type="text" name="comment" value="<?php
					if(isset($_POST["newtext"])){
					echo $newcome;
					}
					?>"
					placeholder="コメント"><br>
パスワード:
<input type ="text" name="pass" placeholder="パスワード"><br>
<input type="hidden" name="number" value="<?php
					if(isset($_POST["newtext"])){
					echo $id;
					}
					?>" 
					>
<input type="submit" name="send" value="送信"><br>
<br>
</form>
<form action="mission_5-1.php" method= "post">
編集:
<input type="text" name="newtext" placeholder="編集対象番号">
<input type ="text" name="pass_hensyu" placeholder="パスワード"><br>
<input type="submit" name="send_hensyu" value="編集"><br>
<br>
</form>
<form action="mission_5-1.php" method= "post">
削除:
<input type="text" name="delete" placeholder="削除対象番号"> 
<input type ="text" name="pass_del" placeholder="パスワード"><br>
<input type="submit" name="send_del" value="削除">
</form>
<?php
if(empty($_POST['number']) and empty($_POST['newtext']) and empty($_POST['delete'])){
	if (empty($comment) || empty($name)) {
		echo "名前またはコメントを入力してください"."<br>";
	} else {
		echo $comment . "を受け付けました"."<br>"."<br>";
	$name = $_POST["name"];
	$comment = $_POST["comment"];
	$date = date("Y-m-d H:i:s");
	$pass = $_POST['pass']; 
	$sql = $pdo -> prepare("INSERT INTO mykeiziban (name, comment, date, pass) VALUES ('$name', '$comment','$date','$pass')");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$sql -> execute();
	}
}
///表示

    $sql = "SELECT * FROM mykeiziban";
    $stmt = $pdo->query($sql);
    foreach ($stmt as $row) {
		echo $row['id'].'.';
		echo $row['name'].':';
		echo $row['comment'].'l';
		echo $row['date'].'<br>';
        echo '<br>';
	}
?>
</body>
</html>