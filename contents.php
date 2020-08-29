<?php
//取ってくるgoal_idをパラメータとして受け取る。
//データベースからデータを取得
ini_set('display_errors',"on");//エラーを画面に出力
//ホスト名、DB名、ユーザ名、パスワード、ポートを定義
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'mygoals');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_PORT', '8889');


$goal_id = $_GET['id'];
//var_dump($goal_id);

try{
    $dbh = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo $e->getMessage();
    exit;
}

function select($dbh,$goal_id) {
    $stmt = $dbh->prepare('SELECT * FROM goals where id = :id');
    $stmt->bindParam(':id',$goal_id,PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function select_tasks($dbh,$goal_id){
    $stmt = $dbh->prepare('SELECT done,contents,deadline FROM tasks where goal_id = :goal_id');
    $stmt->bindParam(':goal_id',$goal_id,PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$select = select($dbh,$goal_id);
$select_tasks = select_tasks($dbh,$goal_id);
//var_dump($select);
//var_dump($select_tasks);

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
  <p type="text" class="form-control input-sm" name="goals_contents"><?php echo $select['contents']?></P>
 </div>
</div>
<div class="form-group">
 <label class="col-sm-3 control-label">いつまでに？</label>
 <div class="col-sm-9">
  <p type="date" class="form-control" name="goals_deadline"><?php echo $select['deadline']?></p>
 </div>
 </div>
 <div class="form-group">
  <label class="col-sm-3 control-label">どうやって？</label>
  <div class="form-group">
  </div>
 </div>
 <div class="row" >
    <?php foreach($select_tasks as $singletasks):?>
    <div class="form-group col-sm-2">
      <button type="submit" class="btn btn-info" onclick="changeUnderline('target')">完了！</button>
    </div>
    <div class="col-sm-5">
     <label type="text" class="form-control input-sm"><?php echo $singletasks['contents']?></label>
    </div>
    <div class="col-sm-4">
     <label type="text" class="form-control"><?php echo $singletasks['deadline']?></label>
    </div>
    <?php endforeach?>
 </div>
<button onclick='history.back()' class="btn btn-info">前のページに戻る</button>
<script>
function changeUnderline(){
  var obj = document.querySelector('row');
  if(obj.style.textDecoration == "line-through"){
    obj.style.textDecoration = "none";
  }else{
    obj.style.textDecoration = "line-through";
  }
}
</script>
</body>
</html>