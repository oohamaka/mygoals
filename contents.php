<?php
$returnId = $_GET['id'];
//取ってくるgoal_idをパラメータとして受け取る。
$goal_id=$_GET['id'];
//データベースからデータを取得
ini_set('display_errors',"on");//エラーを画面に出力
//ホスト名、DB名、ユーザ名、パスワード、ポートを定義
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'mygoals');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_PORT', '8889');

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
    $stmt = $dbh->prepare('SELECT id,done,contents,deadline FROM tasks where goal_id = :goal_id');
    $stmt->bindParam(':goal_id',$goal_id,PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$select = select($dbh,$goal_id);
$select_tasks = select_tasks($dbh,$goal_id);

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
<div class='row'>
 <div class="col-sm-6">
  <p class="form-control input-sm m-3"><?php echo $select['contents']?></P>
 </div>
 <div class="col-sm-3">
  <button class="btn btn-info js-done" onclick="document.location.href='achieve-goals.php'">ゴール達成！</button>
 </div>
 <div class="col-sm-3">
  <button class="btn btn-info js-done">TwitterにUp!</button>
 </div>
</div>
</div>
<div class="form-group">
 <label class="col-sm-3 control-label">いつまでに？</label>
 <div class="col-sm-6">
  <p class="form-control m-3"><?php echo $select['deadline']?></p>
 </div>
</div>
<div class="form-group">
 <label class="col-sm-3 control-label">どうやって？</label>
</div>
 <div class="row" >
    <?php foreach($select_tasks as $singletasks):?>
     <div class="form-group col-sm-10 item">
      <form method="post" action="done-control.php?id=<?php echo $singletasks['id'] ?>">
        <input type="hidden" name="done" value="1">
        <button type="submit" class="btn btn-info js-done m-3" onclick="changeUnderline()">完了！</button>
        <button type="button" class="btn btn-info m-3">TwitterにUp!</button>
        <label type="text" class="form-control input-sm task mx-3"><?php echo $singletasks['contents']?></label>
        <label type="text" class="form-control deadline mx-3"><?php echo $singletasks['deadline']?></label>      
      </form>
     </div>
    <?php endforeach?>
 </div>
  <button onclick="document.location.href='r-index.php'"  class="btn btn-info m-3">前のページに戻る</button>
<!--
<script>
function changeUnderline(){
  var obj = document.querySelector('.target');
  if(obj.style.textDecoration == "line-through"){
    obj.style.textDecoration = "none";
  }else{
    obj.style.textDecoration = "line-through";
  }
}

-->
<script>
  const doneList = document.querySelectorAll(".js-done")//クラス"JS-done"を取得
  doneList.forEach(function(done){
  done.addEventListener('click',function(elem){
    const parentItem = elem.target.parentElement;
    const task = parentItem.querySelector(".task");
    const deadline = parentItem.querySelector(".deadline");
      if(task.style.textDecoration == "line-through"){
        task.style.textDecoration = "none";
        deadline.style.textDecoration = 'none';
        }else{
        task.style.textDecoration = "line-through";
        deadline.style.textDecoration = 'line-through';
      }
   });
 });
</script>
</body>
</html>