<?php
/**
* 前台公共类
* @author  <[c@easycms.cc]>
*/
class CommonAction extends Action
{
	Public function _initialize(){
		if (ismobile()) {
            C('DEFAULT_THEME','mobile');
        }
		//全局首页，用户个人中心导航分类展示

	}
	
	//空操作
	public function _empty(){
		$this->redirect(__ROOT__);
	}
}
