<?php 
class PublishAction extends CommonAction{
	public function index(){
		$User=M('Member_user');
		$id=cookie('userid');
		$result =$User->find($id);
		$this->assign('persons',$result);
        $m=M('class1');
		$clist = $m->order('paixu desc')->select();
		$this->assign('clist',$clist);
		$this->display('index');
	}

    
    public function class2(){
        $class1 =$_GET["class1"]; 
		$class2 = M('class2')->where('class1 ='.$class1.'')->order('paixu desc')->field('id,class2')->select();

		echo json_encode( $class2 ); 	
	}
    
    public function insert(){
		$model = D('Article');
		unset ( $_POST [$model->getPk()] );
		
		if (false === $model->create()) {
			$this->error($model->getError());
		}
		//保存当前数据对象
        $User=M('Member_user');
		 $id=cookie('userid');
		 $User =$User->find($id);
         $model->fbsj =date("Y-m-d");
         $model->username =cookie('username');
         $model->name=$User['name'];
         if(time()-$_SESSION[C('USER_AUTH_KEY_time')]<20){
			$this->error(L('对不起！你发信息太快了，请等待20秒钟后再发！'));
			}
		if ($result = $model->add()){
            $_SESSION[C('USER_AUTH_KEY_time')]=time();
			$model->id = $result;
			$this->redirect('/index/article/index/articleid/'.$result.'');
		} else {
			$this->error($model->getError());
		}
		
	
	}
     Public function uploadImg() {
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();// 实例化上传类
		$upload->maxSize  = 3145728 ;// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg','bmp');// 设置附件上传类型
		$savepath='uploads/pic/'.date('Ym').'/';
        $upload->thumb = true;
		$upload->thumbPrefix = 'b_,s_';
		$upload->thumbMaxWidth = '400,160';
		$upload->thumbMaxHeight = '400,160';
		$upload->thumbRemoveOrigin = true;
        $upload->saveRule = time () . '_' . mt_rand ( 1000000, 9999999 );
		if (!file_exists($savepath)){
			mkdir($savepath);
		}
		$upload->savePath =  $savepath;// 设置附件上传目录
		if(!$upload->upload()) {// 上传错误提示错误信息
			$info =  $upload->getUploadFileInfo();
		}else{// 上传成功 获取上传文件信息
			$info =  $upload->getUploadFileInfo();
		}
		print_r(__ROOT__.'/'.$info[0]['savepath'].'s_'.$info[0]['savename']);
	}
    Public function muploadImg() {
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();// 实例化上传类
		$upload->maxSize  = 3145728 ;// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg','bmp');// 设置附件上传类型
		$savepath='uploads/pic/'.date('Ym').'/';
        $upload->thumb = true;
		$upload->thumbPrefix = 'b_,s_';
		$upload->thumbMaxWidth = '400,160';
		$upload->thumbMaxHeight = '400,160';
		$upload->thumbRemoveOrigin = true;
        $upload->saveRule = time () . '_' . mt_rand ( 1000000, 9999999 );
		if (!file_exists($savepath)){
			mkdir($savepath);
		}
		$upload->savePath =  $savepath;// 设置附件上传目录
		if(!$upload->upload()) {// 上传错误提示错误信息
			$info =  $upload->getUploadFileInfo();
            print_r("<script>window.parent.uploadSuccess('/sysimg/error_upload.gif');</script>");
		}else{// 上传成功 获取上传文件信息
			$info =  $upload->getUploadFileInfo();
            print_r("<script>window.parent.uploadSuccess('".__ROOT__.'/'.$info[0]['savepath'].'s_'.$info[0]['savename']."');</script>");
		}
		
	}
	Public function del() {
		$src=str_replace(__ROOT__.'/', './', str_replace('//', '/', $_GET['src']));
		if (file_exists($src)){
			unlink($src);
		}
        $src=str_replace(__ROOT__.'/', './', str_replace('s_', 'b_', $_GET['src']));
		if (file_exists($src)){
			unlink($src);
		}
		print_r($_GET['src']);
		exit();
	}

    }
   