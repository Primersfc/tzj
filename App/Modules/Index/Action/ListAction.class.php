<?php 
/**
* 前台2级列表页
* @author  <[c@easycms.cc]>
*/
class ListAction extends CommonAction
{
	
	Public function index(){
		$class1=I('c1','','intval');
        $class2=I('c2','','intval');
        $type=I('type','','intval');
		$cl1=M('class1')->where("id=$class1")->find();
        if($class2!='')
        $cl2=M('class2')->where("id=$class2")->find();
        $cl2all=M('class2')->where("class1=$class1")->select();
		$this->assign('class1',$cl1);
        $this->assign('class2',$cl2);
        $this->assign('cl2all',$cl2all);
		//数据分页
		import('ORG.Util.Page');// 导入分页类
        if($type==1 )
        {
   		$count=M('article')->where("class2=$class2 and islock=0")->count();
        }
        else
        $count=M('article')->where("class1=$class1 and islock=0")->count();
        //获取数据的总数
   		$page=new Page($count,20);
   		$page->setConfig('theme', '<ul class="pages">%first%%upPage%%linkPage%%downPage%%end%</ul>');
   		$show=$page->show();//返回分页信息
        if($type==1 )
        {
		$articles=M('article')->where("class2=$class2 and islock=0 and type=0")->order('article_id desc')->limit($page->firstRow.','.$page->listRows)->select();
        }
        else 
        $articles=M('article')->where("class1=$class1 and islock=0 and type=0")->order('article_id desc')->limit($page->firstRow.','.$page->listRows)->select();
        foreach ($articles as $key=>$value2){

           $articles[$key]["imgs"]=imgs($articles[$key]["imgs"]);

          }
		$this->assign('show',$show);
		$this->assign('count',$count);
		$this->assign('data',$articles);
        $sidebar1=M('article')->where('type=0')->order('approval desc')->limit('10')->select();
		//赞多到少
		$this->assign('approval',$sidebar1);
		$this->display('list_article');
	}
}