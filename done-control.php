<?php
var_dump($_GET);
var_dump($_POST);
$taskDone = $_POST['done'];
$taskId = $_GET['id'];
//doneをパラメータとして受け取る。
//データベースからデータを取得
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

//databaseのtable'tasks'に、doneの値を登録する関数の作成
function updateDone($dbh,$done,$id) {
    $stmt = $dbh->prepare("UPDATE tasks SET done=? where id=?");
    $data = [];
    $data[] = $done;
    $data[] = $id;
    $stmt->execute($data);
    return $dbh->lastInsertId();
}

$updateDone = updateDone($dbh, $taskDone, $taskId);
$server = $_SERVER['HTTP_REFERER'];
var_dump($server);
header( "Location:$server");

?>

<!--<script>
    var request = new XMLHttpRequest();
    request.open('GET', URL, true);
    request.responseType = 'int';
    request.addEventListener('load', function (response) {
    // JSONデータを受信した後の処理
    });
    request.send();
</script>-->
