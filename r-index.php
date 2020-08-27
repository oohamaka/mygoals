<?php
ini_set('display_errors',"on");//エラーを画面に出力
//ホスト名、DB名、ユーザ名、パスワード、ポートを定義
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'mygoals');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_PORT', '8889');

//データベースへ接続
try{
    $dbh = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo $e->getMessage();
    exit;
}
//データベースへmygoalを登録する関数の作成
function create($dbh, $contents, $deadline) {
    $stmt = $dbh->prepare("INSERT INTO goals(contents,deadline) VALUES(?,?)");
    $data = [];
    $data[] = $contents;
    $data[] = $deadline;
    $stmt->execute($data);
    return $dbh->lastInsertId();
}
//データベースのtasksを登録する関数の作成
function create_tasks($dbh,$goal_id,$task_contents,$task_deadline,$task_done){
    $stmt = $dbh->prepare("INSERT INTO tasks(goal_id,contents,deadline,done) VALUES(?,?,?,?)");
    $task_data = [];
    $task_data[] = $goal_id;
    $task_data[] = $task_contents;
    $task_data[] = $task_deadline;
    $task_data[] = $task_done;
    $stmt->execute($task_data);
}

// データベースからデータを取得する   
function selectAll($dbh) {
    $stmt = $dbh->prepare('SELECT * FROM goals ORDER BY updated_at DESC');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function selectAlltasks($dbh) {
    $stmt = $dbh->prepare('SELECT * FROM tasks ORDER BY updated_at DESC');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


$result = selectAll($dbh);
$result_tasks = selectAll($dbh);

if (!empty($_POST)){
    $contents = $_POST['goals_contents'];
    $deadline = $_POST['goals_deadline'];
    $goal_id = create($dbh,$contents,$deadline);
    $contents = $_POST['task_contents'];
    $deadline = $_POST['task_deadline'];
    $done = $_POST['task_done'];
    for($i = 0;count($_POST['task_contents']) > $i ; $i++){
        create_tasks($dbh,$goal_id,$_POST['task_contents'][$i],$_POST['task_deadline'][$i],$_POST['task_done'][$i]);
        //var_dump($_POST['task_contents'][$i]);
    }
}
//データベースからデータを取得
function select($dbh,$id) {
    $stmt = $dbh->prepare('SELECT * FROM goals where id = :id');
    $stmt->bindParam(':id',$id,PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
try{
    echo select($dbh,$id);
}
catch(Exception $e){
    print'ただいま障害によりご迷惑をおかけしております。';
    exit();
}
$select = select($dbh,$id);
echo $select;
var_dump($select);

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
    <div class="container-fluid">
     <div class="row">
      <div class="col-sm-5">
       <div class="row">
        <div class="col-12">
         <h3>挑戦中のゴール</h3>
         <div>
          <a href="index.html" class="add"><i class="fas fa-plus fa-border fa-2x"></i></a>
         </div>
          <table id="target-table" class="table table-striped table-hover">
            <tr>
              <th scope="col">チェックボックス</th>
              <th scope="col">挑戦中のゴール</th>
              <th scope="col">達成予定日</th>
            </tr>                          
              <?php foreach($select as $rec):?>
            <tr>
              <td><input type="checkbox"></td>
              <td><a href="content.php?id=<?php echo $rec['id'] ?>"><?php echo $rec['contents'] ?></a></td>
              <td><?php echo $rec["deadline"]?></td>
            </tr>
              <?php endforeach ?> 
            </tr>                   
          </table>
        </div>
      </div>
         <div class="row">
          <div class="col-12">
            <h3>終了したゴール</h3>
            <div class="btn new">
             <a href="/contact.html" class="btn"><i class="fas fa-trash-alt fa-border fa-2x"></i></a>
              </div>
                <table class="table table-striped table-hover" id='target-table'>
                  <tr>
                    <th scope="col">チェックボックス</th>
                    <th scope="col">達成したゴール</th>
                    <th scope="col">達成した日</th>
                  </tr>
                  <tr class="row"><td><input type="checkbox"></td><td><a href="#">テスト1</a></td><td>テスト2</tr>
                </table>
          </div>
         </div>
      </div>
            <div class="col-sm-7">
            <form class="form-horizontal" method="post">
                <div class="form-group">
                    <button type="submit" class="btn btn-info" onclick="clickBtn3()">新しいゴールを追加</button>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">ゴール</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-sm" name="goals_contents">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">いつまでに？</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" name="goals_deadline">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">どうやって？</label>
                    <div class="form-group">
                        <button type="button" class="btn btn-info " onclick="clickBtn1()">タスク行を追加する</button>                    
                        <button type="button" class="btn btn-info">チェックを入れたタスク行を削除する</button>
                    </div>
                </div>
                <div>
                </div>
                <template id="template">
                    <div class="form-inline">
                        <div class="form-group">
                            <label class="checkbox-inline col-sm-1"><input type="checkbox"></label>
                            <input type="hidden" name="task_done[]" value="0">
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
                <div id="container"></div>
                    <div class="form-group">
                        <button type="button" class="btn btn-info" onclick="clickBtn2()">タスク行を削除する</button>
                    </div>
                <!--ボタンの制御-->
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
                            var deleted = document.getElementById('template');
                            var cloned = template.content.cloneNode(true);
                            document.getElementById('container').removeChild(cloned);
                    }
                </script>
            </form>
            </div>
        </div>
    </div>    

</body>
</html>

