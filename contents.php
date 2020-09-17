<?php
$done= $_GET['done'];
$returnId = $_GET['id'];
//取ってくるgoal_idをパラメータとして受け取る。
$goal_id=$_GET['id'];
//var_dump($goal_id);

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
    $stmt = $dbh->prepare('SELECT id,done,contents,deadline FROM tasks where goal_id = :goal_id');
    $stmt->bindParam(':goal_id',$goal_id,PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
//「ゴール達成」ボタンをゴールのdoneにより表示・非表示を変える or 押せる・押せないにする
//DBのtask tableから全てのタスクのdoneを取得
//全てのタスクでdone=1なら、ボタン押せる（表示にする）
//そうでないならボタンを押せない（非表示にする）


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
  <button class="btn btn-info js-done" onclick="document.location.href='achieve-goals.php'" method="post">
    ゴール達成！
  </button>
 </div>
 <div class="col-sm-3">
  <button class="btn btn-info js-done">twitterにUp!</button>
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
      <form method="post" action="task-done-control.php?id=<?php echo $singletasks['id'] ?>">
        <input type="hidden" name="done" value="1">
        <!--<label>
        <//?php if($singletasks['done']):?>
          <input type="checkbox" id="checkbox" value="1" name="done" checked>
         </?php else:?>
          <input type="checkbox" id="checkbox" value="1" name="done">
        <//?php endif?>
        </label>
          <button type="submit" class="btn btn-info js-done m-3">
          完了（仮）!
          </button>-->
          <p id="result"></p>
        <!--</label>-->
        <button type="submit" class="btn btn-info js-done m-3" onclick="func1()" id="button1">完了！</button>
        <button type="submit" class="btn btn-info js-done m-3" onclick='func2()' id="button2">やっぱりまだでした</button>
        <button type="button" class="btn btn-info m-3">twitterにUp!</button>
        <?php if($singletasks['done']):?>
          <label type="text" class="form-control input-sm task mx-3" style="text-decoration:line-through" name="done" value="1">
            <?php echo $singletasks['contents']?>
          </label>
          <label type="text" class="form-control deadline mx-3" style="text-decoration:line-through" name="done" value="1">
            <?php echo $singletasks['deadline']?>
          </label>
        <?php else:?>
          <label type="text" class="form-control input-sm task mx-3" value="0"name="done" style="text-decoration:none">
           <?php echo $singletasks['contents']?>
          </label>
          <label type="text" class="form-control deadline mx-3" value="0"name="done" style="text-decoration:none">
           <?php echo $singletasks['deadline']?>
          </label>
        <?php endif?>
               
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
 function func1(){
    document.getElementById("button1").disabled = true;
    document.getElementById("button2").disabled = false;
  }

  function func2(){
    document.getElementById("button1").disabled = false;
    document.getElementById("button2").disabled = true;
  }
</script>

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
</body>
</html>