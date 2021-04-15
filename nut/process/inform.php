<?php
session_start();
$exitCode=$_GET['exit'];
if($exitCode == 1){
    unset($_SESSION['username']);
    unset($_SESSION['nickname']);
    unset($_SESSION['auth']);
    unset($_SESSION['authority']);
    echo "<script>alert('您已退出，欢迎使用本系统！');</script>！";
    echo "<script>location.href='../../index.html';</script>";
    exit;
}
/**
 * 这里为数据提交处理页，仅能用于处理，不可直接访问
*/
?>