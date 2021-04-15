<?php
function __autoload($className)
{
    require_once '../nut/class/'.$className.'.class.php';
}
$mysql=new mysql();
$check=new check();
session_start();//开启SESSION
/* 以上用于自动加载类和启用SESSION */
if(empty($_GET)){
    echo "Error!Have no any database!Check your address!";
    exit;
}
/*检测method*/
$connectMysql=$mysql->connect("127.0.0.1","root","root","dict");//连接数据库
$processMysql=$mysql->variable("select english,chinese,id from {$_GET['method']}");//需要执行的SQL语句
$queryMysql=$mysql->choice(1);//展示执行后数组
/* 以上为MySQL的连接以及执行过程 */
$checkLogin=$check->login(1,$_SESSION['username'],$_SESSION['nickname'],$_SESSION['authority']);
/* 登录检测 */
?>
<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
    <? foreach ($queryMysql as $dictDatabase){ ?>
        <input type="text" name="<? echo $dictDatabase['id']?>" autocomplete="off">&nbsp;<? echo $dictDatabase['chinese']?>
        &nbsp;
        <? if($_POST['submit']==1){
            if (isset($_POST)){
                foreach ($_POST as $key=>$value){
                    if($key==$dictDatabase['id']){
                        if($value==$dictDatabase['english']){
                            echo "|&nbsp;&nbsp;";
                            ?>
                            <font color="green"><? echo $dictDatabase['english']; ?></font>
                            <?
                            echo "&nbsp;&nbsp;|&nbsp;&nbsp;";
                            echo "你的答案：";
                            echo $value;
                        }else{
                            echo "|&nbsp;&nbsp;";
                            ?>
                            <font color="red"><? echo $dictDatabase['english']; ?></font>
                            <?
                            echo "&nbsp;&nbsp;|&nbsp;&nbsp;";
                            echo "你的答案：";
                            echo $value;
                        }
                    }
                }
            }
        } ?>
        <br>
    <? } ?>
    <br>
    <button name="submit" value="1">提交</button>
</form>
<div><input type="button" onclick="refresh()" value="点击刷新"><span>注：由于提交模式的关系，需要此按钮进行刷新，请不要使用浏览器刷新</span></div>
</body>
<script>
    function refresh() {
        location.reload();
    }
</script>
</html>
