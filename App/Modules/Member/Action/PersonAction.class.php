<?php 
class PersonAction extends CommonAction{
	public function index(){
		$User=M('Member_user');
		$id=cookie('userid');
		$result =$User->find($id);
		$this->assign('persons',$result);
		$this->display('index');
	}
	public function person(){
		$User=M('Member_user');
		$id['user_id']=cookie('userid');
		$result =$User->where($id)->find();
		$this->assign('persons',$result);
		$this->display('person');
	}
    public function article(){
		$User=M('article');
		$username=cookie('username');
		$data =$User->where('username="'.$username.'" and islock=0')->order('article_id desc')->select();
        $udata =$User->where('username="'.$username.'" and islock=1')->order('article_id desc')->select();
        foreach ($data as $key=>$value2){

           $data[$key]["imgs"]=imgs($data[$key]["imgs"]);

          }
        foreach ($udata as $key=>$value){

           $udata[$key]["imgs"]=imgs($udata[$key]["imgs"]);

          }
		$this->assign('data',$data);
        $this->assign('udata',$udata);
		$this->display('article');
	}
    public function republish(){
        $articleid=I('articleid','','intval');
		$username=cookie('username');
		$Article = M("Article"); // 实例化User对象
        $data['islock'] = 0;
        $data['fbsj'] =date("Y-m-d");
        $Article->where("article_id=$articleid and username='".$username."'")->data($data)->save();
		$this->redirect('article');
	}
    public function lockdata(){
        $articleid=I('articleid','','intval');
		$username=cookie('username');
		$Article = M("Article"); // 实例化User对象
        $data['islock'] = 1;
        $Article->where("article_id=$articleid and username='".$username."'")->data($data)->save();
		$this->redirect('article');
	}
    public function showedit(){
        $articleid=I('articleid','','intval');
		$username=cookie('username');
		$Article = M("Article"); // 实例化User对象
        $data=$Article->where("article_id=$articleid and username='".$username."'")->find();
        if(!$data)
        redirect('/index.php/member', 1.5, 'Sorry,您无权修改该信息,页面正在跳转。。。');
        else{
		$clist = M('class1')->order('paixu desc')->select();
        $clist2 = M('class2')->where('class1='.$data['class1'].'')->order('paixu desc')->select();
        $oldc1= M('class1')->where('id='.$data['class1'].'')->find();
        $oldc2= M('class2')->where('id='.$data['class2'].'')->find();
        $imgs= explode('|',$data[imgs]);
        $piclen=5-count($imgs);
        $this->assign('articleid',$articleid);
		$this->assign('clist',$clist);
        $this->assign('clist2',$clist2);
        $this->assign('c1',$oldc1);
        $this->assign('c2',$oldc2);
        $this->assign('olddata',$data);
        $this->assign('allimg',$imgs);
        $this->assign('piclen',$piclen);
		$this->display('edit');}
	}
    public function saveedit(){
        $articleid=I('articleid','','intval');
		$username=cookie('username');
		$Article = M("Article"); // 实例化User对象
        $Article->create();
        $Article->fbsj =date("Y-m-d");
        $result=$Article->where("article_id=$articleid and username='".$username."'")->save();
        //if($result == false)//修改出错
        //$this->error("修改出错");
        //else
		$this->redirect('/index/article/index/articleid/'.$articleid.'');
        
       
	}
    public function sold(){
        $articleid=I('articleid','','intval');
		$username=cookie('username');
		$Article = M("Article"); // 实例化User对象
        $Article = $Article->where("article_id=$articleid and username='".$username."'")->find(); // 删除信息
        $imgs= explode('|',$Article[imgs]);
        foreach($imgs as $scr)
        {
        $src=".".$scr;
        $src=str_replace('s_', 'b_', $src);
		if (file_exists($src)){
			unlink($src);
		}
        $src=str_replace('b_', 's_', $src);
		if (file_exists($src)){
			unlink($src);
		}
        }
        M("Article")->where("article_id=$articleid and username='".$username."'")->delete();
        M('jyl')->execute("update __TABLE__  set jycg=jycg+1 where id=1");
        $this->redirect('article');
	}
    public function delete(){
        $articleid=I('articleid','','intval');
		$username=cookie('username');
		$Article = M("Article"); // 实例化User对象
        $Article = $Article->where("article_id=$articleid and username='".$username."'")->find(); // 删除信息
        $imgs= explode('|',$Article[imgs]);
        foreach($imgs as $scr)
        {
        $src=".".$scr;
        $src=str_replace('s_', 'b_', $src);
		if (file_exists($src)){
			unlink($src);
		}
        $src=str_replace('b_', 's_', $src);
		if (file_exists($src)){
			unlink($src);
		}
        }
        M("Article")->where("article_id=$articleid and username='".$username."'")->delete();
        
        $this->redirect('article');
	}
	public function data(){
		$User=M('Member_user');
		$id['user_id']=cookie('userid');
		$result =$User->where($id)->find();
		$this->assign('persons',$result);
		$this->display('data');
	}
	public function avatar(){
		$User=M('Member_user');
		$id['user_id']=cookie('userid');
		$result =$User->where($id)->find();
		$this->assign('persons',$result);
		$this->display('avatar');
	}
	
	public function Profile(){
		$User=D('Member_user');
		$result=$User->create();
		if(!$result){
 			$this->error(($User->getError()));
		}
        else{
            $id=cookie('userid');
			
                    $sav['dianhua']=$result['dianhua'];
                    $sav['qq']=$result['qq'];
                    $sav['dizhi']=$result['dizhi'];
					$User->where("user_id=$id")->save($sav);
					$this->success('修改成功');
			
		    }
	}


	public function pwd(){
			$User=D('Member_user');
			$result=$User->create();
			if(!$result){
 				$this->error(($User->getError()));
			}else{
				$id=cookie('userid');
                $username=cookie('username');
				$mm['password']=substr(md5($result['password']),8,16);
				$m=$User->where("user_id=$id and username='".$username."'")->find();
				if($m['password']==$mm['password']){
					if($m['password']==substr(md5($_POST['pwd']),8,16)){
						$this->error('修改的密码不能和原密码一样哦');
					}
				$pwd['password']=substr(md5(($_POST['pwd'])),8,16);
				$pwd=$User->where("user_id=$id")->save($pwd);
				if($m){
					$this->success('更新成功');

				}else{
					$this->error('更新失败');
				}
			}else{
				
				$this->error('密码错误');
			}
		}
	}

 public function reply(){
        M('member_user')->execute("update __TABLE__  set zywhf=0 where username='".cookie('username')."'");
		$reply=D('CommentView');
		$username=cookie('username');
		$data =$reply->where('sjname="'.$username.'" and hfname!="'.$username.'" and r=0')->order('id desc')->select();
        $data2 =$reply->where('hfname="'.$username.'"')->order('id desc')->select();
        $user=M('member_user')->where("username='".cookie('username')."' and user_id=".cookie('userid')."")->find();
		$this->assign('data',$data);
        $this->assign('data2',$data2);
        $this->assign('user',$user);
        $this->display('reply');
	}



}