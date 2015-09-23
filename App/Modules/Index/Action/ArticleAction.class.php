<?php
/**
* 前台文章发布
* @author  <[c@easycms.cc]>
*/
class ArticleAction extends CommonAction
{
	
	Public function index(){
		$article_id=I('articleid','','intval');//input id
		$this->assign('aid',$article_id);
        		/* 左侧分类列表*/
		$mlist=R('Index/menulist');
		$this->assign('categoryq', $mlist);
		$article=M('Article')->where("article_id=$article_id")->find();
        if($article==false)//查询结果无
        $this->redirect('/index');
        else{
        if($article_id!=cookie('lastaid'))
        {
        cookie('lastaid',$article_id);
        M('article')->execute("update __TABLE__  set llcs=llcs+1 where article_id=$article_id");
        }//cookie浏览次数防刷新
        $article[imgs]= str_replace("s_","b_",$article[imgs]);
		$this->assign('article',$article);
        $imgs= explode('|',$article[imgs]);
        $this->assign('allimg',$imgs);
        $fbr=M('member_user')->where("username='".$article['username']."'")->find();
        $user=M('member_user')->where("user_id=".cookie('userid')."")->find();
        $marticle=M('Article')->where("username='".$article['username']."' and article_id !=$article_id")->order('rand()')->limit('6')->select();
        $similer=M('Article')->where("class2=".$article['class2']." and article_id !=$article_id")->order('rand()')->limit('6')->select();
                $c1= M('class1')->where('id='.$article['class1'].'')->find();
        $c2= M('class2')->where('id='.$article['class2'].'')->find();
        $this->assign('fbr',$fbr);
        $this->assign('user',$user);
        $this->assign('marticle',$marticle);
        $this->assign('similer',$similer);
         $this->assign('c1',$c1);
        $this->assign('c2',$c2);
        //判断当前ip是否点赞
       $ip = get_client_ip();
	   $Uip = M('Zan_ip');
	   $result=$Uip->where("articleid=$article_id and ip='$ip'");
       $count=$result->count();
	   if($count==0)
       $love='未';
       else
       $love='已';
       $this->assign('love',$love);
       //导入评论    
        $reply = D('CommentView'); //实例化Comment视图模型
        $count = $reply -> where(array('article_id' => $article_id, 'pid' => 0)) -> limit($page->firstRow.','.$page->listRows) ->count();
        import('ORG.Util.Page');//导入分页类
		$page=new page($count,8);//reply分页
        $articleComments = $reply -> where(array('article_id' => $article_id, 'pid' => 0)) -> limit($page->firstRow.','.$page->listRows) -> select(); //将一级8条评论查询出来
        $page->setConfig('theme', '<ul class="pages">%first%%upPage%%linkPage%%downPage%%end%</ul>');
        $show=$page->show();//返回分页信息
        foreach($articleComments as $comment) {
         $comments[$comment['id']] = $comment; //将查询出来的一级评论按id赋给comments数组
        }
        $commentID = array_keys($comments); //取出一级评论的id，为下面查询对应的二级评论做准备
        if (!empty($commentID)) {
         foreach($commentID as $id) {
          $sqlArray[] = 'pid=' . $id; //生成查询二级评论所用条件数组
         }
         $sql = implode(' OR ', $sqlArray); //将数组连接，生成对应的SQL条件语句
         $articleComments = $reply -> where($sql) -> select(); //查询对应二级评论
         foreach($articleComments as $comment) {
          $comments[$comment['pid']]['comments'][]= $comment; //按树形排列评论
         }
        }
        $this -> assign('comments', $comments);
        $this->assign('show',$show);//分页信息
        if($article[type]==0)
	   $this->display('article_article');
       else if($article[type]==1)
       {
        $mnews=M('article')->where("article_id !=$article_id and type=1")->order('article_id desc')->limit('10')->select();
         $this->assign('mnews',$mnews);
       $this->display('article_news');
       }
		
        }
	}

