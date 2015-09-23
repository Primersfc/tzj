<?php
/**
 * 自定义文章模型类
 * @author  <[c@easycms.cc]>
 */
class ArticleModel extends Model{
	


	protected $_auto = array( 
        array('ip',"get_client_ip","1","function"),//iP
	);
	
	protected function mypass(){
		return md5($_POST['password']);
	}
}
