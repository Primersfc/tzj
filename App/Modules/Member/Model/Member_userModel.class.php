<?php 
/**
 * 用户信息管理类
 * @author  <[c@easycms.cc]>
 */
class Member_userModel extends Model{
		protected $_validate=array(
		 array('username','/^[a-z0-9]{4,12}$/i','账号信息必须大于4位到12位字符之间'), //
		 array('username','require',"账号必须填写"), 
		 array('password','/^[a-z0-9]{6,16}$/i','密码不能少于6或大于16位之间'),
		 array('password','require','密码必须填写！'),  
		 array('password','require','确认密码必须填写！'),
		 array('verify','require','验证码必须填写！'), 
		 array('repassword','password','确认密码不正确',0,'confirm'),
		 array('email','email',"邮箱格式不正确"),  
		 array('pwd','require','密码必须填写！'),
		 array('rpwd','pwd','确认密码不正确',0,'confirm'),


		);

		
	

		
			


}