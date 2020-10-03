<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php $a = 180?>
<?php $alltasks =0 ?>
<?php if($a == 180 and $alltasks == 1):?>
 <?php echo 'あってます'?>
 <!--<a href="achieve-goals.php"><button>達成！</button></a>-->
<?php else:?>
 <!--<a href="achieve-goals.php" disable><button>達成！</button></a>-->
 <?php echo '間違ってます'?>
<?php endif?>
</body>
</html>

