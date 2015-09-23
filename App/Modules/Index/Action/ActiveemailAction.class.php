<?php
/**
* 前台首页
* @author  <[c@easycms.cc]>
*/
class ActiveemailAction extends CommonAction
{ 
    public function index(){
     if(time()-$_SESSION[C('USER_AUTH_EMAIL_time')]<60){
			$this->error(L('对不起！你发验证邮件速度太快了，请等待60秒钟后再发！'));
			}
    $email=$_POST['email'];
    $uid=$_POST['uid'];
    $uname=$_POST['uname'];
    $regtime=strtotime($_POST['regtime']);
    $etoken=md5($regtime.$uid);//验证加密
    $title="工大跳蚤街会员邮箱激活";
    $neirong="<html>亲爱的".$uname."<br>请点击下面的链接激活邮箱：<a href='http://www.hititp.com/index.php/index/activeemail/check/uid/".$uid."/token/".$etoken."'>http://www.hititp.com/index.php/index/activeemail/check/uid/".$uid."/token/".$etoken."</a></br>-----------------------------------------------<br>如果您点击上述链接无效，请把上面的地址拷贝到浏览器的地址栏中。<br><br>该邮件来自：<a href=http://www.hititp.com>www.hititp.com&nbsp&nbsp工大跳蚤街</a></html>";
    SendMail($email,$title,$neirong);
    $_SESSION[C('USER_AUTH_EMAIL_time')]=time();
    $this->assign('email',$email);
    $this->display('index');
    }
    public function check(){
    $token=$_GET['token'];
    $uid=$_GET['uid'];
    $user=M('member_user')->where("user_id=$uid")->find();
    $check=md5(strtotime($user['regtime']).$uid);
    if($check==$token)
    {
    M('member_user')->execute("update __TABLE__  set checkemail=1 where user_id=$uid");
    $this->success('邮箱激活成功','/');
    }
    else
    $this->error($check,'/');
    }
    
    public function getpass(){//待完善
    $email=$_GET['email'];
    $username=$_GET['username'];
    $user=M('member_user')->where("username='".$username."'")->find();
    if($user=="")
    {
    $this->error("邮箱用户不匹配",'/'); 
    }
    else
    {
    $this->success('已发送新密码到您的邮箱','/');
    }
    }
}
