<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Sawarabi+Gothic&display=swap" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="style.css" rel='stylesheet'>
    <!-- font-family: 'Sawarabi Gothic', sans-serif; -->
    <title>mygoals</title>
        <!-- BootstrapのCSS読み込み -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- jQuery読み込み -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- BootstrapのJS読み込み -->
        <script src="js/bootstrap.min.js"></script>
</head>
<body>
    <header>
        <h1>My Goals</h1>  
    </header>
    <div class="main-content">
        <aside>    

            <div class="new-button">
                <a href="/contact.html" class="add"><i class="fas fa-plus fa-border fa-2x"></i>	</a>
            </div>
            <section class="goal-list">
                <table width="400" height="150">
                    <tr> 
                        <th width="20%"></th>
                        <th width="40%">設定したゴール</th>
                        <th width="40%">達成予定日</th>
                    </tr>
                    <tr>
                        <th width="20%">○</th>
                        <th width="45%">タスク管理アプリの作成</th>
                        <th width="35%">2020/11/30</th>
                    </tr>
                </table>
                <div class="delete-button">	
                    <a href="/contact.html" class="btn"><i class="fas fa-trash-alt fa-border fa-2x"></i></a>
                </div>
                <div class="border">
                </div>
            </section>
            <section class="complete-list">
                <table width="400" height="150">
                    <tr> 
                        <th width="20%"></th>
                        <th width="40%">達成したゴール</th>
                        <th width="40%">達成日</th>
                    </tr>
                    <tr>
                        <th width="20%">○</th>
                        <th width="45%">タスク管理アプリの作成</th>
                        <th width="35%">2020/11/30</th>
                    </tr>
                </table>
            </section>
        </aside>
        <main>
            <div class="goals">
                <h2>ゴール<input type="text" methdo="post"></input></h2>
                <i class="fab fa-twitter-square fa-2x"></i>
            </div>
            <div class="goals">
                <h2>いつまでに？<input type="date" methdo="post"></input></h2>
                <i class="fab fa-twitter-square fa-2x"></i>
            </div>
            <h3>どうやって？</h3>
            <div class="how_to">
                    <input class="checkbox" type='checkbox'></input>
                    <input type="text" methdo="post"></input>         
                <div class="date">
                    <input type='date' method="post">
                </div>
                <i class="fab fa-twitter-square fa-2x"></i>
            </div>
        </main>
    </div>

</body>
</html>