<?php
function __autoload($className)
{
    require_once '../../nut/class/'.$className.'.class.php';
}
$mysql=new mysql();
$check=new check();
session_start();//开启SESSION
/* 以上用于自动加载类和启用SESSION */
if($_SESSION['auth'] == 1){
    $connectMysql=$mysql->connect("127.0.0.1","root","root","dict");//连接数据库
    $processMysql=$mysql->variable("select id,english,chinese from {$_GET['method']}");//需要执行的SQL语句
    $queryMysql=$mysql->choice(1);//展示执行后数组
    /* 以上为MySQL的连接以及执行过程 */
    if(isset($_GET)){
        if(isset($_GET['del'])){
            $getRequire=$_GET['del'];
            $processMysql=$mysql->variable("delete from {$_GET['method']} where id='$getRequire'");//需要执行的SQL语句 - 删除指定ID词语
            echo "<script>alert('词语删除成功！');</script>";
            /*前部分必要执行内容*/
            $processMysql=$mysql->variable("alter table {$_GET['method']} drop id;");//需要执行的SQL语句 - 删除原ID列
            $processMysql=$mysql->variable("ALTER TABLE {$_GET['method']} ADD id INT NOT NULL PRIMARY KEY AUTO_INCREMENT FIRST;");//需要执行的SQL语句 - 修改ID计算方式
            if (count($_REQUEST) > 0) {
                $_GET = array();
            }
            /*后部分修正ID计算顺序*/
            echo "<script>location.reload();</script>";
        }
    }
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
 * 第一层为_SESSION中auth值为1（最高权限），则放行
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
    <title>词语测试-后台管理系统</title>
</head>
<body>
<div>欢迎你，<? echo $_SESSION['nickname']?>！</div><a href='../../nut/process/inform.php?exit=1'><button>退出</button></a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>英语</th>
        <th>汉语</th>
        <th>选项</th>
    </tr>
    <? foreach ($queryMysql as $dict) { ?>
        <tr>
            <td><? echo $dict['id']; ?></td>
            <td><? echo $dict['english']; ?></td>
            <td><? echo $dict['chinese']; ?></td>
            <td><a href="manager.php?del=<? echo $dict['id']; ?>"><button>删除</button></a><a href="../../nut/reviser.php?mod=<? echo $dict['id']; ?>&method=<? echo $_GET['method']; ?>"><button>修改</button></a></td>
        </tr>
    <? } ?>
</table>
</body>
</html>
