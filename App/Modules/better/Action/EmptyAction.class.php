<?php
/**
 * 空模型类
 * @author  <[c@easycms.cc]>
 */
class EmptyAction extends Action {
	//空模型
	public function index(){		
		$this->redirect('better/Index/index');
    }
	//空操作
	public function _empty(){
		$this->redirect("better/Index/index");
	}
}
