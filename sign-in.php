<?php
session_start();
$errors = [];

function userCreate($dbh,$username,$password){
    $stmt=$dbh->prepare("INSERT INTO users(username,password) VALUES(?,?)");
    $data = [];
    $data[] = $username;
    $data[] = password_hash($password,PASSWORD_DEFAULT);
    $stmt -> execute($data);
}

if(!empty($_POST)){
    if(empty($_POST['username'])){
        $errors[] = '名前を入力してください';
    }
    if(empty($_POST['password'])){
        $errors[] = 'パスワードを入力してください';
    }

    if(empty($errors)){
        userCreate($dbh,$_POST['username'],$_POST['password']);
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include('header.php');?>
    <h1>ユーザー登録</h1>
    <form method="post: action="sign-in.php>
     <input type="text" name="username">
     <input type="text" name="password"> 
    </form>

    
</body>
</html>