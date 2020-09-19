<?php
session_start();
require_once("database.php");

$errors = [];

$query = $dbh->prepare("select auth_id from users where auth_id = :auth_id limit 1");
$query->execute(array(':auth_id' => $auth_id));
$result = $query->fetch(PDO::FETCH_ASSOC);
var_dump($result);

function userCreate($dbh,$auth_id,$password){
    $stmt=$dbh->prepare("INSERT INTO users(auth_id,password) VALUES(?,?)");
    //ALTER TABLE users MODIFY COLUMN email VARCHAR(150) UNIQUE KEY;
    $data = [];
    $data[] = $auth_id;
    $data[] = password_hash($password,PASSWORD_DEFAULT);
    $stmt -> execute($data);
}


if(!empty($_POST)){
    if(empty($_POST['auth_id'])){
        $errors[] = '名前を入力してください';
    }
    if(empty($_POST['password'])){
        $errors[] = 'パスワードを入力してください';
    }
    if($result === $_POST['auth_id'] ){
        $errors[] = "このIDはすでに使われています。";
    }else{
    if(empty($errors)){
        userCreate($dbh,$_POST['auth_id'],$_POST['password']);
    }
}
}


?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Sawarabi+Gothic&display=swap" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- font-family: 'Sawarabi Gothic', sans-serif; -->
    <title>mygoals</title>
        <!-- BootstrapのCSS読み込み -->
        <!-- jQuery読み込み -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- BootstrapのJS読み込み -->
        <script src="js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<header>
    <?php include 'header.php'; ?>
</header>
<body>

    <h2 class="text-center">ユーザー登録</h2>
    <?php if(!empty($errors)):?>
     <ul>
      <?php foreach($errors as $error):?>
        <li><?php echo $error;?></li>
      <?php endforeach?>
     </ul>
    <?php endif?>
    <form method="post" action="sign-in.php">
     <p class="text-center">※任意のユーザーID、パスワードを登録してください。</p>
     <P class="text-center">※パスワードは、数字、小文字、大文字を組み合わせて設定してください。</p>
     <label for="exampleInputName" class="col-sm-5 text-center">ユーザーID</label>
     <input class="col-sm-5 "type="text" name="auth_id" id="exampleInputName" placeholder="名前" required>
     <label for="exampleInputPassword" class="col-sm-5 text-center">パスワード</label>
     <input class="col-sm-5" type="password" name="password" id="exampleInputPassword" placeholder="パスワード" required>
     <div class="row">
        <div class="col-sm-4"></div>
        <button type="submit" class="col-sm-4 btn btn-info mt-5">登録</button>
        <div class="col-sm-4"></div>
      </div>
    </form>
</body>
</html>