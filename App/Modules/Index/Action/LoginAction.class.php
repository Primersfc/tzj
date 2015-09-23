<?php  
/**
 * 前台登陆注册
 * @author  <[l@easycms.cc]>
 */
class LoginAction extends Action{
	//空操作
	public function _empty(){
		$this->redirect("Index/Index/index");
	}

	Public function _initialize(){
   		// 控制器初始化方法
   		// 判断是否手机访问
   		if (ismobile()) {
            C('DEFAULT_THEME','mobile');
        }
	}


	public function index(){
		$this->display('login');
	}
	public function checkLogin(){
		$User = M("Member_user"); 
		if (!$User->create()){
			 $this->error(($User->getError()));
		}else{
		$name=$User->create();
		$where['username']=$name['username'];
		$where['password']=substr(md5($name['password']),8,16);
		$result =$User->where($where)->find();
		if($result['islock']==1){
			$this->error('您的账号已经被管理锁定，请联系管理员',U('Login/index'));
		}
		if($result!=null){
            $sav['lastdl']=date("Y-m-d");
            $sav['ip']=get_client_ip();
			$User->where($where)->save($sav);
            cookie('username',$result['username']);
            cookie('userid',$result["user_id"]);
			$this->redirect('Index/index');
		}else{
			$this->error('账号或密码错误。',U('Login/index'));
		}
	}
}

public function checkreg(){
		$this->display('checkreg');
}
public function checkregs(){
	if($_SESSION["verify"]!=md5($_POST['code'])){
			$this->error("验证码错误");
		}
		$User = D("Member_user");
		$result=$User->create();
		if (!$result){
			 $this->error(($User->getError()));
		}else{
            $User->photo = "/Uploads/Avatar/avatar_sys/".rand(1,10).".jpg";
            $User->regtime=date("Y-m-d");
			$addresult=$User->where($result)->add();
			if($addresult>0){
                cookie('username',$result['username']);
                cookie('userid',$addresult);
				$this->success('注册成功',U('Index/index'));
			}else{
				$this->redirect('/index.php/member/person/person');

			}
		}
}

public function verify(){
		import('ORG.Util.Image');
		Image::buildImageVerify();
	}	

public function doLogout(){
		//清除前台的服务端的cookie值
        cookie('username',null);
		cookie('userid',null);
		$this->redirect('Index/Index/index');
	}

public function checkName(){
			$username=$_GET['username'];
			$user=M('Member_user');
			$where['username']=$username;
			$count=$user->where($where)->count();
			if($count){
				echo '不允许';
			}else{
				echo '允许';
			}
		}


public function checknc(){
			$nc=$_GET['name'];
			$user=M('Member_user');
			$where['name']=$nc;
			$count=$user->where($where)->count();
			if($count){
				echo '不允许';
			}else{
				echo '允许';
			}
		}

public function checkemail(){
			$email=$_GET['email'];
			$user=M('Member_user');
			$where['email']=$email;
			$count=$user->where($where)->count();
            $okemail=valid_email($email);
			if(!$okemail){
				echo '格式';
			}
            else if($count){
				echo '不允许';
			}
            else
            {
				echo '允许';
			}
		}
        
    public function qqlogin(){
  //应用的APPID
  $app_id = "101099723";
  //应用的APPKEY
  $app_secret = "99326043b251c336bd3c9c6e55178d76";
  //成功授权后的回调地址
  $my_url = "http://www.hititp.com/index.php/index/login/qqlogin";
 
  //Step1：获取Authorization Code
  session_start();
  $code = $_REQUEST["code"];
  if(empty($code)) 
  {
     //state参数用于防止CSRF攻击，成功授权后回调时会原样带回
     $_SESSION['state'] = md5(uniqid(rand(), TRUE)); 
     //拼接URL     
     $dialog_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=" 
        . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
        . $_SESSION['state'];
     echo("<script> top.location.href='" . $dialog_url . "'</script>");
  }
 
  //Step2：通过Authorization Code获取Access Token
  if($_REQUEST['state'] == $_SESSION['state']) 
  {
     //拼接URL   
     $token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"
     . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
     . "&client_secret=" . $app_secret . "&code=" . $code;
     $response = file_get_contents($token_url);
     if (strpos($response, "callback") !== false)
     {
        $lpos = strpos($response, "(");
        $rpos = strrpos($response, ")");
        $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
        $msg = json_decode($response);
        if (isset($msg->error))
        {
           echo "<h3>error:</h3>" . $msg->error;
           echo "<h3>msg  :</h3>" . $msg->error_description;
           exit;
        }
     }
 
     //Step3：使用Access Token来获取用户的OpenID
     $params = array();
     parse_str($response, $params);
     $graph_url = "https://graph.qq.com/oauth2.0/me?access_token=".$params['access_token'];
     $str  = file_get_contents($graph_url);
     if (strpos($str, "callback") !== false)
     {
        $lpos = strpos($str, "(");
        $rpos = strrpos($str, ")");
        $str  = substr($str, $lpos + 1, $rpos - $lpos -1);
     }
     $user = json_decode($str);
     if (isset($user->error))
     {
        echo "<h3>error:</h3>" . $user->error;
        echo "<h3>msg  :</h3>" . $user->error_description;
        exit;
     }
     $qqopenid=$user->openid;
     //Step4：获取头像，昵称
     $basic_url ="https://graph.qq.com/user/get_user_info?access_token=".$params['access_token']."&oauth_consumer_key=101099723&openid=".$qqopenid;
     $basic_str  = file_get_contents($basic_url);
     if (strpos($basic_str, "callback") !== false)
     {
        $lpos = strpos($basic_str, "(");
        $rpos = strrpos($basic_str, ")");
        $basic_str  = substr($basic_str, $lpos + 1, $rpos - $lpos -1);
     }
     $user_info = json_decode($basic_str);
     $nickname=$user_info->nickname;
     $photo=$user_info->figureurl_qq_1;
     //step5保存用户数据
            if($qqopenid!='')
            {
            $U = M("Member_user"); 
            $result =$U->where("qqopenid='".$qqopenid."'")->find();
     		if($result!=null){
            $sav['lastdl']=date("Y-m-d");
            $sav['ip']=get_client_ip();
			$U->where($where)->save($sav);
            cookie('userid',$result["user_id"]);
            cookie('username',$result['username']);
            
			$this->redirect('Index/index');
		}else{
 // 创建数据后写入到数据库
 $data['photo'] = $photo;
$data['regtime']=date("Y-m-d");
$data['username'] = 'u'.time() . mt_rand( 10, 99);
$data['name'] = $nickname;
$data['qqopenid'] = $qqopenid;
$addresult=$U->data($data)->add();
if($addresult>0){
cookie('username',$data['username']);
cookie('userid',$addresult);
    $this->redirect('Index/index');
		}
  }
  }
  else
  echo("openid为空，请重试.");
  }
  else 
  {
     echo("防止CSRF攻击，请重试.");
  }
  }
  
}