	public function addComment(){
		if(cookie("userid")){
			//对回复速度进行判断
			$aid=I('article_id','','intval');
            $pid=I('pid','','intval');
            $uname=cookie("username");
			$lastPubtime=M('reply')->where("hfname='$uname' and article_id=$aid")->order('id desc')->limit('1')->getField('hfsj');
			if(time()-strtotime($lastPubtime)<10)
            $this->error('评论太快了，请等待10秒');
            $user=M('member_user')->where("username='".cookie('username')."' and user_id=".cookie('userid')."")->find();
            $article=M('article')->where("article_id=$aid")->field('biaoti,name,username')->find();
            if($article=="")
            $this->error('您要回复的主题已被删除');
			$comment= I('comment');
			if($comment=='')
			$this->error('评论内容不能为空');

			$data['hfname']=$uname;
			$data['article_id']=$aid;
			$data['hfsj']=date("Y-m-d H:i:s",time());
            $data['neirong']=$comment;
            $data['hfnicheng']=$user['name'];
            $data['uid']=$user['user_id'];
            $data['pid']=$pid;
            $data['biaoti']=$article['biaoti'];
            if($pid==0)
            {
            $sjname=$article['username'];
            $data['sjname']=$sjname;
            $data['sjnicheng']=$article['name'];
            }
            else{
            $sjuser=M('reply')->where("id=$pid")->find();
            if($sjuser['pid']!=0)
            $data['pid']=$sjuser['pid'];//
            $sjname=$sjuser['hfname'];
            $data['sjname']=$sjname;
            $data['sjnicheng']=$sjuser['hfnicheng'];
            }
			$m=M('reply')->add($data);
			if($m){
            if($uname != $article['username'] && $sjname != $uname )//收件提醒
            {
            $sjr=M('member_user')->where("username='".$sjname."'")->find();
            if($sjr['checkemail']==1)//收件人验证了邮箱,直接收件人才会收到邮件
            {$title="工大跳蚤街新的回复：来自主题".$article['biaoti'];
            $neirong="<html>来自主题:".$article["biaoti"]."<br>回复详情:".$comment."<br>回复人：".$user['name']."<br><br>该邮件来自：<a href=http://www.hititp.com>www.hititp.com&nbsp&nbsp工大跳蚤街</a></html>";
            SendMail($sjr['email'],$title,$neirong);
            }
            M('member_user')->execute("update __TABLE__  set zywhf=zywhf+1 where username='".$sjname."'");
            if($sjname != $article['username'])
            M('member_user')->execute("update __TABLE__  set zywhf=zywhf+1 where username='".$article['username']."'");//子回复也通知楼主
            }
				redirect($_SERVER['HTTP_REFERER']);
            M('article')->execute("update __TABLE__  set hfcs=hfcs+1 where article_id=$aid");//回复次数
			}else{
				$this->error('评论失败');
			}
		}else{
			$this->error('请登录后再评论');
		}
	}
    public function cmtdelete(){
        $cmtid=I('cmtid','','intval');
		$username=cookie('username');
		$cmt = M("reply"); // 实例化User对象
        $cmt = $cmt->where("id=$cmtid and hfname='".$username."'")->find(); // 删除信息
        if($cmt=="")
        $this->error("您无权删除该评论");
        else{
        //删除子回复待处理if($cmt['pid'])
        M("reply")->where("id=$cmtid and hfname='".$username."'")->delete();
        
        redirect($_SERVER['HTTP_REFERER']);
	}
    }
    public function cmtread(){
        $cmtid=I('cmtid','','intval');
		$username=cookie('username');
		$cmt = M("reply"); // 实例化User对象
        $cmt = $cmt->where("id=$cmtid and sjname='".$username."'")->find(); // 删除信息
        if($cmt=="")
        $this->error("您无权标记该回复");
        else{
        //删除子回复待处理if($cmt['pid'])
        M('reply')->execute("update __TABLE__  set r=1 where id=$cmtid");
        
        redirect($_SERVER['HTTP_REFERER']);
	}
    }



	public function checkuser(){
		if (isset($_SESSION['username'])) {
			echo '	 <li><a>'.$_SESSION['username'].'</a></li>
         			 <li><a href="'.U('Member/person/index').'" style="color:red">个人中心</a></li>
         			 <li><a href="'.U('Index/login/doLogout').'">退出</a></li>';
		}else{
			echo '	 <li><a href="'.U('Index/Login/checkreg').'">注册</a></li>
        			 <li><a href="'.U('Index/Login/index').'">登陆</a></li>';
		}
	}
	public function love(){
	   $id = I('post.id'); //点赞文章id
           //写入ip		   
	   $ip = get_client_ip();
	   $Uip = M('Zan_ip');
	   $result=$Uip->where("articleid=$id and ip='$ip'");
       $count=$result->count();
	   if($count==0)
	   	   {
	   	   M('Article')->execute("update __TABLE__  set approval=approval+1 where article_id=$id");
	   	   $love= M('Article')->where("article_id=$id")->limit('1')->getField('approval');//更新赞的数量
	   	   // 实例化Uip模型
	   	   $data['articleid'] = $id;
	   	   $data['ip'] = $ip;
	   	   $Uip->create($data);
	   	   $Uip->add();
	   	   echo "(".$love."赞)"; 
	   	   }
	   else{
	   	    echo"(亲，赞过了~)";
		   }
	}

	
	
}
?>