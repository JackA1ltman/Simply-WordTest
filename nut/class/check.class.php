<?php
class check{
    /**
     * 此class用于二次验证，一次验证通过后即可进行二次验证确认身份
    */
    private $username;
    private $nickname;
    private $authority;
    protected $method;
    /**
     * 第一项用户账户
     * 第二项用户密码
     * 第三项用户昵称
     * 第四项验证用户权限码
     * 第五项后台状态验证码
    */
    public function login($method,$username,$nickname,$authority){
        if($this->method=$method == 1 && !empty($_SESSION['username'])){
            switch ($this->authority=$authority){
                case ($authority==1 && $username==$this->username=$username):
                    $_SESSION['nickname']=$this->nickname=$nickname;
                    echo "您现在处于管理员权限状态，网站登陆服务代码为1"."<br>";
                    echo "You was in admin situation and web login service code 1 in now";
                    echo "<div class='welcomeHead'>欢迎你，".$_SESSION['nickname']."！今天也是元气满满的一天呢！提起精神，我们距离成功也会更近一步！</div><a href='../nut/process/inform.php?exit=1'><button>退出</button></a>";
                    break;
                case ($authority==2 && $username==$this->username=$username):
                    $_SESSION['nickname']=$this->nickname=$nickname;
                    echo "您现在处于部分可用权限状态，网站登陆服务代码为2"."<br>";
                    echo "You was in Partially available situation and web login service code 2 in now";
                    echo "<div class='welcomeHead'>欢迎你，".$_SESSION['nickname']."！今天也是元气满满的一天呢！提起精神，我们距离成功也会更近一步！</div><a href='../nut/process/inform.php?exit=1'><button>退出</button></a>";
                    break;
                case ($authority==3 && $username==$this->username=$username):
                    $_SESSION['nickname']=$this->nickname=$nickname;
                    echo "<div class='welcomeHead'>欢迎你，".$_SESSION['nickname']."！今天也是元气满满的一天呢！提起精神，我们距离成功也会更近一步！</div><a href='../nut/process/inform.php?exit=1'><button>退出</button></a>";
                    break;
                case ($authority==4 && $username==$this->username=$username):
                    $_SESSION['nickname']=$this->nickname=$nickname;
                    echo "<div class='welcomeHead'>被封禁用户，".$_SESSION['nickname']."。由于不可抗力被封禁，您将无法享受概率计算等服务，有关疑问请和管理咨询！</div><a href='../nut/process/inform.php?exit=1'><button>退出</button></a>";
                    break;
                default :
                    echo "<div>欢迎你，游客！不登录将不会记录你的学习状态！这里登陆：<a href='../data/login.php'><button>登陆</button></a></div>";
                    break;
            }
        }elseif($this->method=$method == 2 && !empty($_SESSION['username'])){
            echo "<div style='color:red'>警告！现在处于全域最高权限状态，任何用户都可编辑任意信息！</div>";
        }elseif($this->method=$method == 3 && !empty($_SESSION['username'])){
            echo "管理员禁用所有用户登陆，状态码3";
        }else{
            echo "<div>欢迎你，游客！不登录将不会记录你的学习状态！这里登陆：<a href='../data/login.php'><button>登陆</button></a></div>";
        }
    }
    /**
     * 状态码（method）介绍：
     * 1为正常检测，权限由账户authority（tinyint）值决定
     * 2为全局设定为管理员，适用情况为无其他授权账户
     * 3为除authority值为1以外的其他账户全部禁用访问权限（如被封禁用户相同）
     * 以上讨论均将游客排除在外
    */
    public function status(){
        if(!empty($_SESSION['username'])){
            echo "<script>alert('您已登陆，请不要重复登陆！');</script>！";
            echo "<script>history.back();</script>";
            exit;
        }
    }
    /**
     * 此检测用于规避重复登陆的情况，注意，不要遗忘本函数
    */
}