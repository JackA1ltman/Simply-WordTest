<?php
class mysql{
    private $account;
    private $password;
    private $address;
    private $database;
    public $statement;
    /**
     * 第一项为账户变量
     * 第二项为密码变量
     * 第三项为数据库IP地址变量
     * 第四项为数据库名称
     * 第五项为执行MySQL语句
    */
    public $allVar = null; //此变量用于对loginMysql函数的指定
    public $run = null;
    private $choicenum;
    public function connect($address,$account,$password,$database){
        $loginMysql=mysqli_connect($this->address=$address,$this->account=$account,$this->password=$password,$this->database=$database);
        $this->allVar=$loginMysql;
        /*这里为设定MySQL连接函数*/
        mysqli_set_charset($loginMysql,"utf8");
        $errorMysql=mysqli_error($loginMysql);
        if($errorMysql){
            echo "<div class='errorMysql' style='color: red'>MySQL提示错误！提示信息为：</div><div class='errorInfMysql'>".$errorMysql."</div>";
            exit;
        }
    }
    /**
     * 这一部分为连接数据库函数
    */
    public function variable($statement){
        $statementMysql=$this->statement=$statement;
        $runMysql=mysqli_query($this->allVar,$statementMysql);
        $errorMysql=mysqli_error($this->allVar);
        if($errorMysql){
            echo "<div class='errorMysql' style='color: red'>MySQL提示错误！提示信息为：</div><div class='errorInfMysql'>".$errorMysql."</div>";
            exit;
        }
        $this->run=$runMysql;
    }
    /**
     * 这一部分是由用户提供MySQL语句的函数
    */
    public function choice($choicenum){
        if($this->choicenum=$choicenum == 1){
            $lastReturn=mysqli_fetch_all($this->run,1);
            mysqli_free_result($this->run);
            return $lastReturn;
        }elseif($this->choicenum=$choicenum == 2){
            $lastReturn=mysqli_fetch_assoc($this->run);
            mysqli_free_result($this->run);
            return $lastReturn;
        }
    }
    /**
     * 这一部分为获取执行MySQL（select）的数据输出
     * 请用于获取二维数组
     * 选项介绍：数值为1时，执行全部数据调用，用于foreach遍历数组等
     * 数值为2时，执行单条数据输出，用于条件判定等
    */
}
?>