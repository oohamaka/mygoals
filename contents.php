<?php
include 'includes.php';
session_start();
if (!$_SESSION["login"]) {
  header('Location: login.php');
  exit;
}
else{
    echo $user['auth_id'] ;
}
$user = $_SESSION['user'];
$user_id = $user['id'];

$done = $_GET['done'];
$returnId = $_GET['id'];
//取ってくるgoal_idをパラメータとして受け取る。
$goal_id=$_GET['id'];
$delete_id=$_POST['delete'];

require_once("database.php");

//goalをDBから取得
function select($dbh,$goal_id) {
    $stmt = $dbh->prepare('SELECT * FROM goals where id = :id');
    $stmt->bindParam(':id',$goal_id,PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
//taskをDBから取得,取得したgoalとidが一致するもの
function select_tasks($dbh,$goal_id){
    $stmt = $dbh->prepare('SELECT * FROM tasks where goal_id = :goal_id');
    $stmt->bindParam(':goal_id',$goal_id,PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//データベースのtasksを登録する関数の作成
function create_tasks($dbh,$goal_id,$task_contents,$task_deadline,$task_done,$user_id){
  $stmt = $dbh->prepare("INSERT INTO tasks(goal_id,contents,deadline,done,user_id) VALUES(?,?,?,?,?)");
  $task_data = [];
  $task_data[] = $goal_id;
  $task_data[] = $task_contents;
  $task_data[] = $task_deadline;
  $task_data[] = $task_done;
  $task_data[] = $user_id;
 $stmt->execute($task_data);
}

//テーブルから,チェックしたレコードを削除する
function delete_tasks($dbh,$goal_id,$task_contents,$task_deadline,$task_done,$user_id){
  $stmt = $dbh->prepare('DELETE FROM tasks where id=:delete_id');
  $delete_data = [];
  $delete_data = $goal_id;
  $delete_data = $task_contents;
  $delete_data = $task_deadline;
  $delete_data = $task_done;
  $delete_data = $user_id;
  $stmt->execute();
  echo '削除しました';
}

//「ゴール達成」ボタンをゴールのdoneにより表示・非表示を変える or 押せる・押せないにする
//DBのtask tableから全てのタスクのdoneを取得
//全てのタスクでdone=1なら、ボタン押せる（表示にする）
//そうでないならボタンを押せない（非表示にする）

$select = select($dbh,$goal_id);
$select_tasks = select_tasks($dbh,$goal_id);
//$delete_tasks = delete_tasks($dbh,$id,$goal_id,$task_contents,$task_deadline,$task_done,$user_id);
if(!empty($_POST)){
for($i = 0;count($_POST['task_contents']) > $i ; $i++){//postされるtask_contentsの数（count関数)で判断
  if(!empty($_POST['task_contents'][$i])){
    $create_tasks = create_tasks($dbh,$goal_id,$_POST['task_contents'][$i],$_POST['task_deadline'][$i],$_POST['task_done'][$i],$user_id);
    }
  }
}
//var_dump($_POST);
//var_dump($create_tasks);
var_dump($delete_tasks);
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
  <h5 class="text-right mr-4"><?php echo $user['auth_id'].'さんログイン中' ?></h5>
</header>
<div class="form-group">
<label class="col-sm-3 control-label">ゴール</label>
<div class='row'>
 <div class="col-sm-6">
  <p class="form-control input-sm m-3"><?php echo $select['contents']?></P>
 </div>
 <div class="col-sm-3">
 <!--ゴール達成ボタンを機能させる-->
 <!--合計タスク数を求める-->
 <?php $select_tasks = select_tasks($dbh,$goal_id);?>
 <?php $countTasks = count($select_tasks);?>
 <!--doneの合計を求める-->
 <?php foreach($select_tasks as $singletasks):?>
  <?php $sumSingleTasks += $singletasks['done'];?>
 <?php endforeach?>
 <!--doneの合計と合計task数を突合し、合えばゴール達成、あっていなければ未達成の判断-->
 <!--<?php for($i = 0;$i < $countTasks;$i++):?>-->
 <!-- <?php $totalTaskDone = $totalTaskDone + 1;?>-->
 <!--<?php endfor;?>-->
<?php if($select['done']==0):?>
  <?php if($sumSingleTasks == $countTasks):?>
    <form action="achieve-goals.php" method="post" >
      <button class="btn btn-info js-done" name="done" value="1" type="submit">
        ゴール達成！
      </button>
      <input type="hidden" name="goal_id" value="<?php echo $goal_id;?>">
    </form>
    <?php else:?>
      <button class="btn btn-info js-done" onclick="document.location.href='achieve-goals.php'" disabled>
        ゴール達成！
      </button>
    <?php endif;?>
<?php endif;?>
 </div>

 <!--<div class="col-sm-3">
  <button class="btn btn-info js-done">twitterにUp!</button>
 </div>-->
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
<div class="form-group">
 <button type="button" class="btn btn-info col-sm-2 mx-3" onclick="clickBtn1()">入力行を追加する</button>                    
 <button type="button" class="btn btn-danger col-sm-2 mx-3" onclick="clickBtn2()">入力行を削除する</button>
</div>
<form class="form-horizontal" method="post">
  <button type="submit" class="btn btn-info col-sm-2 mx-3">新しいタスクを追加登録する</button>
  <input type="hidden" name="task_done[]" value="0">
  <button type="submit" name="delete[]" class="btn btn-danger col-sm-2 mx-3">チェックしたタスクを削除する</button>
  <div id="container"></div>
</form>

<template id="template">
  <div class="form-inline">
    <div class="form-group">
      <!--<label class="checkbox-inline col-sm-1"><input type="checkbox"></label>
       <input type="hidden" name="task_done[]" value="0">-->
      <div class="col-sm-6">
       <input type="text" class="form-control" name="task_contents[]">
      </div>
      <div class="col-sm-4">
       <input type="date" class="form-control" name="task_deadline[]">
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-1">
        <a href="/contact.html" class="btn"><i class="fab fa-twitter-square fa-2x"></i></a>
      </div>
    </div>
  </div>
</template>
<!--<form class="form-horizontal" method="post">
  <button type="submit" class="btn btn-info">タスクを追加する</button> 
  <div id="container"></div>
  <div class="form-group">
    <button type="button" class="btn btn-info" onclick="clickBtn2()">タスク行を削除する</button>
  </div>
</form>-->
 <div class="row" >
  <?php foreach($select_tasks as $singletasks):?>
   <div class="form-group col-sm-10 item">
    <form method="post" action="task-done-control.php?id=<?php echo $singletasks['id'] ?>">
          <p id="result"></p>
      <?php if($singletasks['done']):?>
        <button type="submit" class="btn btn-info js-done m-3"  id="button1" name="done" value="1" disabled>完了！</button>
        <button type="submit" class="btn btn-info js-done m-3"  id="button2" name="done" value="0">やっぱりまだでした</button>
        <button type="button" class="btn btn-info m-3">twitterにUp!</button>
        <div class="row">
          <div class="checkbox">
            <label class="checkbox-inline col-sm-1 ml-3"><input type="checkbox" name="delete[]"></label>
          </div>
          <div class="form-group col-sm-5">
            <label type="text" class="form-control  input-sm task mx-3" style="text-decoration:line-through">
              <?php echo $singletasks['contents']?>
            </label>
          </div>
          <div class="form-group col-sm-5">
            <label type="text" class="form-control  deadline mx-3" style="text-decoration:line-through">                
          <?php echo $singletasks['deadline']?>
            </label>
          </div>
        </div>
      <?php else:?>
        <button type="submit" class="btn btn-info js-done m-3"  id="button1" name="done" value="1">完了！</button>
        <button type="submit" class="btn btn-info js-done m-3"  id="button2" name="done" value="0" disabled>やっぱりまだでした</button>
        <button type="button" class="btn btn-info m-3">twitterにUp!</button>
        <div class="row">
         <div class="checkbox">
          <label class="checkbox-inline col-sm-1 ml-3"><input type="checkbox" name="delete_task_id"></label>
         </div>
         <div class="form-group col-sm-5">
          <label type="text" class="form-control  input-sm task mx-3" value="0" style="text-decoration:none">
          <?php echo $singletasks['contents']?>
          </label>
         </div>
         <div class="form-group col-sm-5">
          <label type="text" class="form-control  deadline mx-3" value="0" style="text-decoration:none">
          <?php echo $singletasks['deadline']?>
          </label>
         </div>
        </div>
      <?php endif?>         
      </form>
     </div>
    <?php endforeach?>
 </div>
  <button onclick="document.location.href='r-index.php'" class="btn btn-info m-3">前のページに戻る</button>

<script>
    $(function(){
      $("#checkbox").on("click",function(){
        var v = $(this).val();
        sessionStorage.setItem('key',v);
      });
    })
    $(function(){
      var d = sessionStorage.getItem('key');
      $('#result').text(d);
    })
</script>
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
<script>
  function clickBtn1(){
  // template要素を取得
     var template = document.querySelector('template');
  //template要素の内容を複製
     var clone = template.content.cloneNode(true);
  // div#containerの中に追加
     document.getElementById('container').appendChild(clone);
   }
   function clickBtn2(){
    // 要素の削除
     const container = document.getElementById('container');//145行目を取得
     const last_child = container.querySelector(".form-inline:last-child");
     console.log(last_child);
     document.getElementById('container').removeChild(last_child);
   //最後の要素を取って消すのもあり。
   }

</script>
</body>
</html>