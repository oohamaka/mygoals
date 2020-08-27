<!DOCTYPE html>
<html lang="en">
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
        <h1 class="text-center text-white bg-info">My Goals</h1>  
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
                        <table class="table table-striped table-hover">
                            <tr>
                                <th scope="col">チェックボックス</th>
                                <th scope="col">挑戦中のゴール</th>
                                <th scope="col">達成予定日</th>
                            </tr>
                            <tr><td><input type="checkbox"></td><td><a href="#">テスト1</a></td><td>テスト2</tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h3>終了したゴール</h3>
                        <div class="btn new">
                            <a href="/contact.html" class="btn"><i class="fas fa-trash-alt fa-border fa-2x"></i></a>
                        </div>
                        <table class="table table-striped table-hover">
                            <tr>
                                <th scope="col">チェックボックス</th>
                                <th scope="col">達成したゴール</th>
                                <th scope="col">達成した日</th>
                            </tr>
                            <tr><td><input type="checkbox"></td><td><a href="#">テスト1</a></td><td>テスト2</tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-7">
            <form class="form-horizontal" method="post">
                <div class="form-group">
                    <button type="submit" class="btn btn-info">新しいゴールを追加</button>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">ゴール</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-sm" name="contents">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">いつまでに？</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" name="deadline">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">どうやって？</label>
                    <div class="form-group">
                    <button type="button" class="btn btn-info">タスク行を追加する</button>
                    </div>
                </div>
                <div>

                </div>
                <div class="form-inline">
                    <div class="form-group">
                        <label class="checkbox-inline col-sm-1"><input type="checkbox"></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-sm-4">
                            <input type="date" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-1">
                            <a href="/contact.html" class="btn"><i class="fab fa-twitter-square fa-2x"></i></a>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>    

</body>
</html>

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
//データベースへ登録する関数の作成
function create($dbh, $contents, $deadline) {
    $stmt = $dbh->prepare("INSERT INTO goals(contents,deadline) VALUES(?,?)");
    $data = [];
    $data[] = $contents;
    $data[] = $deadline;
    $stmt->execute($data);
}

if (!empty($_POST)){
    $contents = $_POST['contents'];
    $deadline = $_POST['deadline'];
    create($dbh,$contents,$deadline);
}

$_POST['contents'];
$_POST['deadline'];

var_dump($_POST);

?>