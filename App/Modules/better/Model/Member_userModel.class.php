<?php
/**
 * 自定义会员模型类
 * @author  <[c@easycms.cc]>
 */
class Member_userModel extends Model{
	
	//自动验证（参考手册中6.15自动验证）
	protected $_validate = array(
		 array('username','','帐号名称已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一
		 array('password','require','密码必须填写！'), //默认情况下用正则进行验证
		 array('email','email','邮箱格式错误',2),//不为空时验证
	);
	
//自动填充（参考手册中6.17自动完成）
	protected $_auto = array( 
		array('password',"mypass","2","callback"), //通过回调本类中的自定义方法对密码做处理
		
	);
	
	protected function mypass(){
		return substr(md5($_POST['password']),8,16);
	}
}
