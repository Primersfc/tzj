<?php
/**
* 前台首页
* @author  <[c@easycms.cc]>
*/
class PushAction extends CommonAction
{ 
    Public function index()
    {$this->display('index');}
	Public function pushall()
{	$title=$_POST['title'];
	$content=$_POST['content'];
      include('/jpush.php');
	  $n_title   =  $title;
	  $n_content =  $content;	
      $appkeys='365a50bd7cfeb1bd77350839';
      $masterSecret='89affe6c63580f1672997ded';
      $sendno = 4;
      $receiver_value = '';			
			$platform = 'android,ios' ;
			$msg_content = json_encode(array('n_builder_id'=>0, 'n_title'=>$n_title, 'n_content'=>$n_content));        
			$obj = new jpush($masterSecret,$appkeys);			 
			$res = $obj->send($sendno, 4, $receiver_value, 1, $msg_content, $platform);				
			print_r($res);
			exit();	
}
}
