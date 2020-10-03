<?php

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
</head>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <div class="container">
     <h1>まずは下記登録をお願いします。</h1>
    </div>
     <div class="container-fluid">
      <div class="form-group col-md-6">
       <label for="name">ログインID</label>
       <input type="text" class="form-control" placeholder="ログインIDを入力">
      </div>
      <div class="form-group">
       <label for="email1">メールアドレス</label>
       <input type="email" class="form-control" id="email1" aria-describedby="emailhelp" placehodler="メールアドレスを入力">
      </div>
      <div class="form-group">
       <label for="password">パスワード</label>
       <input type="password" class="form-control" placehodler="パスワードを入力">
      </div>
    </div>



