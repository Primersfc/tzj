<?php
/**
* 前台搜索
* @author  <[s@easycms.cc]>
*/
class SearchAction extends CommonAction
{
	Public function index(){
		$put=I('s');
		if(trim($put)==''){
			$this->error('搜索内容不能为空！');
			die;
		}
		$where['biaoti']=$put;
		$where['content']=$put;
        $where['_logic']='OR';
        $map['_complex']=$where;
        $map['islock']=0;//复合查询
		$count=M('article')->where($map)->count();
		import('ORG.Util.Page');
		$page=new page($count,10);
		$page->setConfig('theme', '<ul class="pages">%first%%upPage%%linkPage%%downPage%%end%</ul>');
		$show=$page->show();//返回分页信息
		$article=M('article')->where($map)->limit($page->firstRow.','.$page->listRows)->select();
        foreach ($article as $key=>$value2){

           $article[$key]["imgs"]=imgs($article[$key]["imgs"]);

          }
		$this->assign('put',$put);
		$this->assign('show',$show);//分页信息
		$this->assign('count',$count);//数据总数
		$this->assign('list',$article);//数据集
                $sidebar1=M('article')->where('type=0')->order('approval desc')->limit('10')->select();
		//赞多到少
		$this->assign('approval',$sidebar1);

		$this->display('search');
	}
	
}