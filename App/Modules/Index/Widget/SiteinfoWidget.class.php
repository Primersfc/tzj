<?php 
/**
 * 站点信息插件【系统级】
 * @author  <[c@easycms.cc]>
 */
class SiteinfoWidget extends Action{
	public function info($name=''){
		$m=M('sites');
		$result=$m->where("site_id=1")->find();
		echo $result[$name];
	}
}