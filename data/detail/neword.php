<?php
function __autoload($className)
{
    require_once '../../nut/class/'.$className.'.class.php';
}
$mysql=new mysql();
$check=new check();
session_start();//开启SESSION
/* 以上用于自动加载类和启用SESSION */
if($_SESSION['auth'] == 1 or $_SESSION['auth'] == 2){
    if($_POST['submit']==3){
        if(empty($_POST['english']) or empty($_POST['chinese']) or empty($_POST['english'] and $_POST['chinese'])){
            echo "<script>alert('请完整输入需要添加的词语！');</script>";
            if (count($_POST) > 0) {
                $_POST = array();
            }
            /* 这部分检测单词是否为空 */
        }else{
            $getWord=$_POST['english'];
            $connectMysql=$mysql->connect("127.0.0.1","root","root","dict");//连接数据库
            $processMysql=$mysql->variable("select english from {$_GET['method']} where english like '$getWord'");//需要执行的SQL语句 - 查询数据库用于对比
            $queryMysql=$mysql->choice(1);//展示执行后数组
            if($queryMysql[0]['english'] == $_POST['english']){
                echo "<script>alert('添加的词语重复！');</script>";
                if (count($_POST) > 0) {
                    $_POST = array();
                }
                echo "<script>history.back();</script>";
                /* 单词存在语义重复的问题，所以不检测中文语义重复 */
            }else{
                $getEnglishWord=$_POST['english'];$getChineseWord=$_POST['chinese'];
                $processMysql=$mysql->variable("insert into {$_GET['method']} (english,chinese) values ('$getEnglishWord','$getChineseWord')");//需要执行的SQL语句 - 插入新词条
                echo "<script>alert('添加成功！');</script>";
                if (count($_POST) > 0) {
                    $_POST = array();
                }
                echo "<script>location.href='neword.php';</script>";
            }
        }
    }
    /* 以上为MySQL的连接以及执行过程 */
    /**
     * 当submit值为3时，则执行
     * 第一轮先检测是否提交空值，如果不为空，则继续执行
     * 第二轮先与数据库对比，如果英文单词相同，则阻止添加
     * 当第二轮对比通过后则执行添加工作
    */
}elseif($_SESSION['username'] == null or $_SESSION['username'] == ""){
    echo "<script>alert('后台管理请先登陆！');</script>";
    echo "<script>location.href='../login.php';</script>";
    exit;
}else{
    echo "<script>alert('非授权用户无法访问后台！');</script>";
    echo "<script>history.back();</script>";
    exit;
}
/**
 * 三级判断介绍：
 * 第一层为_SESSION中auth值为1（最高权限）或2（中等权限），则放行
 * 第二层为检测_SESSION中username（用户账户）为空，则提示用户登录账户
 * 第三层为auth值不为1，则阻止进入
 */
?>
<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>词语测试-单词添加系统</title>
</head>
<body>
<div>欢迎你，<? echo $_SESSION['nickname']?>！</div><a href='../../nut/process/inform.php?exit=1'><button>退出</button></a>
<br>
<div>
    <form action="" method="post">
        单词英文：<input type="text" name="english"><br>
        单词中文：<input type="text" name="chinese"><br>
        <button name="submit" value="3">提交</button>
    </form>
    <div><input type="button" onclick="refresh()" value="点击刷新"><span>注：由于提交模式的关系，需要此按钮进行刷新，请不要使用浏览器刷新</span></div>
</div>
</body>
<script>
    function refresh() {
        document.location.href="neword.php";
    }
</script>
</html>
