<?php
function classLoad($className)
{
    $fileLoad = '../nut/class/'.$className.'.class.php';
    if (is_file($fileLoad)) {
        require_once ($fileLoad);
    }
}
spl_autoload_register('classLoad');
require_once '../config.php';
$mysql=new mysql();
$check=new check();
session_start();//开启SESSION
/* 以上用于自动加载类和启用SESSION */
$statusCheck=$check->status();
/* 以上用于检测已登陆状态 */
if(!empty($_POST)){
    $username=$_POST['username'];
    $password=md5($_POST['password']);
    /* 以上为将_POST中的值转化为标准变量 */
    $connectMysql=$mysql->connect(constant("LINK"),constant("USERNAME"),constant("PASSWORD"),constant("NAME"));//连接数据库
    $processMysql=$mysql->variable("select username,password,nickname,authority from account where username='{$username}' and password='{$password}'");//需要执行的SQL语句
    $queryMysql=$mysql->choice(2);//展示执行后数组
    /* 以上为MySQL的连接以及执行过程 */
    if(!$queryMysql){
        echo "<script>alert('账号或密码错误，请修改后重试');history.back();</script>";
    }else{
        $_SESSION['username']=$queryMysql['username'];
        $_SESSION['nickname']=$queryMysql['nickname'];
        $_SESSION['authority']=$queryMysql['authority'];
        $_SESSION['auth']=$queryMysql['authority'];
        /**
         * 传值介绍：
         * 会向_SESSION中增加用户账户，昵称，基于check类的authority值初步检测，还有后台检测所用的auth值
        */
        echo "<script>alert('登陆成功，即将选项页面');location.href='../index.html';</script>";
    }
    /**
     * 检测部分：如果满足条件中的取值错误，则报错
     * 不满足则设定_SESSION数组中增加三组值，用于确定用户身份
    */
}
?>
<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>词语测试-登陆</title>
</head>
<body>
<form action="" method="post">
    账号：<input type="text" name="username"><br>
    密码：<input type="password" name="password"><br>
    <button>提交</button>
</form>
</body>
</html>
