<?php
/**
 * 修改用户锁定状态
 * @param  [number] $status   [状态值]
 * @param  [number] $id       [id]
 * @param  string $callback [返回值]
 * @return [string]          [组合链接]
 */
function showStatus($status, $id, $callback="") {
	switch ($status) {
		case 0 :
			$info = '<a href="__URL__/changeState/user_id/'.$id.'/islock/0/navTabId/listusers" target="ajaxTodo" callback="'.$callback.'">锁定</a>';
			break;
		case 1 :
			$info = '<a href="__URL__/changeState/user_id/'.$id.'/islock/1/navTabId/listusers" target="ajaxTodo" callback="'.$callback.'">恢复</a>';
			break;
	}
	return $info;

}


function showReason($status, $id, $callback=""){
	switch ($status) {
		case 0 :
			$info = '<a href="__URL__/changeState/link_id/'.$id.'/isverify/0/navTabId/listlink" target="ajaxTodo" callback="'.$callback.'">恢复显示</a>';
			break;
		case 1 :
			$info = '<a href="__URL__/changeState/link_id/'.$id.'/isverify/1/navTabId/listlink" target="ajaxTodo" callback="'.$callback.'">禁止显示</a>';
			break;
	}
	return $info;
}

function rubbish($status, $id, $callback=""){
	switch ($status) {
		case 1 :
			$info = '<a href="__URL__/changeState/article_id/'.$id.'/islock/1/navTabId/listarticle1" target="ajaxTodo" callback="'.$callback.'">恢复显示</a>';
			break;
		case 0 :
			$info = '<a href="__URL__/changeState/article_id/'.$id.'/islock/0/navTabId/listarticle" target="ajaxTodo" callback="'.$callback.'">加入回收站</a>';
			break;
	}
	return $info;
}

function crubbish($status, $id, $callback=""){
	switch ($status) {
		case 1 :
			$info = '<a href="__URL__/changeState/commend_id/'.$id.'/islock/1/navTabId/listcomment1" target="ajaxTodo" callback="'.$callback.'">恢复显示</a>';
			break;
		case 0 :
			$info = '<a href="__URL__/changeState/commend_id/'.$id.'/islock/0/navTabId/listcomment" target="ajaxTodo" callback="'.$callback.'">加入回收站</a>';
			break;
	}
	return $info;
}

/*首页展示信息第一张图片截取*/
function imgs($status){
    //$status=str_replace("s_","b_",$status);
	$matches= explode('|',$status);
    return  $img = $matches[0];

}

function photos($status){
	if(!$status==null){
              return  './Uploads/Picture/Avatar'.'/'.'avatar_'.$status;
    }else{
                return  './Uploads/Picture/Avatar'.'/'.'nophoto.gif';
    }
}
function color_txt($str){
    $len        = mb_strlen($str);
    $colorTxt   = '';
    for($i=0; $i<$len; $i++) {
        $colorTxt .=  '<span style="color:'.rand_color().'">'.mb_substr($str,$i,1,'utf-8').'</span>';
    }
    return $colorTxt;
 }
 function rand_color(){
    return '#'.sprintf("%02X",mt_rand(0,255)).sprintf("%02X",mt_rand(0,255)).sprintf("%02X",mt_rand(0,255));
 }

function SaveSetting($arr){
	$setfile=C('settingfile_path');
	$a=include './App/Conf/setting.config.php';
	$c=array_merge($a,$arr);
	$settingstr="<?php\n\r return ".var_export($c,TRUE)."\n\r?>";
	file_put_contents($setfile,$settingstr);
}


/**
 *自定义的删除函数,可以删除文件和递归删除文件夹
 */
 function my_del($path)
{
	if(is_dir($path))
	{
			$file_list= scandir($path);
			foreach ($file_list as $file)
			{
				if( $file!='.' && $file!='..')
				{
					my_del($path.'/'.$file);
				}
			}
			@rmdir($path);  //这种方法不用判断文件夹是否为空,	因为不管开始时文件夹是否为空,到达这里的时候,都是空的		
	}
	else
	{
		@unlink($path);    //这两个地方最好还是要用@屏蔽一下warning错误,看着闹心
	}

}

/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}

/**
 * [移动端访问自动切换主题模板]
 * @return boolen [是否为手机访问]
 */
function ismobile() {
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        return true;
    
    //此条摘自TPM智能切换模板引擎，判断是否为客户端
    if(isset ($_SERVER['HTTP_CLIENT']) &&'PhoneClient'==$_SERVER['HTTP_CLIENT'])
        return true;
    //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
        //找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], 'wap') ? true : false;
    //判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array(
            'nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile'
        );
        //从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    //协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
 }
 
 
 function SendMail($address,$title,$message)
{
    import('ORG.Net.PHPMailer');
    $mail=new PHPMailer();
    // 设置PHPMailer使用SMTP服务器发送Email
    $mail->IsSMTP();
    // 设置邮件的字符编码，若不指定，则为'UTF-8'
    $mail->CharSet='UTF-8';
    // 添加收件人地址，可以多次使用来添加多个收件人
    $mail->AddAddress($address);
    // 设置邮件正文
    $mail->Body=$message;
    // 设置邮件头的From字段。
    $mail->From=C('MAIL_ADDRESS');
    // 设置发件人名字
    $mail->FromName='工大跳蚤街|www.hititp.com';
    // 设置邮件标题
    $mail->Subject=$title;
    // 设置SMTP服务器。
    $mail->Host=C('MAIL_SMTP');
    // 设置为“需要验证”
    $mail->SMTPAuth=true;
    $mail->IsHTML(true);
    // 设置用户名和密码。
    $mail->Username=C('MAIL_LOGINNAME');
    $mail->Password=C('MAIL_PASSWORD');
    // 发送邮件。
    return($mail->Send());
}

 
function valid_email($email){
//首先确认是否有一个@符号的存在，同时验证邮箱长度是否正确
if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
//如果@符号的个数不对，或者邮箱每部分的长度不对则输出错误
return false;
}
//把邮箱按"@"符号和"."符号分割成几个部分分别用正则表达式匹配
$email_array = explode("@", $email);
$local_array = explode(".", $email_array[0]);
for ($i = 0; $i < sizeof($local_array); $i++) {
if (!ereg("^(([A-Za-z0-9!#$%&#038;'*+/=?^_`{|}~-][A-Za-z0-9!#$%&#038;'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
return false;
}
}
if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
//检查域名部分是否是IP地址，如果不是则应该是有效域名
$domain_array = explode(".", $email_array[1]);
if (sizeof($domain_array) < 2) {
//域名部分的长度不能太短，否则输出错误
return false;
}
for ($i = 0; $i < sizeof($domain_array); $i++) {
if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
//域名部分如果不是字母和数字，或者允许的其他字符，则输出错误
return false;
}
}
}
//所有检测通过，输出邮箱格式正确
return true;
}