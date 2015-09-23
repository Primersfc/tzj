<?php 
/**
 * 头像上传类
 * @author  <[l@easycms.cc]>
 */
class UpperAction extends CommonAction{

	Public function index(){
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();// 实例化上传类
		$upload->maxSize  = 5242880 ;// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->savePath =  './Uploads/Avatar/';// 设置附件上传目录
		$upload->thumb = true;
		$upload->thumbPrefix = 'avatar_';
		$upload->thumbMaxWidth = '150';
		$upload->thumbMaxHeight = '150';
		$upload->thumbRemoveOrigin = true;
		$upload->saveRule = time () . '_' . mt_rand ( 1000000, 9999999 );
		if(!$upload->upload()) {// 上传错误提示错误信息
			$this->error($upload->getErrorMsg());
		}else{// 上传成功 获取上传文件信息
			$info =  $upload->getUploadFileInfo();
		}
		 
		// 保存表单数据 包括附件数据
		$User = M("Member_user"); // 实例化User对象
		$upload= $info[0]['savename']; // 保存上传的照片根据需要自行组装
		$data['photo']="/Uploads/Avatar/avatar_".$upload;
		$id=cookie("userid");
		$m=$User->where("user_id=$id")->save($data); 
		// 写入用户数据到数据库
		if($m){
			$this->redirect('/member/person/person');
		}else{
			$this->error('头像保存失败！');
		}
		
	}
    Public function idcard(){
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();// 实例化上传类
		$upload->maxSize  = 5242880 ;// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->savePath =  './Uploads/idcard/';// 设置附件上传目录
		$upload->thumb = true;
		$upload->thumbPrefix = 'idcard_';
        $upload->thumbType = 0;
		$upload->thumbMaxWidth = '500';
		$upload->thumbMaxHeight = '500';
		$upload->thumbRemoveOrigin = true;
		$upload->saveRule = time () . '_' . mt_rand ( 1000000, 9999999 );
		if(!$upload->upload()) {// 上传错误提示错误信息
			$this->error($upload->getErrorMsg());
		}else{// 上传成功 获取上传文件信息
			$info =  $upload->getUploadFileInfo();
		}
		 
		// 保存表单数据 包括附件数据
        $User = M("Member_user"); // 实例化User对象
		$upload= $info[0]['savename']; // 保存上传的照片根据需要自行组装
		$data['idcard']=1;//等待认证状态
        $data['zjtp']="/Uploads/idcard/idcard_".$upload;
		$id=cookie("userid");
		$m=$User->where("user_id=$id")->save($data); 
		
		// 写入用户数据到数据库
		if($m){
			$this->redirect('/member/person/person');
		}else{
			$this->error('证件上传失败！');
		}
		
	}
    Public function edituppic(){
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();// 实例化上传类
		$upload->maxSize  = 5242880 ;// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->savePath ='./uploads/pic/'.date('Ym').'/';// 设置附件上传目录
		$upload->thumb = true;
        $upload->thumbType = 0;
		$upload->thumbPrefix = 'b_,s_';
		$upload->thumbMaxWidth = '500,150';
		$upload->thumbMaxHeight = '1000,150';
		$upload->thumbRemoveOrigin = true;
		$upload->saveRule = time () . '_' . mt_rand ( 1000000, 9999999 );
        $info = $upload->uploadOne($_FILES['imgFile']);
        $file_url ='/uploads/pic/'.date('Ym').'/b_'.$info['0']['savename'];
        if($info){
$data['error']=0;
$data['url']=$file_url;
$this->ajaxReturn($data,'JSON');
}else{
$this->ajaxReturn(0,$upload->getErrorMsg(),0);
}
        }



}