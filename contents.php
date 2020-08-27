<?php
//取ってくるgoal_idをパラメータとして受け取る。

//DBへ接続
ini_set('display_errors',"on");//エラーを画面に出力
//ホスト名、DB名、ユーザ名、パスワード、ポートを定義
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'mygoals');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_PORT', '8889');

try{
    $dbh = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo $e->getMessage();
    exit;
}

// データベースからデータを取得する   
function select($dbh,$id) {
    $stmt = $dbh->prepare('SELECT * FROM goals where id = :id');
    $stmt->bindParam(':id',$id,PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
$result = select($dbh,$id);
//goal_idでDBからデータを抽出、表示する。
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
<div class="form-group">
<label class="col-sm-3 control-label">ゴール</label>
 <div class="col-sm-9">
  <p type="text" class="form-control input-sm" name="goals_contents"><?php ?></P> <!--ここでゴールを出力-->
 </div>
</div>
<div class="form-group">
 <label class="col-sm-3 control-label">いつまでに？</label>
 <div class="col-sm-9">
  <label type="text" class="form-control" name="goals_deadline">
 </div>
 </div>
 <div class="form-group">
  <label class="col-sm-3 control-label">どうやって？</label>
  <div class="form-group">
  </div>
 </div>
 <div class="row">
    <div class="col-sm-6 mx-3">
    <label type="text" class="form-control input-sm" name="goals_contents">
    </div>
    <div class="col-sm-4">
    <label type="text" class="form-control" name="task_deadline[]">
    </div>
 </div>



</body>
</html>