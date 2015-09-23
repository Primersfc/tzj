<?php
/**
* 前台首页
* @author  <[c@easycms.cc]>
*/
class IndexAction extends CommonAction
{ 
	Public function index(){
		$jyl=M('jyl');
        $jyl=$jyl->where('id=1')->find();
        $User=M('Member_user');
		$id=cookie('userid');//cookie需要加密
		$User =$User->find($id);//获取当前登录的用户信息
		$catelist=$this->menulist()	;//无限极分类

        $article=D('Article');
		//首页推荐展示,10条；//todo 随机
        $tuijian=$article->where('islock=0 and ispush=1 ')->limit("10")->field('title,fbsj,price,article_id,imgs,areaid,cid,lid,uid')->order('article_id desc')->relation(true)->select();
		//data 瀑布流;
        $data=$article->where('islock=0 and type=0 and imgs <>""')->limit(0,12)->field('title,fbsj,price,article_id,imgs,areaid,cid,lid,uid')->order('article_id desc')->relation(true)->select();
        foreach ($data as $key=>$value2){

           $data[$key]["imgs"]=imgs($data[$key]["imgs"]);

          }
        
        $news=M('article')->where('islock=0 and type=1')->limit('6')->order('article_id desc')->select();
		$qiugou=$article->where('class1=26')->order('article_id desc')->limit('5')->select();
        $laf=$article->where('class1=32')->order('article_id desc')->limit('5')->select();
        //assign
        $this->assign('tuijian',$tuijian);
        $this->assign('data',$data);
        $this->assign('news',$news);
        $this->assign('jyl',$jyl);
        $this->assign('user',$User);
		$this->assign('laf',$laf);
		$this->assign('qiugou',$qiugou);
		$this->assign('categoryq', $catelist);//无线分级菜单
		$this->display('index');
	}
	
	
	/**
	 * 无限极分类菜单调用
	 */
	public function menulist(){
		$field = 'id,name,pid';
		$categoryq = M('Category')->field($field)->order('id')->select();
		$catelist = $this->unlimitedForLevel($categoryq);
		return $catelist;
	}
	public function unlimitedForLevel($cate,$name = 'child',$pid = 0){
		$arr = array();
		foreach ($cate as $key => $v) {
			//判断，如果$v['pid'] == $pid的则压入数组Child
			if ($v['pid'] == $pid) {
				//递归执行
				$v[$name] = self::unlimitedForLevel($cate,$name,$v['id']);
				$arr[] = $v;
			}
		}
		return $arr;
	}
    public function getxia(){
    	/* print_r($_GET);
    	exit(); */
    	if ($_GET['id']==1){
    		echo "1";
    		exit();
    	}
    	//下拉的时候的条件
    	if($_GET['nextrow']){
    		$pagestart=$_GET['nextrow'];
    	}else{
    		$pagestart=0;
    	}
    	$data=M('article')->where('islock=0 and type=0 and imgs <>""')->limit($pagestart,12)->field('biaoti,name,fbsj,jiage,article_id,imgs,diqu,leixing')->order('article_id desc')->select();
        foreach ($data as $key=>$value2){

           $data[$key]["fbsj"]=date( 'm-d', strtotime( $data[$key]["fbsj"] ) );

          }//key相当于第几个数据
        foreach ($data as $key=>$value2){

           $data[$key]["imgs"]=imgs($data[$key]["imgs"]);

          }


    	echo json_encode( $data );
    	
    	$this->display();
    
    }

}
